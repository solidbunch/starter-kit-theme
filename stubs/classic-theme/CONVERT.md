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
- `src/Base/Hooks.php` — apply `Hooks.snippet.php`'s `use_block_editor_for_post_type` filter line
  always; apply its `carbon_fields_register_fields`/`PageBuilder::class` line only if the Page
  Builder add-on (below) is also being emitted. Every existing line in `Hooks.php` stays, including
  all block-related hooks (`loadBlocks`, `loadBlocksCategories`, `addSpacerAttributeToBlocks`,
  `DisableDefaultBlocks::init`) — they serve the block system, which is retained.

## Emit (always) — from this scaffold directory into the theme root

Minimal set — WordPress's own template hierarchy already falls back to `index.php` for anything
not listed here (`single.php`, `archive.php`, `home.php`, `front-page.php`, `404.php`, `search.php`
all have a working WP-core fallback; `searchform.php` has a working WP-core default markup). Don't
ship those by default — only scaffold one if step 1 of the skill explicitly asks for it, at which
point follow the same view-layer pattern as the files below.

- `header.php`, `footer.php`, `index.php` — the minimum a classic theme needs
- `page.php` — plain classic template: title + `the_content()`, no flexible-content builder
  wired in by default (see "Emit (optional — Page Builder add-on)" below)
- `template-parts/content.php` — the loop body `index.php` renders per post
- `src/Handlers/Blocks/BlockEditorSupport.php`

## Emit (optional — per-page templates)

The classic WordPress template hierarchy is the primary, default mechanism for page-specific
layout in this theme — not the Page Builder add-on below. Ask the user (step 1 of the skill) which
concrete pages need their own layout and scaffold exactly those, following the same view-layer
pattern as `page.php`/`front-page.php`:

- `front-page.php` — the site's front page (`stubs/classic-theme/front-page.php`, bare skeleton —
  WordPress calls this file for the front page regardless of the `page.php` fallback chain).
  Requires **Settings → Reading → "A static page"** to be configured with a front page assigned;
  otherwise WP falls back to `home.php`/`index.php` showing the post feed instead.
- `single.php`, `archive.php`, `home.php`, `404.php`, `search.php` — scaffold only if asked; WP's
  own fallback to `index.php` is correct behavior when not asked.
- A slug-specific classic template — WordPress's page template hierarchy resolves
  `page-{slug}.php` (e.g. `page-about-us.php`, `page-contact.php`) before falling back to
  `page-{id}.php` then `page.php`, with **no PHP registration needed** — just add the file with
  the matching filename and WordPress picks it up automatically for that one page. This is the
  default way to give an individual page (About Us, Contact, ...) its own dedicated template.
- Alternatively, a `Template Name: <Label>` header-comment template (see
  `optional/page-builder/page-flexible-content.php` for the exact comment shape) is selectable
  per-page in the editor's Page Attributes panel, independent of slug — use this when the same
  custom layout should be assignable to more than one page, or the slug isn't fixed yet.

## Emit (optional — Page Builder add-on)

The Carbon Fields "Page Sections" flexible-content builder is an **opt-in extra**, not the base —
only scaffold it if the user explicitly asks for a builder-driven flexible-content page type
alongside the classic per-page templates above. Ask before emitting any of this.

- `optional/page-builder/page-flexible-content.php` → `<theme-root>/page-flexible-content.php` — a
  `Template Name: Flexible Content` classic template, selectable per-page in Page Attributes; not
  wired as the default `page.php`
- `optional/page-builder/template-parts/sections/{hero,text,cta}.php` →
  `<theme-root>/template-parts/sections/{hero,text,cta}.php` — the builder's section types (note C)
- `optional/page-builder/src/Handlers/Meta/PostMeta/PageBuilder.php` →
  `<theme-root>/src/Handlers/Meta/PostMeta/PageBuilder.php`
- Add `Hooks.snippet.php`'s `carbon_fields_register_fields` line for `PageBuilder::class` **only**
  if this add-on is emitted — the block-editor-gate line stays always (see below)

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
| `page` | OFF | Layout comes from classic per-page templates (`page-{slug}.php` / `Template Name:`), not the block editor |
| `post` | ON | Canonical block content, composed from the theme's own blocks |
| `news` | ON | Editorial content, benefits from the block editor + custom blocks |
| `service` | OFF (fixed) | `show_in_rest => false` at registration — the allowlist can't override this |
| `team_member` | OFF (fixed) | `show_in_rest => false` at registration — the allowlist can't override this |
