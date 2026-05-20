# /make-template-block

Creates a full-page dynamic Gutenberg block that replicates a reference website's design.
The block uses Carbon Fields for content management — admin fills CF meta fields, PHP renders
the complete page.

**Usage:** `/make-template-block <URL> <BlockName>`

Example: `/make-template-block https://nemesh-art.com/ PageContent`

---

## Step 1 — Fetch and analyze the reference site

```bash
# Download full HTML
curl -s -L "$URL" \
  -H "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36" \
  -o /tmp/reference-site.html

# Find linked CSS files
grep -o 'href="[^"]*\.css[^"]*"' /tmp/reference-site.html

# Download the main stylesheet (pick the largest / page-specific one)
curl -s "$CSS_URL" -o /tmp/reference-styles.css
```

Extract the design system with Python:

```python
import re

with open('/tmp/reference-site.html') as f:
    html = f.read()
with open('/tmp/reference-styles.css') as f:
    css = f.read()

# Colors
colors = set(re.findall(r'(?:background-color|color):\s*(#[0-9a-fA-F]{3,8}|rgba?\([^)]+\))', html + css))
print("Colors:", sorted(colors))

# Fonts
fonts = re.findall(r"@font-face\{[^}]+\}", css)
print("Fonts:", fonts)

# Section backgrounds (find records/sections)
sections = re.findall(r'background-color:(#[0-9a-fA-F]{3,8}|rgba?\([^)]+\))', html[:50000])
print("Section BGs:", list(set(sections)))
```

Extract all page sections and their text content:

```python
# Find section boundaries (Tilda uses div id="recXXX", other builders vary)
import re

rec_starts = [(m.start(), m.group(1)) for m in re.finditer(r'<div id="(rec\d+|section[^"]*)"', html)]

for i, (start, sec_id) in enumerate(rec_starts):
    end = rec_starts[i+1][0] if i+1 < len(rec_starts) else len(html)
    chunk = html[start:end]
    clean = re.sub(r'<style[^>]*>.*?</style>', '', chunk, flags=re.DOTALL)
    clean = re.sub(r'<script[^>]*>.*?</script>', '', clean, flags=re.DOTALL)
    text  = re.sub(r'<[^>]+>', ' ', clean)
    text  = re.sub(r'\s+', ' ', text).strip()[:200]
    bgs   = re.findall(r'background-color:(#[0-9a-fA-F]{3,8}|rgba?\([^)]+\))', chunk[:3000])
    print(f"\nSECTION {i+1}: {sec_id} | BG: {bgs[:2]}")
    print(f"  {text}")
```

## Step 2 — Download all assets

```bash
ASSETS="blocks/$BLOCK_NAME/assets"
mkdir -p "$ASSETS"

# Extract image/font URLs and download them
python3 << 'EOF'
import re, subprocess

with open('/tmp/reference-site.html') as f:
    html = f.read()
with open('/tmp/reference-styles.css') as f:
    css = f.read()

# Images from HTML
imgs = re.findall(r"(?:data-original|src)='(https://[^']+(?:\.png|\.jpg|\.svg|\.webp))'", html)
# Background images from CSS/HTML inline styles
imgs += re.findall(r"background-image:url\('(https://[^']+)'\)", html + css)
# Font files
fonts = re.findall(r"url\('(https://[^']+\.woff2?)'\)", css)

all_assets = list(set(imgs + fonts))
for url in all_assets:
    filename = url.split('/')[-1].split('?')[0]
    print(f"curl -s '{url}' -o blocks/$BLOCK_NAME/assets/{filename}")
EOF
```

Note: SVG pricing cards, hero backgrounds, person photos, font WOFF files — download them all.
They will be referenced via `get_template_directory_uri() . '/blocks/BlockName/assets/'`.

## Step 3 — Map sections to CF fields

After analyzing the site structure, define CF fields that match each section.
Use `separator` fields to group sections visually in the admin.

Standard section types and their CF field patterns:

```php
// Hero section
Field::make('image', $p . 'hero_bg_image',    __('Hero: Background Image', 'starter-kit')),
Field::make('image', $p . 'hero_person_image', __('Hero: Person Photo', 'starter-kit')),
Field::make('text',  $p . 'hero_label',        __('Hero: Label/Badge', 'starter-kit')),
Field::make('text',  $p . 'hero_title',        __('Hero: Title', 'starter-kit')),
Field::make('text',  $p . 'hero_btn_text',     __('Hero: Button Text', 'starter-kit')),
Field::make('text',  $p . 'hero_btn_url',      __('Hero: Button URL', 'starter-kit')),

// Repeater (modules, reviews, features, pricing)
Field::make('complex', $p . 'modules', __('Modules', 'starter-kit'))
    ->set_collapsed(true)
    ->add_fields([
        Field::make('text',     'title', __('Title', 'starter-kit')),
        Field::make('textarea', 'items', __('Topics (one per line)', 'starter-kit')),
    ]),

// YouTube video reviews
Field::make('complex', $p . 'reviews', __('Review Videos', 'starter-kit'))
    ->set_collapsed(true)
    ->add_fields([
        Field::make('text', 'youtube_id', __('YouTube Video ID', 'starter-kit')),
    ]),

// Footer
Field::make('text',    $p . 'footer_company', __('Company Name', 'starter-kit')),
Field::make('text',    $p . 'footer_iban',    __('IBAN', 'starter-kit')),
Field::make('complex', $p . 'footer_links',   __('Footer Links', 'starter-kit'))
    ->add_fields([
        Field::make('text', 'label', __('Label', 'starter-kit'))->set_width(40),
        Field::make('text', 'url',   __('URL', 'starter-kit'))->set_width(60),
    ]),
```

Always set `->set_default_value()` for text fields so the block shows real content immediately.

## Step 4 — Create the block files

### block.json — CRITICAL: usesContext required for post meta blocks

```json
{
  "apiVersion": 3,
  "name": "starter-kit/block-name",
  "title": "Block Title (SK)",
  "category": "starter-kit",
  "icon": "skb skb-section",
  "description": "...",
  "usesContext": ["postId", "postType"],
  "supports": {},
  "attributes": {}
}
```

`"usesContext": ["postId", "postType"]` is MANDATORY for any block that reads post meta.
Without it, `$block->context['postId']` is always null → CF returns empty → block renders nothing.

### Block.php — always read postId from block context

```php
public function blockServerSideCallback(array $attributes, string $content, object $block): string
{
    // ALWAYS use block context — get_the_ID() returns 0 in REST API context
    $postId    = (int)($block->context['postId'] ?? get_the_ID());
    $p         = SK_PREFIX . 'page_';
    $assetsUrl = get_template_directory_uri() . '/blocks/BlockName/assets/';

    return $this->loadBlockView('layout', [
        'heroTitle'  => (string)Utils::getPostMetaFw($postId, $p . 'hero_title', ''),
        'modules'    => Utils::getPostMetaFw($postId, $p . 'modules') ?: [],
        'assetsUrl'  => $assetsUrl,
        'blockClass' => $this->generateBlockClasses($attributes),
    ]);
}
```

### src/index.jsx — CRITICAL: use post_id (underscore) not postId

```jsx
import metadata from '../block.json';

const {registerBlockType}                  = wp.blocks;
const {useBlockProps}                      = wp.blockEditor;
const {serverSideRender: ServerSideRender} = wp;
const {useSelect}                          = wp.data;

registerBlockType(metadata, {
    edit: (props) => {
        const blockProps = useBlockProps({className: ['block-name-editor']});
        // Must fetch postId here — no global post in editor context
        const postId = useSelect((select) => select('core/editor').getCurrentPostId());

        return (
            <div {...blockProps}>
                <ServerSideRender
                    block={metadata.name}
                    attributes={props.attributes}
                    urlQueryArgs={{post_id: postId}}  // ← UNDERSCORE, not camelCase postId
                />
            </div>
        );
    },
    save: () => null,
});
```

**Why `post_id` not `postId`**: WordPress REST block renderer reads the `post_id` query parameter
and uses it to populate `$block->context['postId']`. camelCase `postId` is silently ignored.

### src/style.scss — replicate the site's design system

```scss
// CSS variables from extracted design system
.block-name {
  --color-primary: #000000;    // extracted from site
  --color-accent:  #d3a634;    // extracted from site
  --color-cta:     #ff8562;    // extracted from site
  --font-main:     'FontName', Arial, sans-serif;

  // Load downloaded fonts
  @font-face {
    font-family: 'FontName';
    src: url('../assets/font-bold.woff') format('woff');
    font-weight: 700;
  }
}
```

### view/layout.php — hardcode real content as defaults

Always provide hardcoded defaults for all content. The block must look right immediately
without the admin filling any CF fields:

```php
// Use CF data or fallback to hardcoded defaults from the reference site
$modulesData = !empty($modules) ? $modules : [
    ['title' => 'Модуль 0. Введення', 'items' => "Topic 1\nTopic 2\nTopic 3"],
    // ... all modules from the reference site
];
```

## Step 5 — Register in Hooks.php

```php
// In src/Base/Hooks.php → initHooks():
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\BlockName::class, 'make']);
```

Block itself is auto-discovered — no hook needed for block registration.

## Step 6 — Build and verify

```bash
# Build
npm run production

# Verify block is registered
docker compose exec php wp --allow-root --path=/srv/web eval \
  'var_dump(WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/block-name"));'

# Verify CF fields are registered (38+ fields = good)
docker compose exec php wp --allow-root --path=/srv/web eval '
  do_action("carbon_fields_register_fields");
  $c = \Carbon_Fields\Carbon_Fields::resolve("container_repository")->get_containers();
  foreach ($c as $cont) {
    if ($cont instanceof \Carbon_Fields\Container\Post_Meta_Container) {
      echo $cont->get_id() . ": " . count($cont->get_fields()) . " fields\n";
    }
  }
'

# Test render with real postId
docker compose exec php wp --allow-root --path=/srv/web eval '
  do_action("carbon_fields_register_fields");
  $bt = WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/block-name");
  $b  = new WP_Block(
    ["blockName"=>"starter-kit/block-name","attrs"=>[],"innerBlocks"=>[],"innerHTML"=>"","innerContent"=>[]],
    ["postId"=>PAGE_ID,"postType"=>"page"]
  );
  $out = call_user_func($bt->render_callback, [], "", $b);
  echo "Output: " . strlen($out) . " chars\n";
  echo substr($out, 0, 500);
'
```

## Step 7 — Where to find CF meta fields in admin

Meta fields appear **below the block editor** when editing the page.
If the Gutenberg sidebar hides them: click `⋮` (top right) → **Preferences** → **Panels** → enable the container name.

CF meta boxes are visible on the page edit screen only when:
- The container's `->where('post_type', '=', 'page')` matches the current post type
- CF is booted (ThemeSettings::boot() on after_setup_theme)

---

## Quick checklist

- [ ] `block.json` has `"usesContext": ["postId", "postType"]`
- [ ] `Block.php` uses `(int)($block->context['postId'] ?? get_the_ID())`
- [ ] `index.jsx` uses `useSelect` to get `getCurrentPostId()`
- [ ] `index.jsx` passes `urlQueryArgs={{post_id: postId}}` (underscore!)
- [ ] All assets downloaded to `blocks/BlockName/assets/`
- [ ] CF hook added to `src/Base/Hooks.php`
- [ ] Hardcoded defaults for all content in `view/layout.php`
- [ ] `npm run production` runs without errors
- [ ] WP-CLI render test returns HTML > 1000 chars
