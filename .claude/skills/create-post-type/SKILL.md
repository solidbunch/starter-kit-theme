---
name: create-post-type
description: >
  Registers a new custom post type (and optional taxonomy, repository, Carbon Fields meta
  container) in this theme (StarterKit Foundation) — the full storage bundle a content entity
  needs, not just `register_post_type()`. Use this when a piece of data needs its own storage
  independent of `post`/`page`, is reused across more than one template/block, or has its own
  fields/relationships beyond what an existing Repository method covers. Triggered directly, or
  handed off to from `create-classic-template` (branch B needing new storage) and
  `create-gutenberg-block` (a dynamic block backed by its own CPT, e.g. `News`). Always consult
  this before hand-writing `register_post_type()` — it sequences the full bundle so nothing is
  half-wired.
---

# Registering a new post type in this theme

**What this does NOT do**: it doesn't decide whether a new CPT is warranted in the first place —
that call is made by whichever skill hands off here (`create-classic-template`'s branch-B
criteria, or `create-gutenberg-block`'s block-type decision), or by the user directly. Don't
second-guess an explicit request to create a post type; do push back if you're asked to create one
for data that's clearly a single, non-reused, flat set of fields — that's Carbon Fields
`post_meta` on an existing post type instead, not a new entity (see `content-types.md`).

Three existing post types are the reference patterns for every step below — read them before
writing anything:

- `src/Handlers/PostTypes/News.php` — public, front-end-visible, own archive, two taxonomies
  (category + tag), `show_in_rest: true` (Gutenberg editor)
- `src/Handlers/PostTypes/Service.php` — `public: false`, `show_in_rest: false` (classic
  meta-box editing, no block editor), reference/lookup type with no dedicated front-end template
- `src/Handlers/PostTypes/TeamMember.php` — same reference-type shape as `Service`, no archive at
  all (`has_archive: false`)

All paths below are relative to this theme's own root directory (`web/wp-content/themes/<theme-folder>/`).

## 1. Decide the shape before writing code

Answer these against the three reference classes above, don't invent new answers from scratch:

- **Public and front-end-visible, or purely a reference/lookup type edited only in wp-admin?**
  Public → `News`'s shape (`public: true`, `has_archive`, `rewrite`). Reference-only → `Service`'s
  shape (`public: false`, `show_in_rest: false`, `rewrite: false`) — this is the far more common
  case for "sub-data" entities (a repeatable thing referenced *from* other content, not visited
  directly).
- **Gutenberg block editor, or classic meta boxes?** `show_in_rest: true` enables the block editor
  (only makes sense if this type will actually have rich body content, like `News`); reference
  types almost always want `show_in_rest: false` — Carbon Fields meta boxes are the real editing
  surface for them (`Service`/`TeamMember` both work this way).
- **Own archive page?** `has_archive: true` (`News`, `Service`) vs. `false` (`TeamMember`) — only
  set `true` if there's actually a front-end listing template for it.
- **Needs its own taxonomy?** Only if terms genuinely belong to this entity and aren't already
  covered by an existing taxonomy — `News` is the only reference type with one (two, in fact:
  category + tag). Don't add a taxonomy "just in case."
- **`supports` array** — include only what's actually edited: `title` is near-universal, `editor`
  only if there's real rich-text body content, `thumbnail` only if a featured image is used,
  `page-attributes` only if manual ordering (`menu_order`) matters (`News` uses it for exactly
  that).

Present this short list of decisions to the user before generating anything if any of them isn't
obvious from the request — same discipline as `create-classic-template`'s classification-table
gate. A wrong `public`/`show_in_rest` choice is expensive to walk back once content has been
entered against it.

## 2. `src/Handlers/PostTypes/<Name>.php`

Copy the closest reference class's structure exactly — `getKey()` (the post type slug),
`registerPostType()`, and `getRewriteSlug()` / taxonomy getters only if applicable. Keep the same
`capabilities` remap (`edit_pages`-style, not the post-type default) unless there's a specific
reason not to — every existing type does this, don't invent a different capability mapping.

If a taxonomy is needed, add `registerCategoryTaxonomy()`/`registerTagTaxonomy()`-style methods on
the **same** class (`News` does both categories and tags this way) — don't create a separate
taxonomy-only class.

## 3. `src/Repository/<Name>Repository.php`

Extend `WpPostRepositoryAbstract`, implement only `getPostTypeKey()` returning
`PostTypes\<Name>::getKey()`. The abstract already provides `get()`, `getById()`, `getBySlug()`,
`getRecentPosts()`, `getRelatedPosts()`, `getRandomPosts()`, `getAllList()`, `getPagedList()`, and
more — add entity-specific methods (thin wrappers like `NewsRepository::getRecentNews()`, or pure
data-shaping helpers with no query in them like `getNewsPowerByImpact()`) only for what's actually
needed, don't restate the abstract's methods with different names.

## 4. Carbon Fields meta — only if this entity has its own fields

Add `src/Handlers/Meta/PostMeta/<Name>.php` (or `TaxonomyMeta/<Name>.php` if the fields belong on
the new taxonomy's terms instead), following `Meta/PostMeta/News.php`'s shape: a static `make()`
building `Container::make('post_meta', ...)->where('post_type', '=', PostTypes\<Name>::getKey())`.
Prefix every field key with `SK_PREFIX` (`$metaPrefix = SK_PREFIX . PostTypes\<Name>::getKey() .
'_';`). **Never guess a Carbon Fields field type/method/option** — confirm the real API at
<https://docs.carbonfields.net/> before writing any `Field::make(...)` call (same rule
`create-classic-template` follows, for the same reason: a field type invented from memory fails
silently or throws deep inside Carbon Fields).

If this entity needs repeatable sub-data (the "has its own sub-data" case that justified a new CPT
in the first place), that's either a `complex` field on this container (`News`'s
`related_data` pattern — sub-data that's always edited *with* the parent, never queried on its
own) or, if the sub-data itself needs to be queried/reused independently, its own separate CPT one
level down — apply this same skill recursively rather than nesting indefinitely.

## 5. Wire it up — `src/Base/Hooks.php`

Two separate registration blocks, both in `initHooks()`, grouped with the existing lines of the
same kind — this is the only manual step, nothing self-registers the way blocks do:

```php
// grouped with the other "PostTypes with Taxonomies" lines, priority 5:
add_action('init', [Handlers\PostTypes\<Name>::class, 'registerPostType'], 5);
add_action('init', [Handlers\PostTypes\<Name>::class, 'registerCategoryTaxonomy'], 5); // if applicable

// grouped with the other carbon_fields_register_fields lines:
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\<Name>::class, 'make']); // if step 4 applies
```

Keep the taxonomy registration at the same `init` priority `5` as the post type — existing code
relies on this ordering, don't drop the priority argument.

## 6. Build and lint

```bash
composer lint    # PSR-12 — fix any fallout in newly generated PHP
npm run prod     # confirm the production build still compiles (meta/admin changes are PHP-only,
                  # but run this if any JS/CSS touched the change, e.g. block usesContext updates)
```

## 7. Verify

```bash
# Is the post type actually registered?
docker compose exec php su -c "wp eval 'var_dump(post_type_exists(\"<key>\"));'" www-data

# Does the admin list screen load and show the expected columns/capabilities?
```

- New post type shows up in wp-admin with the right menu position/icon, editable by the intended
  role (check the `capabilities` remap actually matches an existing role's capabilities).
- If Carbon Fields meta was added: every field is editable in wp-admin and a saved value round-trips
  through `Utils::getPostMetaFw()` — not silently empty, which usually means a prefix mismatch
  (`SK_PREFIX` vs `_SK_PREFIX`, see `conventions.md`).
- If a taxonomy was added: terms are assignable and (if `show_admin_column: true`) visible as a
  column on the post list screen.
- A repo-wide grep for `get_post_meta(`, `update_post_meta(` inside the new Meta class returns
  nothing — reads/writes went through `Helper\Utils`, not raw WP functions.
- Whatever skill handed off here (`create-classic-template`/`create-gutenberg-block`) can now
  resume using the new `<Name>Repository` method — confirm that handoff actually works end to end
  rather than stopping at "the CPT exists."

**Never commit.** Leave the diff for the user to review.
