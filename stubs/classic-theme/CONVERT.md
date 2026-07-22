# Conversion manifest — data the `convert-to-classic-theme` skill consumes

Scope: remove FSE, keep Gutenberg/blocks. Never touch `blocks/*`.

## Two kinds of file in this scaffold directory — don't confuse them

This directory mirrors the theme's own structure exactly — `stubs/classic-theme/<path>` is always
`<theme-root>/<path>`, no invented wrapper folders. Only the file extension tells you which of two
things a given file is:

- **`*.php`** (`header.php`, `page.php`, `page-example.php`, `src/Repository/PageExampleRepository.php`,
  `template-parts/page-hero.php`, ...) — full, ready files, copied verbatim to the identical path
  under the theme root.
- **`*.snippet.php`** (`src/Base/Hooks.snippet.php`, `src/Handlers/SetupTheme.snippet.php`) — a
  delta, never copied as a file. Each one sits at the same directory as the real file it patches
  (strip the `.snippet.php` suffix, add `.php`, to get the real target — `src/Base/Hooks.snippet.php`
  patches `src/Base/Hooks.php`) and contains the few lines to hand-merge into that **existing**
  theme file, which already has other content in it — copying it over the target would destroy
  every other line already there.

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
- `src/Handlers/SetupTheme.php` — add `src/Handlers/SetupTheme.snippet.php`'s two
  `add_theme_support` lines (`title-tag`, `post-thumbnails`) to `addThemeSupport()`. A block theme
  gets both implicitly from core; a classic theme must declare them or it loses the Featured Image
  metabox and emits no document `<title>`. Keep every other line in the method.
- `config/common/gutenberg.php` — this file, its `disableGutenbergForPostTypes` key, and the
  `use_block_editor_for_post_type` filter (`src/Handlers/Blocks/BlockEditorSupport.php`) are
  **already live in this theme regardless of FSE/classic** — not something this skill adds. Its
  default value is `[]` (block editor stays on for every native post type). Update the value per
  the step-1 answer — e.g. `['page']` if `page` should render classic-only. This key only makes
  sense for native types (`post`, `page`) that have no `register_post_type()` call of their own in
  this theme — custom post types (`news`, `service`, `team_member`) already decide this via their
  own `show_in_rest`/`supports` in `Handlers/PostTypes/*.php`; don't add them here, that's redundant
  and the wrong place to change their editor.
- `src/Base/Hooks.php` — apply the one line from `src/Base/Hooks.snippet.php` always (the
  `PageExampleMeta::class` registration) — not conditional, the scaffold below is always emitted.
  The `use_block_editor_for_post_type` filter line is already present in this file, nothing to add
  for it. Every existing line in `Hooks.php` stays, including all block-related hooks (`loadBlocks`,
  `loadBlocksCategories`, `addSpacerAttributeToBlocks`, `DisableDefaultBlocks::init`) — they serve
  the block system, which is retained.

## Emit (always) — from this scaffold directory into the theme root

Everything below is scaffolded on every conversion, no scope question gates whether it happens —
only *which additional project-specific pages* get their own template (see the next section) is
actually asked about. WordPress's own template hierarchy already falls back to `index.php` for
`single.php`/`archive.php`/`home.php`/`404.php`/`search.php` — don't ship those by default, only
scaffold one if step 1 of the skill explicitly asks for it, at which point follow the same
view-layer pattern as the files below.

- `header.php`, `footer.php`, `index.php` — the minimum a classic theme needs
- `page.php` — plain classic template: title + `the_content()`
- `template-parts/content.php` — the loop body `index.php` renders per post
- `page-example.php`, `template-parts/page-hero.php`, `template-parts/sections/{hero,text,cta}.php`,
  `src/Repository/PageExampleRepository.php`, `src/Handlers/Meta/PostMeta/PageExampleMeta.php` (see
  "Page example — the unified pattern" below)

### Page example — the unified pattern

One Carbon Fields container, one Repository, one classic template demonstrating that plain/fixed
fields and a flexible, editor-managed "Page sections" builder `complex` field are **the same
system** — not two competing mechanisms. Whether a piece of a page is fixed or builder-driven is a
per-field decision made when designing that specific page. Always emitted as a live, working
example (`Template Name: Example Page`) developers can open immediately and copy from when building
a real project-specific page (see `create-classic-template`'s branches A and A2):

- `page-example.php` — thin template: fixed hero + intro, then a dispatch loop over the builder's
  rows
- `template-parts/page-hero.php` — reusable partial backed by the fixed hero fields
- `template-parts/sections/{hero,text,cta}.php` — the builder's section types
- `src/Repository/PageExampleRepository.php` — the only place this page's data (fixed *and*
  builder) is read
- `src/Handlers/Meta/PostMeta/PageExampleMeta.php` — one container registering both the fixed
  fields and the one builder `complex` field

## Emit (optional — additional per-page templates)

The classic WordPress template hierarchy is the primary, default mechanism for page-specific
layout in this theme. Ask the user (step 1 of the skill) which *additional* concrete project pages
(beyond the always-emitted `page-example.php`) need their own layout and scaffold exactly those,
following the same view-layer pattern as `page.php`/`front-page.php`/`page-example.php`:

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
- Alternatively, a `Template Name: <Label>` header-comment template (see `page-example.php` for
  the exact comment shape) is selectable per-page in the editor's Page Attributes panel,
  independent of slug — use this when the same custom layout should be assignable to more than one
  page, or the slug isn't fixed yet.

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

## `disableGutenbergForPostTypes` default to offer the user (editable at scope-questions step)

This key only ever concerns native post types (`post`, `page`) — the ones with no
`register_post_type()` call of their own to gate the editor at. Custom post types are **not** a
scope question here at all:

| Post type | Recommended | Why |
| --- | --- | --- |
| `page` | Disabled (in the denylist) | Layout comes from classic per-page templates (`page-{slug}.php` / `Template Name:`), not the block editor |
| `post` | Enabled (not in the denylist) | Canonical block content, composed from the theme's own blocks |

For reference, not something this option controls: `news` already has `show_in_rest => true` at its
own registration (block editor on); `service`/`team_member` already have `show_in_rest => false`
(block editor off, and no filter can override it). Adding any of the three to
`disableGutenbergForPostTypes` would be redundant at best.
