# starter-kit-theme — AI guide

The custom FSE block theme for **StarterKit Foundation** — and the project's **main application
codebase**: CPTs, meta, blocks, settings, analytics and security all live here.
Namespace `StarterKit\` → `src/`. PHP 8.1+, PSR-12, Bootstrap 5.
Runs inside the StarterKit Foundation Docker environment.

## Contents — where the guides are

| Guide | Covers |
|-------|--------|
| **this file** (`CLAUDE.md`) | PHP standards, architecture, Carbon Fields, FSE, theme structure |
| **`blocks/CLAUDE.md`** | Gutenberg block creation — auto-loads when you work in `blocks/` |

Sections below: NOT classic WordPress · PSR-12 & linting · Bootstrap flow · FSE · src/ structure ·
Key rules · File header · Class patterns · Config & Utils · Carbon Fields · Security · Type hints ·
Adding new things · Never.

## NOT classic WordPress

No procedural functions, no global functions, no `functions.php` logic dumps.
Everything is PSR-12 OOP. Follow existing patterns — never invent new ones.
Read existing code before modifying.

## PSR-12 & linting

PSR-12 is enforced by `phpcs.xml`. Run `make lint` before committing (from the foundation), or
inside this repo: `composer lint` / `composer lintfix`.

## Bootstrap flow

```
functions.php
  → require vendor/autoload.php
  → apply_filters('starter_kit/container', require config/container.php)
  → App::instance()->run($container)
  → Constants::define() + Hooks::initHooks() + CLI::addCommands()
```

## FSE — block theme

```
templates/   Full-page block templates (.html): index, front-page, home, page, single,
             404, page-with-hero, page-without-title
parts/       Template parts (.html): header.html, footer.html
patterns/    Block patterns as PHP files: header.php, footer.php
theme.json   Global styles, color palette, block settings
style.css    Theme identity header only — no real CSS here
blocks/      Gutenberg blocks — see blocks/CLAUDE.md
```

## src/ structure

```
App.php                       Bootstrap (AbstractSingleton)
AbstractSingleton.php
Base/
  Constants.php                Defines SK_PREFIX, SK_HOOKS_PREFIX, SK_REST_API_NS, SK_BLOCKS_* ...
  Hooks.php                    ALL add_action/add_filter — the only hook registry
Helper/  Config.php, Utils.php
Handlers/
  SetupTheme.php               Theme support, image sizes, menus
  Front.php / Back.php         Asset enqueue
  Analytics.php                GTM / Google Analytics
  AdminColumns.php
  PostTypes/                   CPT registration: News (+ Category/Tag taxonomies), TeamMember, Service
  Meta/PostMeta/               CF containers: News, Page
  Meta/TaxonomyMeta/, Meta/UserMeta/
  Settings/ThemeSettings.php   Carbon_Fields::boot() + theme_options container
  Blocks/Init.php              Block auto-discovery and registration
  Optimization/, Security/, Mail/, CLI/
Repository/                    WpPostRepositoryAbstract + per-CPT repositories
```

## Key rules

- Carbon Fields is **booted by the theme** (`ThemeSettings::boot()` on `after_setup_theme`)
- All CPTs / meta / blocks / business logic → here in the theme
- Global styles, colors, spacing → `theme.json`, never inline CSS
- Heavy logic does not belong in a `.html` template — build a block instead (see `blocks/CLAUDE.md`)
- The theme is Bootstrap 5 based; use Bootstrap utility classes in markup

## File header — every PHP file in `src/`

```php
<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;
```

No `declare(strict_types=1)` — the codebase does not use it. Match the surrounding files.

## Class patterns

**Singleton** — only `App` (entry point), via `AbstractSingleton`. Never make handlers singletons.
Access the DI container anywhere:

```php
App::container()->get(LoggerInterface::class);
```

**Static handler — the dominant pattern.** Handlers are never instantiated; all methods `public static`:

```php
class Front {
    public static function enqueueAssets(): void { ... }
}
add_action('wp_enqueue_scripts', [Front::class, 'enqueueAssets']);   // in Hooks.php only
```

Never `new Front()`, never `$front->method()`.

**Repository — extends `WpPostRepositoryAbstract`.** Every CPT that needs querying gets one;
it defines the abstract `getPostTypeKey()`:

```php
class NewsRepository extends WpPostRepositoryAbstract {
    public static function getPostTypeKey(): string { return PostTypes\News::getKey(); }
}
// Base methods: get() → WP_Post[], getIds() → int[], getAllList() → [ID => title],
// getPagedList(), getById(), getBySlug(), getRecentPosts(), getRelatedPosts(), getOne() ...
```

Prefer repositories for reusable CPT queries. Small local admin closures may use WP query helpers
when a repository would add no value.

**Hooks — all in one place.** `src/Base/Hooks.php` → `initHooks()` is the ONLY place for
`add_action` / `add_filter`. Never register hooks inside handler methods or constructors.

## Config & Utils

```php
Config::get('settingsPrefix')      // top-level key
Config::get('postTypes/SiteID')    // nested — walks the array by '/'
```

Meta / options — **always via Utils, never raw**:

```php
Utils::getPostMeta($postId, $metaPrefix . 'field');     // WP API,  uses _SK_PREFIX
Utils::getPostMetaFw($postId, $metaPrefix . 'field');   // CF API — complex / association fields
Utils::setPostMeta($postId, $metaPrefix . 'field', $v);
Utils::getOptionFw('gtm_code');   // CF theme option (SK_PREFIX)
Utils::getOption('some_key');     // plain WP option (_SK_PREFIX)
```

Utils auto-adds the prefix and is idempotent. Getters return `$defaultValue` when the value is
`''`, `false`, `null`, or `[]`. NEVER call raw `get_post_meta()` / `update_post_meta()` /
`get_option()` / `carbon_get_post_meta()`.

## Carbon Fields

**Boot**: the theme boots CF — `ThemeSettings::boot()` on `after_setup_theme` in `Hooks.php`.
Never boot it twice.

**Register fields**: use the `carbon_fields_register_fields` hook — never `init` (silently fails):

```php
// In Hooks.php:
add_action('carbon_fields_register_fields', [Meta\PostMeta\MyType::class, 'make']);

// In src/Handlers/Meta/PostMeta/MyType.php:
public static function make(): void {
    $metaPrefix = SK_PREFIX . PostTypes\MyType::getKey() . '_';
    Container::make('post_meta', __('Settings', 'starter-kit'))
        ->where('post_type', '=', PostTypes\MyType::getKey())
        ->add_fields([ Field::make('text', $metaPrefix . 'field_name', __('Label', 'starter-kit')) ]);
}
```

One `Container::make` per CPT. Never call it before `carbon_fields_register_fields` fires.
Prefix pattern: `SK_PREFIX . PostTypes\Type::getKey() . '_'` for post meta; `SK_PREFIX` alone for
theme options. Read/write only via `Utils` (above) — `getPostMetaFw` for complex / association.

**Field type gotchas — Claude gets these wrong without being told:**

- `checkbox` → returns `'yes'` / `''`, NOT `true` / `false`
- `relationship` is deprecated → use `association` instead
- `association` returns `[['id'=>..., 'type'=>..., 'subtype'=>...]]` → `wp_list_pluck($result, 'id')` for IDs
- `complex` (repeater) returns `array[]` → always null-check before iterating; read with `getPostMetaFw`
- `select` options format: `['value' => 'Label']`; dynamic: `->set_options(fn() => [...])`
- Container chain helpers: `->set_priority()`, `->set_context()`, `->set_width()`, `->set_conditional_logic()`

## Security — mandatory

```php
$clean = sanitize_text_field($_POST['field']);          // input — sanitize early
$html  = wp_kses_post($_POST['content']);
echo esc_html($value); echo esc_url($url); echo esc_attr($attr);   // output — escape late
$wpdb->prepare("SELECT * FROM t WHERE id = %d", $id);   // queries — always prepared
```

## Type hints

PHP 8.1+: typed properties, `mixed`, union types, `?string` nullables, return types on all
public methods.

## Adding new things

| What | Where |
|------|-------|
| Hook | `src/Base/Hooks.php` → `initHooks()` |
| CPT | `src/Handlers/PostTypes/NewType.php`, register in `Hooks.php` |
| CF container | `src/Handlers/Meta/PostMeta/NewType.php`, hook in `Hooks.php` |
| Repository | `src/Repository/NewTypeRepository.php` extends `WpPostRepositoryAbstract` |
| Page template | `templates/name.html` (block markup) |
| Template part | `parts/name.html` |
| Block pattern | `patterns/name.php` |
| Block | `blocks/NewBlock/` — see `blocks/CLAUDE.md` |
| Config key | `config/common/main.php` or appropriate config file |
| WP-CLI command | `src/Handlers/CLI/` |

## Never

- Global / procedural functions or global helpers
- `new SomeHandler()` to register hooks; hooks inside constructors or methods
- Raw `get_post_meta()` / `update_post_meta()` / `get_option()` for CF fields
- Reusable CPT queries outside a Repository
- `var_dump` / `print_r` / `error_log` left in code
- `TODO` / `FIXME` in committed code
