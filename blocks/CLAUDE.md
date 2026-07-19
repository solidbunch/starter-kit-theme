# Gutenberg Blocks

Blocks live in the theme's `blocks/` directory, namespace `StarterKitBlocks\`.
Auto-discovered: `Init::loadBlocks()` scans `blocks/*`, skips folders starting with `_` or missing
`block.json`, instantiates `StarterKitBlocks\{BlockName}\Block`. Start a new block by copying
`blocks/_StarterBlock/`. PHP patterns (handlers, Utils, security): see the theme `CLAUDE.md`.
`blocks/_*/` is listed under `composer.json`'s `autoload.exclude-from-classmap` — an
underscore-prefixed folder never matches its PSR-4 namespace (e.g. `StarterKitBlocks\StarterBlock`
in `_StarterBlock/`), a real mismatch Composer would otherwise warn about on every `dump-autoload`.
The pattern covers every folder the loader's underscore-skip convention covers; this is the fix,
not a workaround to remove.

## TWO block types — choose before writing code

|                         | Static block (default — most blocks)                 | Dynamic block (PHP render)                |
| ----------------------- | ---------------------------------------------------- | ----------------------------------------- |
| Use when                | Pure markup/layout; content saved into post HTML     | Needs DB data, post meta, runtime content |
| `registerBlockArgs()`   | empty                                                | sets `render_callback`                    |
| `save()` in `index.jsx` | real JSX (`RichText.Content`, `InnerBlocks.Content`) | `() => null`                              |
| `view/` folder          | none                                                 | PHP templates (`layout.php`, ...)         |
| Examples                | Section, Heading, Button, Row, FaqSection            | News, PricingTable                        |

## Folder structure

```
blocks/MyBlock/         # PascalCase; prefix _ skips auto-discovery
  block.json            # apiVersion 3, name "starter-kit/my-block", category "starter-kit"
  Block.php             # extends BlockAbstract
  src/                  # SOURCE — compiled by Laravel Mix
    index.jsx           # editor + save logic — ALWAYS present
    style.scss          # frontend + editor styles (optional)
    editor.scss         # editor-only styles (optional)
    view.js             # frontend-only JS (optional)
  view/                 # PHP templates — DYNAMIC blocks ONLY
    layout.php
  build/                # compiled output — git-ignored, NEVER edit by hand
```

## Block.php

Extends `BlockAbstract`, declares `$blockAssets`. File names there are the COMPILED `.js`/`.css`:

```php
class Block extends BlockAbstract {
    protected array $blockAssets = [
        'editor_script' => ['file' => 'index.js', 'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor']],
        'style'         => ['file' => 'style.css', 'dependencies' => []],   // optional: frontend + editor
        'editor_style'  => ['file' => 'editor.css', 'dependencies' => []],  // optional: editor only
        'view_script'   => ['file' => 'view.js', 'dependencies' => []],     // optional: frontend only
    ];

    public function registerBlockArgs(): void {
        // STATIC block: leave empty
        // DYNAMIC block: $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
    }

    public function blockRestApiEndpoints(): void {
        // optional: register_rest_route(SK_REST_API_NS, '/endpoint', [...]);
    }
}
```

Asset types: `editor_script`/`editor_style` (admin only), `style`/`script` (both contexts),
`view_script`/`view_style` (frontend only). `editor_script` is always required.

**Assets are never declared in `block.json`** — leave `editorScript`/`style`/etc. empty there.
`$blockAssets` is the whole mechanism: `registerBlockAssets()` (called from the constructor, before
`registerBlock()`) turns each entry into a `wp_register_script()`/`wp_register_style()` call with
real dependency arrays, computes the handle from the block name + filename, and versions by
`filemtime()`. This exists specifically because `block.json`'s own `editorScript`/`style` fields
can't express script dependencies — `$blockAssets`'s `dependencies` array (also filterable via
`starter_kit/block_asset_dependencies`) is the only way to wire e.g. `wp-i18n`/`wp-element` deps
per block. Frontend scripts are registered with `'strategy' => 'defer', 'in_footer' => true`
(admin/editor scripts get neither).

This deliberately avoids WordPress's own standard alternative — the `@wordpress/scripts` /
`dependency-extraction-webpack-plugin` generated `*.asset.php` file, manually `include`-d and fed
into `wp_register_script()`. That pattern is a known opaque/fragile spot in the WP ecosystem (no
visibility into what gets extracted, breaks under webpack's `runtimeChunk: 'single'`, JS-only
cache-busting hash misses CSS-only changes) — serious enough that WordPress's own `@wordpress/build`
tooling (2026) replaces it with convention-based auto-registration. `$blockAssets` sidesteps all of
that with an explicit, readable PHP array instead of a generated black box.

## Static block — the default

`registerBlockArgs()` empty. `index.jsx` has a real `save()`; output is stored in post HTML, no PHP
rendering. Layout blocks use `InnerBlocks`; text blocks use `RichText`.

```jsx
const {registerBlockType} = wp.blocks;
const {useBlockProps, RichText, InnerBlocks, InspectorControls} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;

registerBlockType(metadata, {
    edit: ({attributes, setAttributes}) => {
        const blockProps = useBlockProps({className: ['my-block']});
        return <div {...blockProps}>
            <RichText value={attributes.content} onChange={(content) => setAttributes({content})} />
        </div>;
    },
    save: ({attributes}) => {
        const {className} = useBlockProps.save();
        return <div className={className}><RichText.Content value={attributes.content} /></div>;
    },
});
```

## Dynamic block — PHP-rendered

`registerBlockArgs()` sets the callback. `save: () => null`. PHP renders via a `view/` template.

```php
public function registerBlockArgs(): void {
    $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];  // key assignment, not full array
}

public function blockServerSideCallback(array $attributes, string $content, object $block): string {
    $templateData = [
        'items'      => NewsRepository::get([]),
        'blockClass' => $this->generateBlockClasses($attributes),  // merges className + spacers
    ];
    return $this->loadBlockView('layout', $templateData);  // → view/layout.php
}
```

`view/layout.php` — receives `$data`, is the rendered HTML:

```php
defined('ABSPATH') || exit;
$data = $data ?? [];
?>
<div class="news <?php echo $data['blockClass']; ?>">
    <?php foreach ($data['items'] as $item) : ?>
        <h3><?php echo esc_html($item->post_title); ?></h3>
    <?php endforeach; ?>
</div>
```

`index.jsx` — editor shows `ServerSideRender`, `save` returns null:

```jsx
const {serverSideRender: ServerSideRender} = wp;
registerBlockType(metadata, {
    edit: (props) => <div {...useBlockProps()}>
        <ServerSideRender block={metadata.name} attributes={props.attributes} /></div>,
    save: () => null,
});
```

## ⚠️ Dynamic block + post meta: CRITICAL GOTCHAS

These cause silent failures (empty block in editor) and are easy to miss:

### 1. `usesContext` is REQUIRED in block.json

Dynamic blocks that read post meta MUST declare usesContext — without it `$block->context['postId']`
is always empty:

```json
{
  "usesContext": ["postId", "postType"]
}
```

### 2. `get_the_ID()` returns 0 in REST context

WordPress's REST block renderer does NOT set up the global `$post`. Always read from block context:

```php
// ❌ WRONG — returns 0 or false when rendered via ServerSideRender REST call
$postId = get_the_ID();

// ✅ CORRECT — block context is populated by WP when usesContext is set
$postId = (int)($block->context['postId'] ?? get_the_ID());
```

### 3. ServerSideRender `urlQueryArgs` must use `post_id` (underscore, not camelCase)

WP REST block renderer maps `post_id` query param → block context. camelCase `postId` is silently
ignored:

```jsx
// ❌ WRONG — WP REST API ignores this, block gets postId=0
urlQueryArgs={{postId: postId}}

// ✅ CORRECT — WP reads ?post_id=X and populates context["postId"]
urlQueryArgs={{post_id: postId}}
```

### 4. Editor JSX must fetch current post ID with `useSelect`

`ServerSideRender` runs in the editor context where there is no global post. Get the ID explicitly:

```jsx
const {registerBlockType} = wp.blocks;
const {useBlockProps}     = wp.blockEditor;
const {serverSideRender: ServerSideRender} = wp;
const {useSelect}         = wp.data;

registerBlockType(metadata, {
    edit: (props) => {
        const blockProps = useBlockProps({className: ['my-block-editor']});
        // ✅ must use useSelect — no other way to get postId in editor
        const postId = useSelect((select) => select('core/editor').getCurrentPostId());

        return (
            <div {...blockProps}>
                <ServerSideRender
                    block={metadata.name}
                    attributes={props.attributes}
                    urlQueryArgs={{post_id: postId}}  // ← underscore, not camelCase
                />
            </div>
        );
    },
    save: () => null,  // always null for dynamic blocks
});
```

### 5. Debugging an empty block

If the block renders nothing, check in order. Run from the foundation root — there's no bare `wp`
on the host, WP-CLI only exists inside the `php` container:

```bash
# Every wp-cli call below runs like this:
#   docker compose exec php su -c "wp <command>" www-data
# 1. Is the block registered?
docker compose exec php su -c "wp eval 'var_dump(WP_Block_Type_Registry::get_instance()->get_registered(\"starter-kit/my-block\"));'" www-data

# 2. Does the render callback actually return HTML? Quoting this inline gets messy through
# `docker compose exec` + `su -c`, so write it to a file on the host and eval-file it from inside
# the container — `docker-compose.yml` bind-mounts `./web/wp-content` to `/srv/web/wp-content`,
# so anything written under the theme dir on the host is immediately visible in the container:
cat > blocks/debug-block.php <<'PHP'
do_action("carbon_fields_register_fields");
$blockType = WP_Block_Type_Registry::get_instance()->get_registered("starter-kit/my-block");
$block = new WP_Block(
  ["blockName"=>"starter-kit/my-block","attrs"=>[],"innerBlocks"=>[],"innerHTML"=>"","innerContent"=>[]],
  ["postId"=>YOUR_POST_ID,"postType"=>"page"]
);
$cb = $blockType->render_callback;
echo call_user_func($cb, [], "", $block);
PHP
docker compose exec php su -c "wp eval-file /srv/web/wp-content/themes/starter-kit-theme/blocks/debug-block.php" www-data
rm blocks/debug-block.php   # scratch file — delete it, never commit it
# Note: render_block($block->parsed_block) does NOT pass context — use render_callback directly
```

## IMPORTANT

- Use global `wp.*` — NEVER `@wordpress/` npm imports: they aren't in this theme's bundle config
  (Laravel Mix, no `@wordpress/scripts`/dependency-extraction-webpack-plugin), and WordPress core
  already loads these packages as `wp.*` on every admin page — importing them from npm would
  bundle a second copy of React/element/etc. into each block's compiled JS instead of reusing the
  one WP already loaded (this is the same reasoning behind WP core's own externals mechanism, see
  the [Dependency Extraction Webpack Plugin docs](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-dependency-extraction-webpack-plugin/)).
- Style with Bootstrap 5 classes (`bg-dark`, `text-center`, `col-lg-4`, ...) — the theme is Bootstrap-based.
- Block settings usually live under an object attribute (e.g. `attributes.modification`), not flat keys
  — copy the nearest existing block.
- `block.json`: `name` prefix is always `starter-kit/`, `category` is `starter-kit`, `apiVersion` 3.
- Never register a block manually in `Hooks.php` — auto-discovery handles it. Never skip `block.json`.
