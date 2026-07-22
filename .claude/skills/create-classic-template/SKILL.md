---
name: create-classic-template
description: >
  Turns a static HTML/CSS design handoff (a designer-delivered standalone mockup — a blog, a
  landing page, a category/search/listing page, anything with its own <style> block and no CMS
  wiring) into classic PHP templates for this theme, reusing everything the theme already
  has: existing Gutenberg blocks, existing Repository query methods, and — one dedicated classic
  template per page (`page-{slug}.php` / `Template Name:`) by default, with the theme's optional
  Carbon Fields "Page Builder" flexible-content add-on only if the project has already adopted it.
  Use this for "turn this HTML into a WordPress template", "build this mockup into the theme",
  "here's the handoff, make it a page/blog/category template". Always consult this before
  hand-writing a new PHP template from a static mockup — it sequences the reuse-inventory step that
  prevents reinventing what the theme already solved. Requires the theme to already be classic
  (post `convert-to-classic-theme`) — if it's still FSE, this skill refuses and points there first.
---

# Turning an HTML handoff into classic templates

**What this does NOT do**: it never builds a new Gutenberg block (that's `create-gutenberg-block`'s
job), and never converts FSE to classic (that's `convert-to-classic-theme`'s job — this skill only
consumes its output). The single biggest failure mode for what it *does* do is quietly reinventing
the wheel — a second flexible-content mechanism next to `PageBuilder` if the project already has
one, a hand-rolled `WP_Query` next to an existing `Repository` method, a `get_post_meta()` call
next to `Helper\Utils`. Every step below exists to make reuse the path of least resistance, not an
afterthought.

All paths below are relative to this theme's own root directory (`web/wp-content/themes/<theme-folder>/`).

## 0. Preflight

1. Confirm the theme is already classic: no `templates/*.html` directory, and `page.php` (or its
   stub at `stubs/classic-theme/page.php`) exists. If `templates/*.html` is still present,
   **refuse** and tell the user to run `convert-to-classic-theme` first — do not run it for them,
   this skill's whole design depends on choices made during that conversion (which post types
   keep the block editor, which per-page templates were scaffolded, whether the optional Page
   Builder add-on was adopted).
   Also check whether the Page Builder add-on is present in this project — a live
   `src/Handlers/Meta/PostMeta/PageBuilder.php`, or its stub at
   `stubs/classic-theme/optional/page-builder/src/Handlers/Meta/PostMeta/PageBuilder.php` — since
   that changes whether branch A2 is even available in step 2 below.
2. Confirm the theme's own git tree is clean (`git -C web/wp-content/themes/<theme-folder>
   status --porcelain`, run from the foundation root) — same reasoning as `convert-to-classic-theme`:
   there must be a clean point to return to.
3. Confirm the handoff file(s) exist and are readable. A handoff is usually more than one page
   (e.g. a blog's home/category/article/search states) — read all of them before step 1, not one
   at a time, since components repeat across pages and you want to spot that before designing
   anything.

## 1. Inventory pass — mandatory, before any design work

Read these and build an actual list, not an assumption, of what the theme already offers. This
step is the whole point of the skill — skipping it is how you end up duplicating something that
already exists three files away.

- **`blocks/*/block.json`** — every existing Gutenberg block and what it does. Look for anything
  in the handoff that's a 1:1 match (an accordion FAQ → `FaqSection`/`FaqSingle`; a filtered grid
  of posts → `News` as a reference, even if it's the news CPT and not yours).
- **`src/Repository/*.php`** — existing repository classes and their query methods. Read
  `WpPostRepositoryAbstract` itself: `getRecentPosts()`/`getRelatedPosts()`/`getRandomPosts()` are
  generic — `getRelatedPosts()` already defaults its `$taxonomy` argument to `'category'`, so this
  abstract works against the native `post`/`category` out of the box. A new post type is very
  often *not* needed; a thin repository extending the abstract usually is — see branch B2 in step
  2 for the specific conditions (own storage, reuse, own sub-data) that mean it actually is needed.
- **`src/Handlers/PostTypes/*.php`** — existing CPTs/taxonomies, in case one already fits instead
  of native `post`.
- **`src/Handlers/Meta/{PostMeta,TaxonomyMeta,UserMeta}/*.php`** — existing Carbon Fields
  containers. These are your copy-patterns for field shape, `Container::make()` context
  (`post_meta`/`term_meta`/`user_meta`/`theme_options`), and key prefixing — never write a
  container from a blank page when one of these already shows the shape you need.
- **Per-page classic templates — the default mechanism.** This theme's primary way to give a page
  its own layout is a dedicated classic template: `page-{slug}.php` (WordPress's own template
  hierarchy picks it up for that slug automatically, no registration needed) or a
  `Template Name:` header-comment template selectable in Page Attributes. For most handoff pages
  (About Us, Contact, a landing page, the front page) this is what you build — a new PHP template
  with the handoff's markup translated directly into it (reusing blocks/repositories per the rest
  of this inventory), not a flexible-content mechanism.
- **The Page Builder add-on — optional, check if it's actually present first.** If (and only if)
  `src/Handlers/Meta/PostMeta/PageBuilder.php` (or its stub) exists per the preflight check above,
  this project has adopted the opt-in flexible-content builder: one `complex` Carbon Fields field
  (`set_layout('tabbed-vertical')`) on a `Template Name: Flexible Content` template, where each row
  carries a `_type` key, read back via `Utils::getPostMetaFw($postId, SK_PREFIX . 'page_sections',
  [])` and dispatched with `get_template_part("template-parts/sections/{$type}", null, ['section'
  => $section])`. Only reach for this when the project has it **and** the handoff page genuinely
  needs editor-managed, freeform section reordering (not just "this page has several visual
  blocks" — a dedicated template with the sections hand-composed in PHP is simpler and is the
  default for a fixed page layout). Never introduce this mechanism into a project that doesn't
  already have it — that's `convert-to-classic-theme`'s decision to make, not this skill's.
- **`assets/src/styles/`** — the existing SCSS partial structure (`layout/_header.scss`,
  `_footer.scss`, etc.) and the `custom_bootstrap/` override layer. New styles live here, mapped
  onto existing Bootstrap variables where the handoff's design tokens overlap with them, not
  dumped in as a parallel `:root` custom-property system fighting the existing one.

Write out a short "what already exists / what's actually missing" summary and show it to the user
before step 2. If everything the handoff needs already exists as blocks + repository methods, say
so plainly — sometimes the honest answer is "no new PHP needed, just compose existing blocks in the
editor and wire the loop with an existing repository method."

## 2. Classify every section — not every page

A handoff page is almost always a mix, so classify at the level of each visually distinct block
(hero, a grid of cards, a FAQ accordion, a text blurb, a newsletter form), not the page as a whole.
For each one, decide:

| Branch                              | Recognize it by                                                                                                                        | What it becomes                                                                                                                                                                                                                               |
| ------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **A — Editorial content (default)**  | Hand-authored content that doesn't repeat by query and isn't a listing (hero copy, a CTA block, an SEO text block, an intro paragraph) | Hand-written directly into the page's own dedicated classic template (`page-{slug}.php` or a `Template Name:` template) — plain PHP/HTML, reading fixed fields via a page-specific Carbon Fields `post_meta` container if the copy needs to be editable, or straight `the_content()`/hardcoded markup if it doesn't. Pull a repeated visual shape into its own `template-parts/*.php` if it's reused across pages, same as any other view partial |
| **A2 — Editorial content, needs a builder** | Same as A, but the *client* needs to freely reorder/add/remove sections per page without a developer touching PHP, **and** this project already has the Page Builder add-on (see preflight) | A new `add_fields('<type>', label, [...])` tab inside the **existing** `PageBuilder` complex field, plus a new `template-parts/sections/{type}.php`. Never introduce this add-on into a project that doesn't already have it — flag the need to the user instead, that's a `convert-to-classic-theme` re-run decision |
| **B — Query-driven listing**         | Content that's really a database query result (recent posts, popular, related, a category archive, search results)                     | A PHP loop in the template or a template-part, backed by a `Repository` method (existing, or a new method added to an existing/new repository extending `WpPostRepositoryAbstract`) — no Carbon Fields involved in the listing content itself |
| **B2 — Listing needs its own storage** | Same as B, but the underlying data (1) needs storage independent of `post`/`page`, (2) is reused by more than this one template/block, or (3) has its own fields/relationships (sub-data) beyond what an existing `Repository` method covers | Hand off to `.claude/skills/create-post-type/SKILL.md` to register the new CPT (+ repository, + Carbon Fields meta if needed), then resume here at step 4 using the resulting `Repository` method — don't hand-roll a parallel storage mechanism instead |
| **C — Already a block**              | Matches an existing `blocks/*` component closely enough to just use it                                                                 | Generate nothing for it — note "compose with `blocks/X` in the editor" (only applies to post types with the block editor enabled for them)                                                                                                    |
| **D — Sitewide chrome**              | Header/footer/nav/logo/search/social links/language switcher — not tied to one page or post                                            | A `theme_options`-style Carbon Fields container (pattern: `ThemeSettings`) and/or `header.php`/`footer.php`/existing template-parts — never post-level fields for something that isn't post-level data                                        |

Present this table to the user and get explicit confirmation before generating anything — same
discipline as `convert-to-classic-theme`'s manifest-confirmation gate. This is the point where a
misclassification is cheap to fix (a text edit) instead of expensive (a wrong container already
built). Default to **A**, not A2 — only classify something as A2 if the user actually asks for
builder-style flexibility and the add-on is already present in this project.

## 3. Design the Carbon Fields schema — branches A (if fields are needed), A2, and D

- Branch A: if the editorial copy needs to be admin-editable (not just hardcoded), add a plain
  `post_meta` Carbon Fields container scoped to that one page (`Container::make('post_meta',
  ...)->where('post', '=', $pageId)` or `->where('post_template', '=', '<template-file>.php')` to
  scope it to every page using that template) — copy the shape of an existing `Meta/PostMeta/*`
  container. This is a **new, separate** container per dedicated template, not a shared complex
  field — each page template owns its own fields.
- Branch A2: add new tabs to the **same** `PageBuilder` complex field via
  `->add_fields('<new_type>', __('Label', 'starter-kit'), [Field::make(...), ...])`. Don't create a
  second `complex` field or a second container for page sections — one Flexible Content template,
  one field, one set of tabs, extended.
- Branch D: add fields to whichever container already owns that kind of sitewide setting
  (`ThemeSettings` for `theme_options`, or a new `term_meta`/`user_meta` container by copying
  `NewsCategory.php`'s or `UserMeta.php`'s shape if nothing existing fits).
- **Never guess a Carbon Fields field type, method, or option.** Check
  <https://docs.carbonfields.net/> for the real API surface before writing any `Field::make(...)`
  call — this theme's own docs (`content-types.md`) deliberately don't duplicate the field
  catalogue, they point to this same URL for exactly this reason. A field type invented from memory
  that happens not to exist fails silently or throws deep in Carbon Fields' internals — always
  worse to debug than spending thirty seconds confirming the real signature first.
- Prefix every new field key with `SK_PREFIX` (`skt_`), matching every existing container.

## 4. Generate templates and partials

- **Branch A** → the page's own dedicated template (`page-{slug}.php` or `Template Name:` file),
  following `page.php`/`front-page.php`'s existing shape (`get_header()` → content → `get_footer()`).
  Reusable pieces go in `template-parts/*.php`. If a branch-A `post_meta` container was added in
  step 3, read it with `Utils::getPostMetaFw()`, matching every other CF-backed field in this
  theme.
- **Branch A2** → `template-parts/sections/{type}.php`. Read the section's own data straight from
  `$args['section']` (matching `hero.php`/`text.php`/`cta.php`'s existing shape) — don't re-fetch
  meta inside the partial, the dispatch loop in the Flexible Content template already read it once
  via `Utils::getPostMetaFw()`. Escape everything on the way out:
  `esc_html()`/`esc_url()`/`wp_kses_post()` for anything that went through a rich-text field.
- **Branch B** → the page template itself (`single.php`/`category.php`/`search.php`/etc. —
  whichever `convert-to-classic-theme` scaffolded; if the needed template wasn't scaffolded, that's
  a gap to flag to the user, not something to silently add outside this skill's scope) or a
  template-part for the loop, calling a `Repository` method — never a raw `new WP_Query(...)`
  sitting in a view file when a repository method would do. Pagination is `paginate_links()` with
  real URLs (`/category/page/2`), never JS-driven — this matches how WordPress's own template
  hierarchy already works, not a design choice to reconsider.
- Read any sitewide (branch D) value the same way: `Utils::getOptionFw()` for `theme_options`,
  `Utils::getTermMetaFw()` for `term_meta`, `Utils::getUserMetaFw()` for `user_meta`. If a value
  the handoff needs is genuinely *not* Carbon Fields-backed (a WordPress core option like
  `blog_charset`), that's the one legitimate case for a raw WP accessor — see `conventions.md`'s
  "one legitimate exception" — but that's rare and should be the exception you can name, not the
  default you reach for.
- **CSS** → new partial(s) under `assets/src/styles/layout/`, imported the same way the existing
  partials are. Map the handoff's design tokens onto the theme's existing Bootstrap
  variables/overrides in `custom_bootstrap/` wherever they overlap (colors, spacing scale, radii)
  instead of introducing a second, parallel custom-property system that fights the first.
- **JS** → only if the handoff genuinely needs client-side behavior beyond CSS (e.g. a sticky
  table-of-contents highlight). Add it under `assets/src/js/FrontComponents/`, following the
  existing module pattern — don't reach for a new bundler entry point or an inline `<script>` tag.

## 5. Wire it up

One new line per new Carbon Fields container in `src/Base/Hooks.php`'s `carbon_fields_register_fields`
section, grouped with the existing lines there. This is the only manual registration step — no
parallel bootstrap, no second place hooks get added.

## 6. Build and lint

```bash
composer lint    # PSR-12 — fix any fallout in newly generated PHP
npm run lint     # Stylelint + ESLint on new SCSS/JS
npm run prod     # confirm the production build still compiles
```

## 7. Verify

Give this checklist to the user (or hand it to `qa-analyst`/`acceptance-tester`):

- Every new dedicated page template (branch A) actually resolves for its target page — check the
  real front end, not just that the file exists (a wrong filename/slug or missing `Template Name:`
  registration silently falls back to `page.php`).
- Every new Carbon Fields field (branch A, A2, and D) is actually editable in wp-admin, and the
  front end reflects the real value entered — not an empty section/field, which usually means the
  `$args['section']`/meta-key unpack is wrong.
- A repo-wide grep for `get_post_meta(`, `update_post_meta(`, `get_option(`, `update_option(`,
  `carbon_get_`, `carbon_set_` inside the files this skill just generated returns nothing — every
  read/write went through `Helper\Utils`.
- Any branch-B listing with more items than fit on one page shows working pagination (page 2+
  reachable via a real URL).
- `blocks/` is untouched (`git diff --stat -- blocks/` shows nothing) unless the user explicitly
  asked for a genuinely new block outside this skill — that request belongs with
  `create-gutenberg-block`, not folded in here silently.
- If branch A2 was used: `PageBuilder.php` still has exactly one `complex` field for sections —
  confirm no second page-content mechanism was introduced alongside it — and pages *not* using the
  Flexible Content template still render through their own plain templates, confirming the builder
  stayed additive rather than becoming the default path.
- The classification table from step 2 matches what actually got built — no branch silently
  changed during implementation without telling the user.

**Never commit.** Leave the diff for the user to review.
