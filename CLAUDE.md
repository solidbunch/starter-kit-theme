# starter-kit-theme

The custom FSE block theme for **StarterKit Foundation** — and the project's **main application
codebase**: CPTs, meta, blocks, settings, analytics and security all live here.
Namespace `StarterKit\` → `src/`. PHP 8.1+, PSR-12, Bootstrap 5.

Runs inside the StarterKit Foundation Docker environment. Build & lint from the foundation
(`make watch`, `make lint`) or in this repo (`composer lint`, npm scripts).
Gutenberg block rules: see `blocks/CLAUDE.md` (auto-loads when you work in `blocks/`).

## NOT classic WordPress

No procedural functions, no global functions, no `functions.php` logic dumps. Everything is
PSR-12 OOP. Read existing code before modifying — follow patterns, never invent.

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

- New page template → `.html` in `templates/` (block markup); template part → `.html` in `parts/`
- Block pattern → PHP file in `patterns/`
- Global styles / colors / spacing → `theme.json`, never inline CSS
- Heavy logic does not belong in a `.html` template — build a block instead

## src/ structure

```
App.php                       Bootstrap (AbstractSingleton)
AbstractSingleton.php
Base/
  Constants.php                SK_PREFIX, SK_HOOKS_PREFIX, SK_REST_API_NS, SK_BLOCKS_* ...
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

## File header — every PHP file in `src/`

```php
<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;
```

No `declare(strict_types=1)` — the codebase does not use it. Match the surrounding files.

## Class patterns

**Singleton** — only `App` (entry point), via `AbstractSingleton`. Access the DI container with
`App::container()->get(LoggerInterface::class)`. Never make handlers singletons.

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

**Hooks — all in one place.** `src/Base/Hooks.php` → `initHooks()` is the ONLY place for
`add_action` / `add_filter`. Never register hooks inside handler methods or constructors.

## Config & Utils

```php
Config::get('settingsPrefix')      // top-level key
Config::get('postTypes/SiteID')    // nested — walks the array by '/'
```

NEVER call raw `get_post_meta()`, `update_post_meta()`, `get_option()`, `carbon_get_post_meta()`.
Always go through `Utils` — it auto-adds the project prefix and is idempotent:

```php
Utils::getPostMeta($postId, $metaPrefix . 'field');     // WP API,  uses _SK_PREFIX
Utils::getPostMetaFw($postId, $metaPrefix . 'field');   // CF API — complex / association fields
Utils::setPostMeta($postId, $metaPrefix . 'field', $v);
Utils::getOptionFw('gtm_code');   // CF theme option (SK_PREFIX)
Utils::getOption('some_key');     // plain WP option (_SK_PREFIX)
```

Getters return `$defaultValue` (default null) when the value is `''`, `false`, `null`, or `[]`.

## Carbon Fields

**Boot**: the theme boots CF — `ThemeSettings::boot()` on `after_setup_theme` in `Hooks.php`. Never twice.

**Register fields**: via the `carbon_fields_register_fields` hook — never `init` (silently fails):

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

One `Container::make` per CPT. Prefix: `SK_PREFIX . PostTypes\Type::getKey() . '_'` for post meta;
`SK_PREFIX` alone for theme options. Read/write only via `Utils` (above).

**Field type gotchas:**

- `checkbox` → returns `'yes'` / `''`, NOT `true` / `false`
- `relationship` is deprecated → use `association` (returns `[['id'=>...]]` → `wp_list_pluck($r, 'id')`)
- `complex` (repeater) → returns `array[]`; null-check before iterating; read with `getPostMetaFw`
- `select` options: `['value' => 'Label']`; dynamic `->set_options(fn() => [...])`

## Security — mandatory

```php
$clean = sanitize_text_field($_POST['field']);  $html = wp_kses_post($_POST['content']);  // input
echo esc_html($value); echo esc_url($url); echo esc_attr($attr);                          // output
$wpdb->prepare("SELECT * FROM t WHERE id = %d", $id);                                     // queries
```

## Adding new things

| What | Where |
|------|-------|
| Hook | `src/Base/Hooks.php` → `initHooks()` |
| CPT | `src/Handlers/PostTypes/NewType.php`, register in `Hooks.php` |
| CF container | `src/Handlers/Meta/PostMeta/NewType.php`, hook in `Hooks.php` |
| Repository | `src/Repository/NewTypeRepository.php` extends `WpPostRepositoryAbstract` |
| Page template / part | `templates/name.html` / `parts/name.html` |
| Block pattern | `patterns/name.php` |
| Block | `blocks/NewBlock/` — see `blocks/CLAUDE.md` |
| WP-CLI command | `src/Handlers/CLI/` |

## Never

- Global / procedural functions; `new SomeHandler()` to register hooks
- Hooks outside `src/Base/Hooks.php`
- Raw `get_post_meta()` / `get_option()` / `carbon_get_post_meta()` — use `Utils`
- Reusable CPT queries outside a Repository
- `var_dump` / `print_r` / `error_log` / `TODO` / `FIXME` in committed code

Run `make lint` (or `composer lint`) before committing.
