---
name: create-gutenberg-block
description: >
  Build a new Gutenberg block for the starter-kit-theme (StarterKit Foundation). Use this skill
  for ANY request to create, add, scaffold, or build a block in this theme — "make a block",
  "add a block for X", "create a CF/Carbon Fields block", "add a dynamic block that shows the
  latest news" — and especially for requests to replicate an existing website as a page block
  ("replicate this site as a block", "clone this landing page into a block", or a
  `/make-template-block`-style request with a URL). Always consult this before writing any block
  code — it sequences the steps in the right order and the "block from a reference URL" workflow
  is not written down anywhere else.
---

# Creating a Gutenberg block in starter-kit-theme

This is the **procedure** — decide, scaffold, wire, build, verify. Full code examples (`Block.php`
skeleton, both `index.jsx` patterns, `view/layout.php`) and the *why* behind each gotcha
(REST-context `postId`, `usesContext`, asset registration internals) live in
`web/wp-content/themes/starter-kit-theme/blocks/CLAUDE.md` — this skill doesn't duplicate them.

**Read `blocks/CLAUDE.md` explicitly before step 2** — don't just assume it's already loaded. It
auto-loads on-demand when Claude *reads a file* under `blocks/`, but scaffolding via `cp -r` in
step 1 doesn't trigger that on its own; open `blocks/_StarterBlock/Block.php` (or any existing
block) as your first real action so the gotchas and code patterns are actually in context before
you write anything.

Two more theme docs matter here, not just `blocks/CLAUDE.md`:

- `conventions.md` — the `Helper\Utils` plain-vs-`*Fw` accessor split (step 3)
- `content-types.md` — how Carbon Fields containers actually get registered (step 6), and how
  `templates/`/`parts/`/`patterns/` are just block markup — a new block isn't "live" on the site
  until it's placed inside one of those (step 8)

## This is still a real WordPress Gutenberg block — don't lose sight of that

Everything above is theme-specific wiring, not a replacement for the actual WordPress block API.
`block.json`, `attributes`, `supports`, static vs. dynamic rendering, `RichText`/`InnerBlocks`/
`InspectorControls`, server-side rendering, block variations — all of that is **standard
WordPress**, documented in the official Block Editor Handbook, and this theme doesn't reinvent any
of it. What the theme changes is narrower than it might look:

| Standard WP concept                                             | How it actually works in this theme                                                                                                                                                                                                                                                                                                                                                            |
| --------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `register_block_type()` / `register_block_type_from_metadata()` | Called for you by `BlockAbstract::registerBlock()` — you never call it directly, you set `$this->blockArgs` and let the base class do it                                                                                                                                                                                                                                                       |
| `import { RichText } from '@wordpress/block-editor'`            | **Never** — this theme has no `@wordpress/*` npm packages. Same component, reached as `wp.blockEditor.RichText` (global). Every `@wordpress/*` package has a `wp.*` global equivalent — `@wordpress/blocks` → `wp.blocks`, `@wordpress/data` → `wp.data`, `@wordpress/components` → `wp.components`, `@wordpress/element` → `wp.element`. The APIs are identical, only the access path differs |
| `editorScript`/`style`/`viewScript` in `block.json`             | Left empty here — asset registration goes through `$blockAssets` in `Block.php` instead (see `blocks/CLAUDE.md`)                                                                                                                                                                                                                                                                               |
| `render_callback`                                               | Same WP concept, wired the same way (`register_block_type_from_metadata()`'s `$args['render_callback']`) — just assigned via `$this->blockArgs['render_callback']` instead of passed inline                                                                                                                                                                                                    |

So when you need to know *what a WordPress concept does* (what `usesContext` means, what
`supports.spacing` enables, how block variations work, what a `save()` function's contract is),
the official docs are the right source — read them normally, no theme-specific translation needed
for the concept itself:

- [Block Editor Handbook](https://developer.wordpress.org/block-editor/) — the full API surface
- [block.json reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/) — every field, what it does
- [Block attributes](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-attributes/), [Block supports](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/)
- [Dynamic blocks / server-side rendering](https://developer.wordpress.org/block-editor/getting-started/fundamentals/data-format/#dynamic-blocks)
- [Component reference](https://developer.wordpress.org/block-editor/reference-guides/components/) (`RichText`, `InnerBlocks`, `InspectorControls`, ...) — remember to mentally translate `@wordpress/x` → `wp.x` per the table above

Only translate *where* to reach an API (theme wrapper vs. raw WP function, `wp.*` global vs. npm
import) — never translate *what* the API does. When theme docs and this skill are silent on a
detail, that's a signal to check the handbook, not to guess.

All paths below are relative to `web/wp-content/themes/starter-kit-theme/` unless stated otherwise.

## 0. Decide the block type first

| Type                | Pick when                                                                    | `save()` in `index.jsx` | `view/` folder |
| ------------------- | ---------------------------------------------------------------------------- | ----------------------- | -------------- |
| Static              | Pure layout/markup, content baked into post HTML                             | real JSX                | none           |
| Dynamic             | Needs DB/meta/CPT data at render time                                        | `() => null`            | yes            |
| Full-page CF-backed | One block renders an entire page section from Carbon Fields meta on the post | `() => null`            | yes            |

Getting this wrong is the single biggest source of wasted work — a static block can't read post
meta, and a dynamic block that's missing `usesContext`/context handling renders silently empty
(see `blocks/CLAUDE.md`'s gotcha list before writing `Block.php`).

## 1. Scaffold from the starter block

```bash
cd web/wp-content/themes/starter-kit-theme
cp -r blocks/_StarterBlock blocks/MyBlock   # PascalCase folder name = the block's identity
```

Never edit `_StarterBlock` itself — it's the copy source, excluded from both the PHP autoloader
and the webpack glob because of its leading underscore.

## 2. `block.json`

Minimum required fields: `apiVersion: 3`, `name: "starter-kit/my-block"`, `category: "starter-kit"`.
Add `"usesContext": ["postId", "postType"]` **only** for dynamic/full-page-CF blocks that read post
meta — omit it entirely for static blocks (an unused `usesContext` isn't harmful, but it signals
"this reads context" to the next person reading the file, so keep it accurate).

## 3. `Block.php`

Namespace **must** match the folder name exactly: `namespace StarterKitBlocks\MyBlock;` for
`blocks/MyBlock/`. Extend `BlockAbstract`, declare `$blockAssets` for whatever `src/` files you'll
have (`editor_script` is always required; `style`/`editor_style`/`view_script` are optional — see
`blocks/CLAUDE.md` for the exact asset-type semantics). Static blocks leave
`registerBlockArgs()` empty; dynamic/CF blocks set `$this->blockArgs['render_callback']`.

If the block reads Carbon Fields meta, read it with `Utils::getPostMetaFw()` — **not**
`get_post_meta()` or `carbon_get_post_meta()` directly (see the theme's `conventions.md` for why
the two prefixes/accessor families exist and are not interchangeable).

## 4. `src/index.jsx`

Static → real `edit`/`save` with `RichText`/`InnerBlocks`. Dynamic/CF-backed → `edit` renders
`<ServerSideRender>`, `save: () => null`. Both patterns, plus the exact `useSelect`/`urlQueryArgs`
gotchas for getting `postId` correctly, are in `blocks/CLAUDE.md` — copy from there or from the
nearest existing block of the same type (`Section`/`Heading` for static, `News` for dynamic) rather
than writing either from scratch.

## 5. `view/layout.php` (dynamic and CF-backed blocks only)

Receives `$data` from the render callback. Escape everything on the way out: `esc_html()`,
`esc_url()`, `esc_attr()`, `wp_kses_post()` for anything that went through a rich-text/WYSIWYG
field. No raw `echo $data['whatever']` for user-editable content.

## 6. Carbon Fields meta (only if the block is CF-backed)

Add a handler class under `src/Handlers/Meta/PostMeta/` (or `TaxonomyMeta`/`UserMeta` as
appropriate) with a static `make()` that builds a `Container::make('post_meta', ...)`. Prefix every
field key with `SK_PREFIX` (`$p = SK_PREFIX . 'my_block_';`). This class does nothing by itself —
CF containers only register on the `carbon_fields_register_fields` hook, so:

## 7. Register the CF hook — one line in `src/Base/Hooks.php`

```php
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\MyBlock::class, 'make']);
```

Add it grouped with the other `carbon_fields_register_fields` lines in `initHooks()`. This is the
**only** manual registration step in the whole flow — the block itself is picked up automatically
by `Init::loadBlocks()` because it has a `block.json`; never add a block to `Hooks.php`.

If the block is meant to replace a still-enabled core block for editors (e.g. a custom
`starter-kit/heading` should be picked over `core/heading`), add the core block's name to
`gutenberg/disableRedundantBlocks` in `config/common/gutenberg.php` — otherwise both show up in the
inserter and nothing stops someone from picking the wrong one.

## 8. Place the block somewhere it actually renders

A scaffolded, registered block isn't "done" until it's used. For a block meant to appear on every
page of a given type, add it to the relevant file in `templates/`/`parts/`/`patterns/` — these are
just Gutenberg block markup with a WP-recognized file location (see `content-types.md`), so add a
`<!-- wp:starter-kit/my-block /-->`-style comment (with real attributes) where the block should
appear, the same way existing blocks are wired into e.g. `patterns/header.php`. For a block meant
to be used ad hoc by editors composing arbitrary pages, this step is unnecessary — it just needs to
show up in the block inserter, which registration alone already handles.

## 9. Build

```bash
npm run dev     # fast, unminified — use while iterating
npm run prod    # before calling it done
```

Nothing needs to be told *which* block to compile — `webpack.mix.js` globs every
`blocks/!(_)**/src/*` automatically.

## 10. Verify

WP-CLI only exists inside the `php` container, run from the **foundation root**, not the theme
dir:

```bash
# Is it registered at all?
docker compose exec php su -c "wp eval 'var_dump(WP_Block_Type_Registry::get_instance()->get_registered(\"starter-kit/my-block\"));'" www-data

# For CF-backed/dynamic blocks: does the render callback actually return HTML for a real post?
# See blocks/CLAUDE.md § "Debugging an empty block" for the eval-file recipe — quoting a
# multi-line PHP snippet through docker exec + su -c is not worth fighting with inline.
```

Then open the block in the editor and confirm it's not blank there either — `ServerSideRender`
failing silently in the editor is a different failure mode than the PHP callback itself being
broken, and the wp-cli check above only rules out the second one.

**Before calling the block done**, check `blocks/MyBlock/` doesn't have a leftover `build/` with no
matching `block.json`/`Block.php`/`src/` — easy to leave behind if a build runs before the PHP/JSX
source is saved, or if a block gets renamed/abandoned mid-work.

---

## Building a full-page block from a reference site (URL → block)

A distinct request shape: "replicate this site as a block", "clone this landing page", or a
`/make-template-block <URL> <BlockName>`-style ask. This is the **full-page CF-backed** block type
(step 0) taken to its natural conclusion — one block, filled with real scraped content by default,
whose CF fields let an admin override any of it later. The extra work here is turning an arbitrary
webpage into that block's content and design, which nothing else documents:

### Phase 1 — fetch and read the reference site

```bash
curl -s -L "$URL" -H "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36" -o /tmp/reference-site.html
grep -o 'href="[^"]*\.css[^"]*"' /tmp/reference-site.html   # find the page's own stylesheet(s)
curl -s "$CSS_URL" -o /tmp/reference-site.css
```

Read through the HTML/CSS to understand the page's actual section structure (hero, feature grid,
testimonials, pricing, ...) and its design tokens (colors, fonts, spacing) — a page builder like
Tilda wraps each visual section in its own container with a stable ID pattern (e.g. `<div
id="recXXX">`), which is usually the cleanest way to split the page into CF-field groups. Extract
per-section text, repeating items (use regex or just read the relevant chunks — whatever gets you
an accurate list of real headings/body copy/list items per section), and any embedded media
references (image URLs, `background-image` in CSS, YouTube IDs, `.woff`/`.woff2` font URLs).

### Phase 2 — download real assets into the block

```bash
mkdir -p blocks/MyBlock/assets
# for every image/font URL found in phase 1:
curl -s "$ASSET_URL" -o "blocks/MyBlock/assets/$(basename "$ASSET_URL" | cut -d'?' -f1)"
```

Reference them from PHP as `get_template_directory_uri() . '/blocks/MyBlock/assets/<file>'`.

### Phase 3 — map sections to Carbon Fields

Each visual section → a `separator` field (labels the group in wp-admin) + the fields for that
section's content. Repeating content (feature lists, testimonials, pricing tiers) → a `complex`
(repeater) field, not N separate flat fields.

**Set `->set_default_value()` with the real scraped content on every field.** The point of this
workflow is that the block looks like the reference site immediately, with zero admin input — CF
fields exist so an admin *can* change it later, not so they *have to* fill it in before it renders.
Mirror that same real-content-as-default in `view/layout.php`: `$title = $data['title'] ?: 'Real
Title From The Site';`, not an empty-string/placeholder fallback.

### Phase 4 — replicate the design in `src/style.scss`

Pull the reference site's real colors/fonts into CSS custom properties, load any downloaded
`.woff`/`.woff2` via `@font-face` pointing at `../assets/`, and mirror the section structure with
BEM-ish class names (`.block-name__hero`, `.block-name__pricing`, ...) rather than copying the
reference site's own class names verbatim — you're rebuilding the layout, not embedding their DOM.

### Phase 5 — build and verify

Same as steps 9–10 above, plus a visual check that the rendered block actually resembles the
reference site at both desktop and mobile widths (this theme is Bootstrap 5 grid-based — see
`blocks/CLAUDE.md`'s "IMPORTANT" section for the class conventions to reuse rather than hand-roll
new responsive CSS).
