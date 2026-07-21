---
name: convert-to-classic-theme
description: >
  Removes FSE (Full Site Editing) from this theme and restores a classic PHP-template
  render layer (header.php/footer.php/page.php/single.php/archive.php + template-parts/), while
  KEEPING the entire Gutenberg block system (blocks/*, Init::loadBlocks()) and making the block
  editor a per-post-type opt-in instead of theme-wide. Use for "convert this theme to classic",
  "remove FSE, keep blocks", "switch to PHP templates", or Russian "убери ФСЕ, оставь блоки",
  "переведи тему на классические темплейты". Not for removing Gutenberg/blocks entirely — that is
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

1. **Which post types keep the block editor?** Default allowlist `['post', 'news']` (see
   `stubs/classic-theme/CONVERT.md`'s post-type table for why `page` defaults off and
   `service`/`team_member` can't be turned on regardless — `show_in_rest => false` at
   registration is a separate, earlier core gate this skill's filter cannot override).
2. **Beyond the minimal template set** (header/footer/index/page) — does the project need
   `single.php`, `archive.php`, `home.php`, `front-page.php`, `404.php`, or `search.php` now?
   WordPress's own template hierarchy already falls back to `index.php` for any of these that
   don't exist, so **default: none** — scaffold only what's explicitly asked for, following the
   same view-layer pattern as the shipped files.
3. **`theme.json`**: keep it settings-only (palette/spacing for the block editor) with just
   `customTemplates` stripped, or does the user want to add real palette values now? Default:
   strip only, don't design a palette in this pass.

## 2. Show the manifest and get explicit confirmation

Print the delete/edit/emit lists from `stubs/classic-theme/CONVERT.md` verbatim (adjusted for the step-1
answers), and require a typed confirmation (e.g. "yes, convert") before touching anything. State
plainly: this deletes `templates/*.html`, `parts/*.html`, `patterns/*.php`, and edits
`theme.json`/`config/common/gutenberg.php`/`src/Base/Hooks.php`. Blocks are not touched — say so
explicitly so the user isn't left assuming this is a bigger change than it is.

## 3. Emit the scaffold

Copy every file listed under "Emit" in `stubs/classic-theme/CONVERT.md` from the theme's
`stubs/classic-theme/` directory into the theme root, preserving relative paths
(`stubs/classic-theme/page.php` → `<theme-root>/page.php`,
`stubs/classic-theme/src/Handlers/...` → `<theme-root>/src/Handlers/...`, etc.). If step 1 asked
for extra templates beyond the base set, scaffold those now too, following the same patterns as
the shipped files (view layer only, calling into the existing `Utils`/`Config`/`Repository`
classes — never a parallel bootstrap).

## 4. Apply the edits

1. `theme.json` — remove the `customTemplates` array only (per the step-1 answer on whether to
   also add palette values). Keep the file. If any live page is assigned `page-with-hero` /
   `page-without-title` (stored in `_wp_page_template` meta), warn the user: those pages fall back
   to `page.php` once the templates are deleted — see CONVERT.md's data caveat.
2. `src/Handlers/SetupTheme.php` — add the two `add_theme_support` lines from
   `stubs/classic-theme/SetupTheme.snippet.php` (`title-tag`, `post-thumbnails`) to
   `addThemeSupport()`. A block theme gets both implicitly from core; deleting `templates/*.html`
   makes the theme classic and drops them, breaking the Featured Image metabox and the document
   `<title>`. Do not remove any existing line.
3. `config/common/gutenberg.php` — merge in the `blockEditorPostTypes` key from
   `stubs/classic-theme/config/gutenberg.snippet.php`, using the step-1 allowlist answer instead
   of the snippet's default if the user changed it. Every other key in the file is unchanged.
   Apply this **before** step 4 so the filter never runs against a config missing the key.
4. `src/Base/Hooks.php` — add the two lines from `stubs/classic-theme/Hooks.snippet.php`, grouped
   with their respective existing sections (`carbon_fields_register_fields` lines for the
   PageBuilder registration; the Gutenberg-blocks section for the `use_block_editor_for_post_type`
   filter). Do not remove or reorder any existing line in this file.

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
- The per-post-type block-editor gate (`blockEditorPostTypes`) matches exactly what step 1's
  answers specified — no post type added or dropped beyond what was asked.
- Asset enqueue in `Hooks.php`/`Front.php` was **not** touched — it fires on every front-end
  request already, not FSE-gated, so editing it here would be a regression, not a fix.
- `theme.json`/`gutenberg.php` edits are exactly what was asked for — nothing beyond the scoped
  change.

If any of these fail, fix it before moving on — don't hand a broken conversion to `project-brief`.

## 8. Hand off to project-brief

Invoke the `project-brief` skill to rewrite the theme's own docs for the now-classic project.
Give it this target shape explicitly so it doesn't have to re-derive it:

- **New rule** `.claude/rules/classic-theme.md`: classic template hierarchy + `template-parts/`
  convention; the CF "Page Sections" page-builder and its exact data contract (see
  `src/Handlers/Meta/PostMeta/PageBuilder.php`'s docblock); the `blockEditorPostTypes` allowlist
  mechanism and which post types use blocks vs. Carbon Fields; explicit statement that templates
  are a view layer over the unchanged `App`/`Hooks`/DI bootstrap; that asset enqueue is unchanged.
- **Edit root `CLAUDE.md`**: "FSE theme" → "classic PHP-template theme; Gutenberg blocks retained
  for opt-in post types"; `Structure` table: `templates/*.php` (not `.html`), add
  `template-parts/`, drop the `parts/`/`patterns/` rows, note `theme.json` is now settings-only.
- **Edit `.claude/rules/content-types.md`**: replace the "FSE markup folders" section with the
  classic-template + per-post-type block-editor description; keep the Carbon Fields section as-is.
- **Edit `.claude/rules/architecture.md`**: add the `blockEditorPostTypes` config row and the
  `BlockEditorSupport` handler to the existing tables.
- **Do NOT touch** `blocks/CLAUDE.md` or the `create-gutenberg-block` skill beyond one added note
  in `blocks/CLAUDE.md` that the theme is no longer FSE and blocks now serve opt-in block-editor
  post types (not FSE template composition).

## 9. Report

List every changed/deleted/added file with its full path. Then give this browser-verification
checklist to the user (or hand it to `qa-analyst`/`acceptance-tester`):

- A `page` builds through the CF Page Builder (classic editor + CF metaboxes, no block editor),
  each section type renders on the front end **with its actual field values** (title, image,
  button) — an empty section shell means the `$args['section']` unpack regressed.
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
