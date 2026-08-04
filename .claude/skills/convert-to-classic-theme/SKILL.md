---
name: convert-to-classic-theme
description: >
  Removes FSE (Full Site Editing) from this theme and restores a classic PHP-template
  render layer (header.php/footer.php/page.php/single.php/archive.php + template-parts/), while
  KEEPING the entire Gutenberg block system (blocks/*, Init::loadBlocks()) and making the block
  editor a per-post-type opt-in instead of theme-wide. Use for "convert this theme to classic",
  "remove FSE, keep blocks", "switch to PHP templates". Not for removing Gutenberg/blocks entirely — that is
  explicitly out of scope, see below — and not for renaming the theme's identity (text
  domain/prefixes/namespace), which is `wp clone-theme` / `bootstrap-project` territory.
---

# Convert this theme from FSE to classic templates (blocks retained)

**What this does NOT do**: it never removes, edits, or reorganizes `blocks/*`,
`Handlers\Blocks\Init::loadBlocks()`, the webpack block glob, `blocks/CLAUDE.md`, or the
`create-gutenberg-block` skill. Gutenberg and the theme's custom blocks are staying — only FSE
(`templates/*.html`, `parts/*.html`, `patterns/*.php`) goes away, replaced by classic PHP
templates. The block editor itself stays enabled, but only for post types that opt in (see step 1).

Why keep blocks at all if FSE goes away? Because "FSE" (full-page block-based templates/parts/
patterns driving the *whole* site) and "the block editor for `post_content` on some post types"
are two independent things sharing one underlying technology. This conversion removes the former
and keeps the latter — the theme's custom blocks remain useful editorial components wherever the
block editor stays enabled, they're just no longer how pages are assembled site-wide.

All paths below are relative to this theme's own root directory (`web/wp-content/themes/<theme-folder>/`). This is a
**destructive, irreversible** operation on the theme's working tree (except via `git`) — follow
the confirmation gate in step 2 exactly, do not skip it.

## 0. Preflight

1. Confirm this is actually an FSE theme (has `templates/*.html` and `theme.json` with a
   `customTemplates` array) — refuse if it looks already converted (no `templates/` dir).
2. Check the theme's own git status (`git -C web/wp-content/themes/<theme-folder> status
   --porcelain`, run from the foundation root). **Refuse to proceed on a dirty tree** unless the
   user explicitly asks you to create a dedicated branch first (`git checkout -b
   convert-to-classic-theme`) — either way, there must be a clean point to `git checkout .`
   back to before any files are touched.

## 1. Ask scope questions

Batch these (`AskUserQuestion`), default sensibly, don't ask what's obvious:

1. **Should `page` render through the classic editor only?** This theme already ships a permanent,
   FSE-independent `disableGutenbergForPostTypes` denylist (`config/common/gutenberg.php`) plus
   `Handlers\Blocks\BlockEditorSupport` — not something this skill adds, just a value to update
   (see `stubs/classic-theme/CONVERT.md`'s table). Default: `['page']` — layout comes from classic
   per-page templates once this conversion runs, not the block editor. `post` stays off the
   denylist (block editor on) unless asked otherwise. This key only concerns native post types —
   custom post types (`news`, `service`, `team_member`) already decide their editor at their own
   `register_post_type()` call (`show_in_rest`/`supports`) and are never added here.
2. **Which additional pages need their own dedicated template?** The classic WordPress template
   hierarchy is the default, primary mechanism for per-page layout in this theme (see `CONVERT.md`'s
   "Emit (optional — additional per-page templates)" section). Note: `page-example.php` (the
   unified fixed-fields + builder pattern — see below) is always scaffolded regardless of this
   answer, as a live working reference. Ask which *additional* concrete pages the project actually
   has (About Us, Contact, front page, ...) and scaffold one classic template per page that needs
   distinct layout — slug-based `page-{slug}.php` when the page maps 1:1 to a fixed slug, or a
   `Template Name:` header-comment template when the same layout should be assignable to more than
   one page. **Default: `front-page.php` only** if the project has a static front page configured;
   every other page starts on the shared `page.php` and gets its own template only when asked.
3. **Beyond the page-template set above** — does the project need `single.php`, `archive.php`,
   `home.php`, `404.php`, or `search.php` now? WordPress's own template hierarchy already falls
   back to `index.php` for any of these that don't exist, so **default: none** — scaffold only
   what's explicitly asked for, following the same view-layer pattern as the shipped files.
4. **`theme.json`**: keep it settings-only (palette/spacing for the block editor) with just
   `customTemplates` stripped, or does the user want to add real palette values now? Default:
   strip only, don't design a palette in this pass.

Note what's **not** a question here anymore: the unified `page-example.php` scaffold — one Carbon
Fields container with both fixed fields and one flexible "Page sections" builder `complex` field,
one Repository, one template — is always scaffolded, see `CONVERT.md`'s "Emit (always)" section.
Fixed vs. builder was never two separate mechanisms to opt into; it's a per-field choice made when
designing a real project page (see `create-classic-template`'s branches A/A2).

## 2. Show the manifest and get explicit confirmation

Print the delete/edit/emit lists from `stubs/classic-theme/CONVERT.md` verbatim (adjusted for the step-1
answers), and require a typed confirmation (e.g. "yes, convert") before touching anything. State
plainly: this deletes `templates/*.html`, `parts/*.html`, `patterns/*.php`, and edits
`theme.json`/`config/common/gutenberg.php`/`src/Base/Hooks.php`. Blocks are not touched — say so
explicitly so the user isn't left assuming this is a bigger change than it is.

## 3. Emit the scaffold

Copy every file listed under "Emit (always)" in `stubs/classic-theme/CONVERT.md` from the theme's
`stubs/classic-theme/` directory into the theme root, preserving relative paths
(`stubs/classic-theme/page.php` → `<theme-root>/page.php`,
`stubs/classic-theme/src/Handlers/...` → `<theme-root>/src/Handlers/...`, etc.). This
unconditionally includes the following — no step-1 question gates it:

- **Page example (unified pattern)** — copy `stubs/classic-theme/page-example.php`,
  `stubs/classic-theme/template-parts/page-hero.php`,
  `stubs/classic-theme/template-parts/sections/{hero,text,cta}.php`,
  `stubs/classic-theme/src/Repository/PageExampleRepository.php`, and
  `stubs/classic-theme/src/Handlers/Meta/PostMeta/PageExampleMeta.php` to their identical paths
  under the theme root — one Carbon Fields container registering both fixed fields and one builder
  `complex` field, one Repository reading both, one template composing both.

Then, per the step-1 answers:

- **Additional per-page templates** ("Emit (optional — additional per-page templates)" in
  `CONVERT.md`) — scaffold exactly the pages asked for (`front-page.php`, a slug-based
  `page-{slug}.php`, or a `Template Name:` template), following the same view-layer pattern as
  `page.php`/`front-page.php`/`page-example.php` (calling into the existing
  `Utils`/`Config`/`Repository` classes — never a parallel bootstrap).
- Any other extra template from step 1's question 3 — same view-layer pattern as the shipped
  files.

## 4. Apply the edits

1. `theme.json` — remove the `customTemplates` array only (per the step-1 answer on whether to
   also add palette values). Keep the file. If any live page is assigned `page-with-hero` /
   `page-without-title` (stored in `_wp_page_template` meta), warn the user: those pages fall back
   to `page.php` once the templates are deleted — see CONVERT.md's data caveat.
2. `src/Handlers/SetupTheme.php` — add the two `add_theme_support` lines from
   `stubs/classic-theme/src/Handlers/SetupTheme.snippet.php` (`title-tag`, `post-thumbnails`) to
   `addThemeSupport()`. A block theme gets both implicitly from core; deleting `templates/*.html`
   makes the theme classic and drops them, breaking the Featured Image metabox and the document
   `<title>`. Do not remove any existing line.
3. `config/common/gutenberg.php` — the `disableGutenbergForPostTypes` key already exists in this
   live file (default `[]`) — nothing to merge, just update its **value** to the step-1 answer
   (default `['page']`). Every other key in the file is unchanged. The
   `use_block_editor_for_post_type` filter (`Handlers\Blocks\BlockEditorSupport`) that reads this
   key is already wired in `Hooks.php` too — neither the config key nor the filter registration is
   something this conversion adds.
4. `src/Base/Hooks.php` — add the one line from `stubs/classic-theme/src/Base/Hooks.snippet.php`
   always: `carbon_fields_register_fields`/`PageExampleMeta::class`, grouped with the existing
   `carbon_fields_register_fields` lines. Not conditional. Do not remove or reorder any existing
   line in this file.

## 5. Delete the FSE files

Delete exactly what `stubs/classic-theme/CONVERT.md`'s "Delete" section lists —
`templates/*.html`, `parts/*.html`, `patterns/*.php`. Nothing under `blocks/` is ever touched in
this step.

## 6. Lint and build

```bash
composer lint    # PSR-12 — fix any fallout in the newly emitted files
npm run prod     # confirm the build still compiles cleanly
```

## 7. Structural sanity check

Before handing off to `project-brief`, verify the conversion didn't introduce a regression —
check this yourself, no subagent needed:

- No parallel bootstrap was introduced (still one `App::instance()->run()` entrypoint, no second
  init path added for the classic templates).
- `blocks/*` is untouched: `git diff --stat -- blocks/` shows nothing.
- `disableGutenbergForPostTypes`'s value matches exactly what step 1's answer specified (typically
  just `['page']`) — no post type added beyond what was asked, and no custom post type
  (`news`/`service`/`team_member`) was added to it — their editor is controlled at their own
  registration, not this key.
- Asset enqueue in `Hooks.php`/`Front.php` was **not** touched — it fires on every front-end
  request already, not FSE-gated, so editing it here would be a regression, not a fix.
- `theme.json`/`gutenberg.php` edits are exactly what was asked for — nothing beyond the scoped
  change.

If any of these fail, fix it before moving on — don't hand a broken conversion to `project-brief`.

## 8. Hand off to project-brief

Invoke the `project-brief` skill to rewrite the theme's own docs for the now-classic project.
Give it this target shape explicitly so it doesn't have to re-derive it:

- **New rule** `.claude/rules/classic-theme.md`: classic template hierarchy is the primary,
  default mechanism for page-specific layout — `page-{slug}.php` / `Template Name:` templates +
  the `template-parts/` convention; document exactly which per-page templates this conversion
  scaffolded and why. Document the unified `page-example.php` pattern (always scaffolded) as the
  default shape for a new dedicated page template: **one** Carbon Fields container
  (`PageExampleMeta`) registering both plain/fixed fields (hero title/subtitle, intro) and one
  flexible "Page sections" builder `complex` field (tabbed `hero`/`text`/`cta` sub-types), **one**
  Repository (`PageExampleRepository`) as the only place any of it is read — fixed or builder —
  and **one** template composing both. Make explicit that fixed-vs-builder is a per-field decision
  made per real project page, not two competing mechanisms to choose between at conversion time.
  Also cover `disableGutenbergForPostTypes` (already documented in `architecture.md`'s config table
  as of this session — a permanent, FSE-independent mechanism, not something this conversion
  introduces) and which post types use blocks vs. classic templates; explicit statement that
  templates are a view layer over the unchanged `App`/`Hooks`/DI bootstrap; that asset enqueue is
  unchanged.
- **Edit root `CLAUDE.md`**: "FSE theme" → "classic PHP-template theme; Gutenberg blocks retained
  for opt-in post types"; `Structure` table: `templates/*.php` (not `.html`), add
  `template-parts/`, drop the `parts/`/`patterns/` rows, note `theme.json` is now settings-only.
- **Edit `.claude/rules/content-types.md`**: replace the "FSE markup folders" section with the
  classic-template + per-post-type block-editor description; keep the Carbon Fields section as-is.
- **Edit `README.MD`**: same "FSE theme" → "classic PHP-template theme; Gutenberg blocks retained
  for opt-in post types" swap as `CLAUDE.md`, wherever the public-facing summary/description
  mentions FSE (top intro line, `## Blocks` overview if it references FSE template composition);
  `## Structure` tree: `templates/*.php`/`template-parts/` instead of the FSE folders, same as the
  `CLAUDE.md` edit above.
- **`architecture.md`**: `disableGutenbergForPostTypes`/`BlockEditorSupport` are already documented
  in the config table (added once, permanently, independent of this skill) — nothing to add here
  unless the row itself is missing.
- **Do NOT touch** `blocks/CLAUDE.md` or the `create-gutenberg-block` skill beyond one added note
  in `blocks/CLAUDE.md` that the theme is no longer FSE and blocks now serve opt-in block-editor
  post types (not FSE template composition).

## 9. Report

List every changed/deleted/added file with its full path. Then give this browser-verification
checklist to the user (or hand it to `qa-analyst`/`acceptance-tester`):

- A `page` with no dedicated template builds through the shared `page.php` (classic editor, title
  + `the_content()`, no block editor, no builder).
- If a slug-based (`page-{slug}.php`) or `Template Name:` per-page template was scaffolded, the
  page it targets actually resolves to that template (not silently falling back to `page.php`) and
  renders its intended layout.
- If a static front page is configured (Settings → Reading), it renders through `front-page.php`,
  not `index.php`'s post feed.
- A page assigned the `Example Page` template (`page-example.php`) shows, in wp-admin, exactly one
  Carbon Fields metabox ("Example page") containing both the fixed hero/intro fields **and** the
  "Page sections" builder — not two separate metaboxes. On the front end: the fixed hero + intro
  render from real, admin-entered values (confirms the Repository actually reads what the Meta
  class registered, and that no `Utils::` call leaked into the template); adding builder rows
  (hero/text/cta) renders each section type **with its actual field values** (title, image,
  button) in the editor-chosen order below the fixed content — an empty section shell means the
  `$args['section']` unpack regressed; leaving the builder empty still renders the fixed content
  fine, confirming the two are one system, not one gating the other.
- A `post`/`news` opens in the **block editor**, composes with the theme's own blocks, and those
  blocks render on the front end via `index.php`'s loop → `the_content()`.
- The Featured Image metabox appears in the editor and `the_post_thumbnail()` renders on the front
  end (confirms `add_theme_support('post-thumbnails')` landed).
- Front-end pages emit a non-empty `<title>` (view source) (confirms `add_theme_support('title-tag')`).
- A listing with more posts than the reading setting shows working pagination (page 2+ reachable).
- Reusable blocks / synced patterns (`wp_block`) still open in the **block editor**, not classic
  (confirms the `wp_*` core-type carve-out in `BlockEditorSupport`).
- Any post type without its own template (i.e. everything except `page`) falls back to
  `index.php` and still renders with working header/footer menus — that's expected, not a gap.
- If step 1 asked for extra templates (`single.php`/`archive.php`/etc.), verify each one renders
  instead of silently falling back.
- `service`/`team_member` still open without the block editor (unaffected).
- `blocks/` is byte-identical to before conversion (`git diff --stat -- blocks/` shows nothing).

**Never commit.** Leave the diff for the user to review across both the changed files and the
`project-brief` doc rewrite.
