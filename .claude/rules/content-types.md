# Content types — Carbon Fields, and the FSE markup folders

## Carbon Fields (`htmlburger/carbon-fields` ^3.6.5)

All registration happens on the `carbon_fields_register_fields` action, wired in `Hooks.php` —
never call `Container::make()` outside that hook, fields silently don't register otherwise.
`ThemeSettings::boot()` (on `after_setup_theme`) calls `Carbon_Fields::boot()` once; `make()` (on
`carbon_fields_register_fields`) builds the actual `theme_options` container with tabs (General →
Identity/Favicon, Analytics, ...). `NewsSettings` and each `Meta/{PostMeta,TaxonomyMeta,UserMeta}/*`
class follow the same two-step shape for their own containers.

- **Field keys**: always build with `SK_PREFIX` (`skt_`) — e.g.
  `$metaPrefix = SK_PREFIX . PostTypes\News::getKey() . '_'`. Read them back with the `*Fw` methods
  in `Helper\Utils` (see `conventions.md`) — plain `get_post_meta()` will not see them.
  `Container::make('post_meta', ...)->where('post_type', '=', ...)` scopes a container to one CPT.
- `complex` fields (repeatable field groups, e.g. `News`'s `related_data`) nest `Field::make()`
  calls inside `->add_fields('group_name', label, [...])` — copy the existing pattern rather than
  hand-rolling repeater logic.
- **Full-page CF-backed block** (a dynamic Gutenberg block whose content is entirely driven by CF
  fields on the current post — "fill in fields, get a complete section") is documented in full,
  with the REST-context `postId` gotchas, in `blocks/CLAUDE.md` — read that before building one.

## `templates/`, `parts/`, `patterns/` — three different FSE roles, all block markup

These are **not** related to the PHP classes in `src/` — they're FSE (Full Site Editing) content,
made of Gutenberg block comments/HTML, auto-registered by WordPress core just by existing in these
folders:

- **`templates/*.html`** — full page templates (`front-page.html`, `page.html`, `single.html`,
  `404.html`, ...). `page-with-hero.html` / `page-without-title.html` are registered as
  **custom templates** selectable in the editor via `theme.json`'s `customTemplates` (which also
  restricts one, `single-doc-page`, to a specific `postTypes` — the `doc-page` CPT, if/when it
  exists — check it's actually registered before assuming the template applies).
- **`parts/*.html`** — template parts referenced from templates (`header.html`, `footer.html`),
  pure block markup, no PHP header comment.
- **`patterns/*.php`** — reusable block patterns, each a `.php` file whose **PHP-comment block**
  at the top (`Title:`, `Slug:`, `Categories:`, `Block Types:`, `Description:`) is WordPress's own
  pattern-registration metadata (not a docblock you write freely — every field is meaningful to
  WP's pattern registry). `Block Types:` on `patterns/header.php` binds it to
  `core/template-part/header`, i.e. it's offered specifically when editing that template part.
  The body below the comment is plain block markup, same as `parts/`/`templates/` — the `.php`
  extension exists only so the leading comment can be parsed as pattern metadata, not because PHP
  logic runs here.

All three are built from the theme's custom blocks (`starter-kit/section`, `starter-kit/row`,
`starter-kit/column`, ...) — see `blocks/CLAUDE.md` for the block catalogue and attribute shapes
(e.g. `modification`, `spacers`, `properties`) used throughout this markup.
