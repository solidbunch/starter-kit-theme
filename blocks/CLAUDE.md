# Gutenberg Blocks

Blocks live in the theme's `blocks/` directory, namespace `StarterKitBlocks\`.
Auto-discovered: `Init::loadBlocks()` scans `blocks/*`, skips folders starting with `_` or missing
`block.json`, instantiates `StarterKitBlocks\{BlockName}\Block`. Start a new block by copying
`blocks/_StarterBlock/`. PHP patterns (handlers, Utils, security): see the theme `CLAUDE.md`.

## TWO block types — choose before writing code

|                         | Static block (default — most blocks)                 | Dynamic block (PHP render)                   |
| ----------------------- | ---------------------------------------------------- | -------------------------------------------- |
| Use when                | Pure markup/layout; content saved into post HTML     | Needs DB data, post meta, runtime content    |
| `registerBlockArgs()`   | empty                                                | sets `render_callback`                       |
| `save()` in `index.jsx` | real JSX (`RichText.Content`, `InnerBlocks.Content`) | `() => null`                                 |
| `view/` folder          | none                                                 | PHP templates (`layout.php`, ...)            |
| Examples                | Section, Heading, Button, Row, FaqSection            | News, PricingTable                           |

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

## Full-page CF-backed block

The "fill in fields, get a complete section" pattern — a dynamic block whose data comes from Carbon
Fields on the current post. Instead of building nested blocks in the editor, register CF fields and
let one block render the whole section:

```php
// 1. CF container in Meta/PostMeta/ (hook in Hooks.php on carbon_fields_register_fields):
$metaPrefix = SK_PREFIX . 'page_';
Container::make('post_meta', __('Page Content', 'starter-kit'))
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('text',    $metaPrefix . 'hero_title', __('Hero Title', 'starter-kit')),
        Field::make('image',   $metaPrefix . 'hero_image', __('Hero Image', 'starter-kit')),
        Field::make('complex', $metaPrefix . 'sections',   __('Sections', 'starter-kit'))
            ->add_fields('section', __('Section', 'starter-kit'), [
                Field::make('text',      'title',   __('Title', 'starter-kit')),
                Field::make('rich_text', 'content', __('Content', 'starter-kit')),
            ]),
    ]);

// 2. Dynamic block reads CF meta in the callback (always via Utils):
public function blockServerSideCallback(array $attributes, string $content, object $block): string {
    $postId     = get_the_ID();
    $metaPrefix = SK_PREFIX . 'page_';
    return $this->loadBlockView('layout', [
        'heroTitle'  => Utils::getPostMeta($postId, $metaPrefix . 'hero_title'),
        'heroImage'  => Utils::getPostMeta($postId, $metaPrefix . 'hero_image'),
        'sections'   => Utils::getPostMetaFw($postId, $metaPrefix . 'sections') ?: [],  // Fw for complex
        'blockClass' => $this->generateBlockClasses($attributes),
    ]);
}
// 3. view/layout.php renders the full section from CF data. Editor JSX = just ServerSideRender.
```

Admin fills CF fields in the post editor → one block renders the whole page section.

## IMPORTANT

- Use global `wp.*` — NEVER `@wordpress/` npm imports (not in the bundle config).
- Style with Bootstrap 5 classes (`bg-dark`, `text-center`, `col-lg-4`, ...) — the theme is Bootstrap-based.
- Block settings usually live under an object attribute (e.g. `attributes.modification`), not flat keys
  — copy the nearest existing block.
- `block.json`: `name` prefix is always `starter-kit/`, `category` is `starter-kit`, `apiVersion` 3.
- Never register a block manually in `Hooks.php` — auto-discovery handles it. Never skip `block.json`.
