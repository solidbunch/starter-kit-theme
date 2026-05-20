---
name: create-gutenberg-block
description: >
  Create Gutenberg blocks for the starter-kit-theme project (StarterKit Foundation).
  Use this skill for ANY request to create, add, or build a block — including "make a block",
  "add a CF block", "create a page template block", "replicate a site as a block", or when the
  user runs /make-template-block. Always apply before writing any block code — contains critical
  gotchas that cause empty blocks without this skill.
---

# StarterKit Foundation — Gutenberg Block Creation

## Project paths (absolute, use these)

| What | Path |
|------|------|
| Theme root | `web/wp-content/themes/starter-kit-theme/` |
| Blocks | `web/wp-content/themes/starter-kit-theme/blocks/` |
| Starter template | `blocks/_StarterBlock/` — copy this, never edit it |
| CF meta handlers | `web/wp-content/themes/starter-kit-theme/src/Handlers/Meta/PostMeta/` |
| Hook registry | `web/wp-content/themes/starter-kit-theme/src/Base/Hooks.php` |
| WP-CLI | `docker compose exec php wp --allow-root --path=/srv/web` |
| Build | `cd web/wp-content/themes/starter-kit-theme && npm run production` |
| Lint | `cd web/wp-content/themes/starter-kit-theme && npm run lint` |

**`SK_PREFIX = 'skt_'`** — always present as a PHP constant, never hardcode the string.

---

## Block types — decide first

| Type | Use when | `save()` | `view/` folder |
|------|----------|----------|----------------|
| **Static** | Pure layout, content in post HTML, no DB | real JSX | no |
| **Dynamic** | Reads post meta, CPT queries, runtime data | `() => null` | yes, `layout.php` |
| **Template block** | One block = full page, content from CF fields | `() => null` | yes + `assets/` |

---

## ⚠️ CRITICAL GOTCHAS — dynamic blocks with post meta

These cause **silent failures** (block renders empty in editor). No errors, just blank output.

### 1. block.json — `usesContext` is mandatory

Without this, `$block->context['postId']` is always `null` → CF reads from post 0 → empty.

```json
{
  "usesContext": ["postId", "postType"]
}
```

### 2. Block.php — never use `get_the_ID()` alone

```php
// ❌ WRONG — REST API context has no global $post, returns 0
$postId = get_the_ID();

// ✅ CORRECT — always prefer block context
$postId = (int)($block->context['postId'] ?? get_the_ID());
```

### 3. index.jsx — `urlQueryArgs` key is `post_id` (underscore, not camelCase)

```jsx
// ❌ WRONG — WP REST silently ignores this, block gets postId=0
urlQueryArgs={{postId: postId}}

// ✅ CORRECT — WP reads ?post_id=X → populates context["postId"]
urlQueryArgs={{post_id: postId}}
```

### 4. index.jsx — get postId via `useSelect`, not a global

```jsx
const {useSelect} = wp.data;
const postId = useSelect((select) => select('core/editor').getCurrentPostId());
```

### 5. Debugging an empty block — use render_callback directly

`render_block($block->parsed_block)` does NOT pass context. Always test like this:

```bash
docker compose exec php wp --allow-root --path=/srv/web eval '
  do_action("carbon_fields_register_fields");
  $bt = WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/my-block");
  $b  = new WP_Block(
    ["blockName"=>"starter-kit/my-block","attrs"=>[],"innerBlocks"=>[],"innerHTML"=>"","innerContent"=>[]],
    ["postId"=>PAGE_ID,"postType"=>"page"]
  );
  echo strlen(call_user_func($bt->render_callback, [], "", $b)) . " chars\n";
  echo substr(call_user_func($bt->render_callback, [], "", $b), 0, 500);
'
```

---

## Step-by-step: create any block

### 1. Create block folder (copy from _StarterBlock)

```bash
THEME="web/wp-content/themes/starter-kit-theme"
cp -r "$THEME/blocks/_StarterBlock" "$THEME/blocks/MyBlock"
```

Folder name = PascalCase. Folders starting with `_` are skipped by auto-discovery.

### 2. block.json — minimum required fields

```json
{
  "apiVersion": 3,
  "name": "starter-kit/my-block",
  "title": "My Block (SK)",
  "category": "starter-kit",
  "icon": "skb skb-section",
  "description": "Short description",
  "keywords": ["My", "Block"],
  "textdomain": "",
  "styles": [],
  "supports": {},
  "usesContext": ["postId", "postType"],
  "example": {},
  "attributes": {}
}
```

For **static blocks**: remove `usesContext` (not needed).
For **dynamic/template blocks**: keep `usesContext` — mandatory.

### 3. Block.php — namespace matches folder name exactly

```php
<?php

namespace StarterKitBlocks\MyBlock;  // ← must match folder name

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Utils;
use Throwable;

class Block extends BlockAbstract
{
    protected array $blockAssets = [
        'editor_script' => [
            'file'         => 'index.js',
            'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
        ],
        'editor_style'  => ['file' => 'editor.css', 'dependencies' => []],
        'style'         => ['file' => 'style.css',  'dependencies' => []],
        // 'view_script' => ['file' => 'view.js',   'dependencies' => []],  // frontend JS only
    ];

    // ── STATIC BLOCK: leave empty ──
    // ── DYNAMIC BLOCK: set render_callback ──
    public function registerBlockArgs(): void
    {
        $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
    }

    /**
     * @throws Throwable
     */
    public function blockServerSideCallback(array $attributes, string $content, object $block): string
    {
        $postId    = (int)($block->context['postId'] ?? get_the_ID()); // never just get_the_ID()
        $p         = SK_PREFIX . 'page_';                              // SK_PREFIX = 'skt_'
        $assetsUrl = get_template_directory_uri() . '/blocks/MyBlock/assets/';

        return $this->loadBlockView('layout', [
            'title'      => (string)Utils::getPostMetaFw($postId, $p . 'title', ''),
            'items'      => Utils::getPostMetaFw($postId, $p . 'items') ?: [],
            'assetsUrl'  => $assetsUrl,
            'blockClass' => $this->generateBlockClasses($attributes),
        ]);
    }

    public function blockRestApiEndpoints(): void {}
}
```

`Utils::getPostMetaFw()` — **always** use this for CF fields (auto-prefixes, handles complex fields).
`Utils::getPostMeta()` — for plain WP meta only.
Never call `carbon_get_post_meta()` or `get_post_meta()` directly.

### 4. src/index.jsx — two patterns

**Static block:**
```jsx
import metadata from '../block.json';
const {registerBlockType}                           = wp.blocks;
const {useBlockProps, RichText, InnerBlocks,
       InspectorControls}                           = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl}   = wp.components;

registerBlockType(metadata, {
    edit: ({attributes, setAttributes}) => {
        const blockProps = useBlockProps({className: ['my-block']});
        return (
            <div {...blockProps}>
                <RichText tagName="h2"
                          value={attributes.title}
                          onChange={(title) => setAttributes({title})} />
                <InnerBlocks />
            </div>
        );
    },
    save: ({attributes}) => (
        <div className="my-block">
            <RichText.Content tagName="h2" value={attributes.title} />
            <InnerBlocks.Content />
        </div>
    ),
});
```

**Dynamic / Template block:**
```jsx
import metadata from '../block.json';
const {registerBlockType}                  = wp.blocks;
const {useBlockProps}                      = wp.blockEditor;
const {serverSideRender: ServerSideRender} = wp;
const {useSelect}                          = wp.data;

registerBlockType(metadata, {
    edit: (props) => {
        const blockProps = useBlockProps({className: ['my-block-editor']});
        const postId = useSelect((select) => select('core/editor').getCurrentPostId());

        return (
            <div {...blockProps}>
                <ServerSideRender
                    block={metadata.name}
                    attributes={props.attributes}
                    urlQueryArgs={{post_id: postId}}
                />
            </div>
        );
    },
    save: () => null,
});
```

Never import from `@wordpress/` — always use global `wp.*`.

### 5. view/layout.php — template for dynamic blocks

```php
<?php
/**
 * My Block template
 * @var $data array
 */
defined('ABSPATH') || exit;

$data       = $data ?? [];
$title      = esc_html($data['title'] ?? '');
$items      = $data['items'] ?? [];
$blockClass = esc_attr($data['blockClass'] ?? '');
$assetsUrl  = esc_url($data['assetsUrl'] ?? '');
?>
<div class="my-block<?php echo $blockClass ? ' ' . $blockClass : ''; ?>">
    <?php if ($title) : ?>
        <h2 class="my-block__title"><?php echo $title; ?></h2>
    <?php endif; ?>
    <?php foreach ($items as $item) : ?>
        <div class="my-block__item"><?php echo esc_html($item['text'] ?? ''); ?></div>
    <?php endforeach; ?>
</div>
```

Escape everything: `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()` for rich text.

### 6. CF meta handler — src/Handlers/Meta/PostMeta/MyBlock.php

```php
<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class MyBlock
{
    public static function make(): void
    {
        $p = SK_PREFIX . 'page_';  // results in 'skt_page_'

        Container::make('post_meta', __('My Block', 'starter-kit'))
                 ->where('post_type', '=', 'page')
                 ->set_priority('default')
                 ->add_fields([

                     // Use separator fields to visually group sections in the admin
                     Field::make('separator', $p . 'sep_hero', __('Hero Section', 'starter-kit')),

                     Field::make('text', $p . 'title', __('Title', 'starter-kit'))
                          ->set_default_value('Default Title'),

                     Field::make('image', $p . 'image', __('Image', 'starter-kit')),

                     Field::make('complex', $p . 'items', __('Items', 'starter-kit'))
                          ->set_collapsed(true)
                          ->setup_labels([
                              'plural_name'   => __('Items', 'starter-kit'),
                              'singular_name' => __('Item', 'starter-kit'),
                          ])
                          ->add_fields([
                              Field::make('text',     'title', __('Title', 'starter-kit')),
                              Field::make('textarea', 'text',  __('Text', 'starter-kit')),
                              Field::make('image',    'image', __('Image', 'starter-kit'))->set_width(30),
                          ]),

                 ]);
    }
}
```

**CF field gotchas (from theme CLAUDE.md):**
- `checkbox` → returns `'yes'` / `''`, NOT `true`/`false`
- `complex` (repeater) → always returns `array[]`, read with `Utils::getPostMetaFw()`
- `relationship` is deprecated → use `association`
- `select` options: `['value' => 'Label']`
- `->set_width(30)` makes field take 30% of the row width
- `->set_default_value()` shows value immediately without admin filling anything

### 7. Register CF hook — src/Base/Hooks.php

Add ONE line in `initHooks()`, grouped with other CF hooks (around line 62-65):

```php
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\MyBlock::class, 'make']);
```

Block registration is **automatic** — `Init::loadBlocks()` discovers `blocks/MyBlock/` at runtime.
Never register blocks manually in Hooks.php.

### 8. Build

```bash
cd web/wp-content/themes/starter-kit-theme
npm run production   # or: npm run development / npm run watch
```

---

## Template block from URL reference — full workflow

When the user gives a URL and says "replicate this", "make a block like this site":

### Phase 1: Download and parse

```bash
# Download HTML
curl -s -L "https://example.com/" \
  -H "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36" \
  -o /tmp/ref.html && wc -c /tmp/ref.html

# Find and download the page-specific CSS (usually the largest .css file)
grep -o 'href="[^"]*\.css[^"]*"' /tmp/ref.html
curl -s "https://..." -o /tmp/ref.css && wc -c /tmp/ref.css
```

### Phase 2: Extract design system

```python
import re

with open('/tmp/ref.html') as f: html = f.read()
with open('/tmp/ref.css') as f:  css  = f.read()

# === Design tokens ===
colors = set(re.findall(r'(?:background-color|color):\s*(#[0-9a-fA-F]{3,8}|rgba?\([^)]+\))', html + css))
fonts  = re.findall(r'@font-face\{[^}]+\}', css)
print("Colors:", sorted(colors))
print("Fonts:", fonts[:3])

# === Page sections (Tilda sites use div id="recXXX") ===
rec_starts = [(m.start(), m.group(1)) for m in re.finditer(r'<div id="(rec\d+)"', html)]
for i, (start, sid) in enumerate(rec_starts):
    end   = rec_starts[i+1][0] if i+1 < len(rec_starts) else len(html)
    chunk = html[start:end]
    bgs   = re.findall(r'background-color:(#[0-9a-fA-F]{3,8}|rgba?\([^)]+\))', chunk[:3000])
    clean = re.sub(r'<(?:style|script)[^>]*>.*?</(?:style|script)>', '', chunk, flags=re.DOTALL)
    text  = re.sub(r'<[^>]+>', ' ', clean)
    text  = re.sub(r'\s+', ' ', text).strip()[:250]
    print(f"\nSECTION {i+1} ({sid}) | BG: {bgs[:2]}\n  {text}")

# === Extract all text content per section (tn-atom for Tilda) ===
for i, (start, sid) in enumerate(rec_starts):
    end   = rec_starts[i+1][0] if i+1 < len(rec_starts) else len(html)
    chunk = html[start:end]
    clean = re.sub(r'<style[^>]*>.*?</style>', '', chunk, flags=re.DOTALL)
    atoms = re.findall(r"<div class='tn-atom'[^>]*field='[^']*'>(.*?)</div>", clean, re.DOTALL)
    texts = [re.sub(r'<[^>]+>', '', a).strip() for a in atoms if re.sub(r'<[^>]+>', '', a).strip()]

    # Catalog items (Tilda t778 block = product grid)
    titles = re.findall(r'class="t778__title[^"]*"[^>]*>(.*?)</div>', clean, re.DOTALL)
    descrs = re.findall(r'class="t778__descr[^"]*"[^>]*>(.*?)</div>\s*<div class="t778__price', clean, re.DOTALL)
    if titles:
        for t, d in zip(titles, descrs):
            tc = re.sub(r'<[^>]+>', '', t).strip()
            items = re.findall(r'<li[^>]*>(.*?)</li>', d, re.DOTALL)
            print(f"\n  MODULE: {tc}")
            for item in items: print(f"    • {re.sub('<[^>]+>','',item).strip()}")
    for t in texts:
        if len(t) > 3: print(f"  TEXT: {t[:100]}")

    # YouTube embeds
    yt = re.findall(r'data-youtubeid="([^"]+)"', chunk)
    if yt: print(f"  YOUTUBE: {yt}")
```

### Phase 3: Download all assets

```bash
ASSETS="web/wp-content/themes/starter-kit-theme/blocks/MyBlock/assets"
mkdir -p "$ASSETS"
```

```python
# Get all downloadable URLs
imgs  = re.findall(r"data-original='(https://[^']+(?:\.png|\.jpg|\.svg|\.webp))'", html)
imgs += re.findall(r"background-image:url\('(https://[^']+)'\)", html + css)
woffs = re.findall(r"url\('(https://[^']+\.woff2?)'\)", css)

for url in sorted(set(imgs + woffs)):
    fname = url.split('/')[-1].split('?')[0]
    print(f"curl -s '{url}' -o {ASSETS}/{fname}")
```

Then run the printed curl commands. Reference them in PHP as:
```php
$assetsUrl = get_template_directory_uri() . '/blocks/MyBlock/assets/';
// e.g. $assetsUrl . 'hero-bg.svg'
```

### Phase 4: Map sections → CF fields

Each visual section on the site → a `separator` + group of CF fields.
Repeating items (modules, reviews, pricing cards) → `complex` (repeater) field.
YouTube reviews → `complex` with `youtube_id` text field.

**Always set `->set_default_value()` with real content from the site** so the block renders
correctly with zero admin input. Admin can override via CF, but defaults show the real design.

### Phase 5: view/layout.php — hardcode real content as fallback

```php
// Use CF data or fall back to real content scraped from the reference site
$modulesData = !empty($modules) ? $modules : [
    ['title' => 'Real Module 0 Title',   'items' => "Topic 1\nTopic 2\nTopic 3"],
    ['title' => 'Real Module 1 Title',   'items' => "Topic A\nTopic B"],
    // ... all content from the reference site
];
// This means the block looks right immediately, even before admin fills any CF fields
```

### Phase 6: style.scss — replicate the site's design system

```scss
.block-name {
  --color-bg:     #000000;    // extracted from site CSS
  --color-accent: #d3a634;    // gold
  --color-cta:    #ff8562;    // orange button
  --font-main:    'FontName', Arial, sans-serif;

  // Load downloaded fonts
  @font-face {
    font-family: 'FontName';
    src: url('../assets/font-bold.woff') format('woff');
    font-weight: 700;
    font-display: swap;
  }

  // Mirror the site's section structure
  background-color: var(--color-bg);

  &__hero { background-color: var(--color-bg); min-height: 100vh; ... }
  &__section-name { background-color: ...; padding: ...; }
}
```

---

## Verify before declaring done

```bash
# 1. Build succeeds
cd web/wp-content/themes/starter-kit-theme && npm run production

# 2. Block is registered
docker compose exec php wp --allow-root --path=/srv/web eval \
  'var_dump(WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/my-block") !== null);'

# 3. CF container has all fields
docker compose exec php wp --allow-root --path=/srv/web eval '
  do_action("carbon_fields_register_fields");
  foreach (\Carbon_Fields\Carbon_Fields::resolve("container_repository")->get_containers() as $c) {
    if ($c instanceof \Carbon_Fields\Container\Post_Meta_Container)
      echo $c->get_id() . ": " . count($c->get_fields()) . " fields\n";
  }
'

# 4. Block renders real HTML with a page postId
docker compose exec php wp --allow-root --path=/srv/web eval '
  do_action("carbon_fields_register_fields");
  $bt  = WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/my-block");
  $b   = new WP_Block(
    ["blockName"=>"starter-kit/my-block","attrs"=>[],"innerBlocks"=>[],"innerHTML"=>"","innerContent"=>[]],
    ["postId"=>PAGE_ID,"postType"=>"page"]
  );
  $out = call_user_func($bt->render_callback, [], "", $b);
  echo strlen($out) . " chars\n";
  // Check key sections present
  foreach (["expected-class", "Expected Text"] as $check)
    echo (str_contains($out, $check) ? "✓" : "✗") . " $check\n";
'
```

---

## Where to find CF fields in the admin

Meta fields are **below the block editor** on the page edit screen.

If hidden: click `⋮` (top right of editor) → **Preferences** → **Panels** → enable the container.

Conditions for meta boxes to appear:
- Container's `->where('post_type', '=', 'page')` matches the post type being edited
- CF is booted (`ThemeSettings::boot()` runs on `after_setup_theme` via Hooks.php)
- The `carbon_fields_register_fields` hook ran (verify with WP-CLI check above)

---

## Hard rules for this project

- `wp.*` globals only — never `import from '@wordpress/...'`
- Hooks only in `src/Base/Hooks.php` → `initHooks()`
- CF meta only via `Utils::getPostMetaFw()` / `Utils::getPostMeta()`
- Block auto-discovered — never register in Hooks.php manually
- All PHP PSR-12, typed properties, return types on public methods
- Never `get_the_ID()` alone in dynamic block callbacks
- Always `urlQueryArgs={{post_id: postId}}` in ServerSideRender (underscore)
- Always `"usesContext": ["postId", "postType"]` in block.json for CF-reading blocks
