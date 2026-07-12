# PHP conventions

## This is not "classic WordPress" PHP — it's PSR-standard OOP

A typical WP theme is procedural: functions in `functions.php`, globals, `add_action('init', 'my_function')`.
This theme is deliberately not that — every verified pattern below is a real, checkable thing in
this codebase, not an aspiration:

| Standard/pattern | Where it's real, verified |
| --- | --- |
| **PSR-4** autoloading | `composer.json` `autoload.psr-4`: `StarterKit\`→`src/`, `StarterKitBlocks\`→`blocks/`, `StarterKitTests\`→`tests/` (dev-autoload) — no `functions.php`-style function dumps outside `src/dev.php` (see `architecture.md`), which is deliberately global/procedural *because* it's a debug-helper library meant to be callable from anywhere without an import |
| **PSR-12** coding style | Enforced by `phpcs.xml` (`rule ref="PSR12"`), CI-checked (`build-and-ci.md`) |
| **PSR-1**, partially | `phpcs.xml` includes it but excludes `PSR1.Files.SideEffects.FoundWithSymbols` — the one deliberate exception, for the `defined('ABSPATH') || exit;` guard every file needs |
| **PSR-3** (`Psr\Log\LoggerInterface`) | `App::run()` takes a `LoggerInterface` out of the container (`src/App.php:9,41`); bound to a real Monolog logger in `config/common/logger.php` — code depends on the *interface*, not on Monolog directly |
| **PSR-11** (`Psr\Container\ContainerInterface` / `NotFoundExceptionInterface`) | `App`'s container is typed as `ContainerInterface`, not the concrete PHP-DI class (`src/App.php:7,23`); `ConfigEntryNotFoundException` *implements* `Psr\Container\NotFoundExceptionInterface` (`src/Exception/ConfigEntryNotFoundException.php:5,10`) — a config-lookup miss is modeled as a real PSR container exception, not a bespoke one |
| **Dependency Injection container** (`php-di/php-di`) | `config/container.php` + `config/dependencies.php` build the container; swappable via the `starter_kit/container` filter (`architecture.md`) — this is inversion of control, not `new SomeClass()` scattered through hooks |
| **Layered/aggregated configuration** (`laminas/laminas-config-aggregator`) | `config/dependencies.php` merges `config/common/*.php` + env-specific providers into one config array (`architecture.md`) — a Composite-style merge instead of one giant config file or scattered constants |
| **Singleton** (textbook form: private-array registry, protected constructor/`__clone`) | `src/AbstractSingleton.php` — `App extends AbstractSingleton` is the one intentional singleton (the app entrypoint); not used as a general-purpose pattern elsewhere |
| **Repository pattern** | `src/Repository/` — `WpPostRepositoryInterface`/`WpUserRepositoryInterface` + `WpPostRepositoryAbstract` base, concrete `NewsRepository`/`ServiceRepository`/etc. — see the dedicated section below |
| **Program to an interface, not an implementation** (SOLID's "D") | `BlockInterface` (blocks), `CLICommandInterface` (WP-CLI commands), `WpPostRepositoryInterface`/`WpUserRepositoryInterface` (repositories) — each concrete family is built behind an interface, even though WordPress itself never requires this |
| **Fail-fast custom exceptions** instead of silent `null`/`false` | `Helper\Config::get()` throws `ConfigEntryNotFoundException` on a missing key (`architecture.md`) rather than returning `null` — a deliberate departure from WordPress's usual "return false and let the caller maybe check" convention |
| **Chain/pipeline of handlers** | `ErrorHandler::register()` builds a `Whoops\Run` and `pushHandler()`s several handlers in sequence (pretty page, AJAX, REST, plain-text, then a logging closure) — each handler decides whether to act; conceptually the same shape as PSR-15 middleware, applied to error handling |
| **Convention-based registration / auto-discovery** instead of a manual registry | `Handlers\Blocks\Init::loadBlocks()` globs `blocks/*`, and *instantiates a class by string convention* (`{namespace}\{FolderName}\Block`) rather than requiring every block to be hand-registered in `Hooks.php` — same idea `CloneTheme`'s search/replace and the Repository/PostTypes per-entity classes lean on: one place decides the shape, every concrete instance just fills it in |

## Naming case — PSR-1, not WordPress's own coding standard

WordPress's official PHP coding standards mandate **snake_case** for everything — function names
(`register_post_type()`), variables (`$post_id`), hook names (`wp_enqueue_scripts`). This theme's
**own** identifiers follow **PSR-1** instead (`phpcs.xml`'s `PSR1` rule, see above — PSR-1 §4.3
mandates camelCase methods and StudlyCaps class names):

| Identifier kind | Convention here | Evidence |
| --- | --- | --- |
| Classes/interfaces | `StudlyCaps` | `NewsRepository`, `BlockAbstract`, `WpPostRepositoryInterface` |
| Methods, functions, local variables, properties | `camelCase` | `registerBlockArgs()`, `getRecentNews()`, `$blockName`, `$metaPrefix`, `$newThemeDirectory` — never `register_block_args()` or `$block_name` |
| Class constants / `define()`-d constants | `UPPER_SNAKE_CASE` | `SK_PREFIX`, `SK_HOOKS_PREFIX` (PSR-1 §4.4) |
| Block/CPT/Handler directory names | `PascalCase` | `blocks/FaqSection/`, `Handlers/PostTypes/TeamMember.php` |

This only applies to the theme's **own** code. Calls *into* WordPress core/plugin APIs stay
snake_case because that's the API's own naming, not a choice this theme makes — e.g.
`add_action('carbon_fields_register_fields', [Handlers\Settings\ThemeSettings::class, 'make'])`
mixes a snake_case WP hook name with a camelCase theme method name in the same line, and that's
correct, not an inconsistency to "fix".

**What's deliberately *not* here**, despite being available in PHP `>=8.4` — don't assume these are
house style just because the PHP version supports them: no `enum`s, no `readonly` properties, no
constructor property promotion, no nullsafe (`?->`) operator, and `match` is used exactly once
(`NewsRepository::getNewsPowerByImpact()`). The "modern" story in this codebase is **PSR compliance
+ OOP/DI/SOLID structure**, not PHP syntax-sugar adoption — don't introduce those features
speculatively to "modernize" code further; match the existing style (explicit `if`/typed
properties/plain constructors) unless asked to do otherwise.

## Prefix constants (`Base\Constants::define()`, from `config/common/main.php`)

| Constant | Value | Used for |
| --- | --- | --- |
| `SK_PREFIX` | `skt_` | Carbon Fields option/meta keys |
| `_SK_PREFIX` | `_skt_` | Raw WP option/meta keys (leading underscore = hidden/protected meta) |
| `SK_HOOKS_PREFIX` | `starter_kit` | Custom filter/action names, e.g. `starter_kit/block_asset_dependencies` |
| `SK_REST_API_NS` | `skt/v1` | Custom REST routes (`register_rest_route(SK_REST_API_NS, ...)`) |
| `SK_ASSETS_DIR` / `SK_ASSETS_URI` | `assets/` abs path / URL | `Helper\Assets` script/style registration |
| `SK_BLOCKS_DIR` / `SK_BLOCKS_URI` / `SK_BLOCKS_NS` / `SK_BLOCKS_VIEW_DIR` | `blocks/` path/URL/namespace/`view/` | Block autoloading — see `blocks/CLAUDE.md` |

## `Helper\Utils` — plain WP vs Carbon Fields, always paired

**Hard rule, verified against the codebase**: any value that belongs to this theme's own storage
(theme options, post/term/user meta) is read and written **only** through `Helper\Utils` — never
call `get_post_meta()`/`update_post_meta()`/`get_option()`/`update_option()` or Carbon Fields'
`carbon_get_*()`/`carbon_set_*()` functions directly in your own code. This isn't aspirational: a
repo-wide grep confirms **zero** direct `carbon_get_*`/`carbon_set_*` calls anywhere outside
`Helper/Utils.php` itself. Keep it that way — a new Handler/Repository/block that calls
`carbon_get_post_meta()` directly, even once, breaks this invariant.

Every accessor family exists in two forms — **use the right one, they read/write different
storage**:

- Plain (`getOption`, `getPostMeta`, `getTermMeta`, `getUserMeta`, ...) → raw `get_option()` /
  `get_post_meta()` / etc., prefixed with `_SK_PREFIX`.
- `*Fw` (`getOptionFw`, `getPostMetaFw`, `getUserMetaFw`, `getMenuItemMetaFw`, ...) → Carbon
  Fields' own `carbon_get_*()` functions, prefixed with `SK_PREFIX`. Required for any value stored
  through a Carbon Fields `Container`/`Field` (theme options, post/term/user meta registered via
  `carbon_fields_register_fields`) — reading a CF-backed field with the plain accessor (or vice
  versa) silently returns the default, because the storage key prefix differs (`_skt_` vs `skt_`).
- All getters normalize falsy values (`''`, `false`, `null`, `[]`) to the given `$defaultValue` —
  don't add extra `?:`/`empty()` guards around them, it's already handled.
- `addPrefix()`/`isPrefixed()` are prefix-agnostic helpers used internally by every accessor above
  — reuse them if you need the same "add prefix once" behavior elsewhere, don't reimplement.
- Environment helpers: `isDevEnvironment()` / `isLocalEnvironment()` / `isStagingEnvironment()` /
  `isProdEnvironment()` wrap `wp_get_environment_type()`. `isHideErrorsMode()` = NOT debug, OR NOT
  debug-display, OR production — the actual gate used by `ErrorHandler` and Whoops.

**The one legitimate exception**: raw `get_option()`/`update_option()` calls for WordPress's own
**core** option names — `blog_charset` (`Error\AjaxHandler`, `Error\RestApiHandler`), `site_icon`
(`Handlers\Settings\ThemeSettings`), `page_on_front` (`Handlers\Optimization\CleanAttributes`) —
these are fixed, non-prefixed WP core keys, not theme storage, so routing them through
`Utils::getOption()` would be wrong (it would prepend `_skt_` to a key that WP itself defines
without any prefix). The rule is "own storage goes through `Utils`", not "never call a raw WP
function" — know which case you're in before picking a side.

## Repository pattern (`src/Repository/`)

One repository class per post type/entity, extending `WpPostRepositoryAbstract` (or implementing
`WpPostRepositoryInterface`/`WpUserRepositoryInterface` directly for non-post-type sources).
Static methods only, e.g. `NewsRepository::getRecentNews()` / `getRelatedNews()` /
`getRandomNews()` delegate to the abstract's generic `getRecentPosts()` / `getRelatedPosts()` /
`getRandomPosts()` — the pattern is: the abstract does the `WP_Query` work, the concrete
repository supplies `getPostTypeKey()` and any entity-specific query/formatting helpers (e.g.
`getNewsPowerByImpact()`, a pure data-shaping method with no query in it). Add a new entity by
extending the abstract, not by writing a fresh `WP_Query` in a Handler.

## PostTypes / Taxonomies (`src/Handlers/PostTypes/`)

One class per post type, static `getKey()`/`getRewriteSlug()`/etc. plus
`registerPostType()`/`registerXTaxonomy()` methods called from `Hooks.php` on `init` (priority 5,
before most other `init` hooks — keep new CPT registrations at the same priority unless you have a
specific ordering reason). Capabilities are commonly remapped to `edit_pages`-style capabilities
rather than left as the post-type default — copy the existing pattern (`News`) rather than
inventing new capability mappings per type.

## Style

Enforced by `phpcs.xml`/`composer lint` (PSR-12 + PSR-1 exception, see the table above) — full
command set in `build-and-ci.md`.
