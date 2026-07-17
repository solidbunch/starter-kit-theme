# Conversion manifest — data the `convert-to-classic-theme` skill consumes

Scope: remove FSE, keep Gutenberg/blocks. Never touch `blocks/*`.

## Delete (always)

- `templates/*.html`
- `parts/*.html`
- `patterns/*.php`

## Edit (always)

- `theme.json` — remove the `customTemplates` array only. Keep the file (block editor settings —
  palette, spacing, `appearanceTools` — still apply to whichever post types keep the block
  editor). Do not delete `theme.json`. **Data caveat:** pages already assigned a custom template
  (`page-with-hero`, `page-without-title`) store that choice in `_wp_page_template` post meta; once
  the templates are gone those pages silently fall back to `page.php` (e.g. a "Page without Title"
  page starts showing its `<h1>` title again). Flag this to the user — if any live page uses one of
  these, either recreate the template as a classic `Template Name:` PHP file or migrate the page.
- `src/Handlers/SetupTheme.php` — add `SetupTheme.snippet.php`'s two `add_theme_support` lines
  (`title-tag`, `post-thumbnails`) to `addThemeSupport()`. A block theme gets both implicitly from
  core; a classic theme must declare them or it loses the Featured Image metabox and emits no
  document `<title>`. Keep every other line in the method.
- `config/common/gutenberg.php` — merge in `gutenberg.snippet.php`'s `blockEditorPostTypes` key
  (ask the user for the allowlist first; default `['post', 'news']`). Apply this **before** the
  `Hooks.php` filter line below — `BlockEditorSupport::filterPostType()` reads this key, and a
  filter active on a config that lacks it would otherwise degrade to core's default editor per type.
- `src/Base/Hooks.php` — apply `Hooks.snippet.php`'s two new lines. Every existing line in
  `Hooks.php` stays, including all block-related hooks (`loadBlocks`, `loadBlocksCategories`,
  `addSpacerAttributeToBlocks`, `DisableDefaultBlocks::init`) — they serve the block system, which
  is retained.

## Emit (always) — from this scaffold directory into the theme root

Minimal set — WordPress's own template hierarchy already falls back to `index.php` for anything
not listed here (`single.php`, `archive.php`, `home.php`, `front-page.php`, `404.php`, `search.php`
all have a working WP-core fallback; `searchform.php` has a working WP-core default markup). Don't
ship those by default — only scaffold one if step 1 of the skill explicitly asks for it, at which
point follow the same view-layer pattern as the files below.

- `header.php`, `footer.php`, `index.php` — the minimum a classic theme needs
- `page.php` — the actual deliverable: dispatches the CF "Page Sections" builder
- `template-parts/content.php` — the loop body `index.php` renders per post
- `template-parts/sections/hero.php`, `template-parts/sections/text.php`,
  `template-parts/sections/cta.php` — the Page Builder's section types (note C)
- `src/Handlers/Meta/PostMeta/PageBuilder.php`
- `src/Handlers/Blocks/BlockEditorSupport.php`

## Never touch

- `blocks/*`, `Init::loadBlocks()`, the webpack block glob (`webpack.mix.js`), `blocks/CLAUDE.md`,
  `.claude/skills/create-gutenberg-block/`. Verify byte-identical after conversion.
- `config/common/main.php`, `config/container.php`, `config/dependencies.php`, `src/App.php`,
  `functions.php` — the DI/PSR-4 bootstrap is unchanged (classic templates are a view layer over
  the existing `App`/`Hooks` boot sequence).
- Asset enqueue in `src/Handlers/Front.php` / `Hooks.php` (`enqueue_block_assets`,
  `enqueue_block_editor_assets`, `addThemeStyleDependencyToBlocks`) — verified to already fire on
  every front-end request, not FSE-gated. Do not refactor it.

## Review, don't auto-remove

- `src/Handlers/Blocks/BlockRenderHacks::templatePartWrapperHack` (`Hooks.php`, `render_block`
  filter) — unwraps `core/template-part` output, which only appears in FSE templates. Likely dead
  after conversion, but verify no remaining block references it before removing. Not a blocker if
  left in place.

## Post-type block-editor defaults to offer the user (editable at scope-questions step)

| Post type | Recommended | Why |
| --- | --- | --- |
| `page` | OFF | Carbon Fields "Page Sections" (`PageBuilder`) is its builder |
| `post` | ON | Canonical block content, composed from the theme's own blocks |
| `news` | ON | Editorial content, benefits from the block editor + custom blocks |
| `service` | OFF (fixed) | `show_in_rest => false` at registration — the allowlist can't override this |
| `team_member` | OFF (fixed) | `show_in_rest => false` at registration — the allowlist can't override this |
