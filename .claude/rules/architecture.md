# Architecture — bootstrap, DI container, config, errors

## Boot sequence (`functions.php`)

1. Compares `wp_get_theme()->get('RequiresPHP')` against `PHP_VERSION` — hard `wp_die()` if too old.
2. Requires `src/dev.php` (dev-only debug helpers), then `vendor/autoload.php`.
3. Builds the PHP-DI container: `apply_filters('starter_kit/container', require config/container.php)`
   — a plugin/child theme can swap the container entirely via this filter.
4. `App::instance()->run($container)` — the **single entrypoint**. In order: registers
   `ErrorHandler` (Whoops) with the container's `LoggerInterface`, defines `SK_*` constants
   (`Base\Constants::define()`), calls `Hooks::initHooks()`, registers WP-CLI commands.
5. Any `Throwable` during boot: in `production` env, routed through `ErrorHandler::handleThrowable`
   inside a try/catch (never crashes the site); in other envs, thrown/displayed directly.

`App` is a singleton (`AbstractSingleton`); `App::container()` is the one place to reach the DI
container from anywhere in the codebase.

## Hooks.php — the single hook-registration point

`src/Base/Hooks.php` → `initHooks()` is **the only place `add_action`/`add_filter` get called** for
theme-wide behavior (setup, settings, CPTs/taxonomies, meta, admin columns, front/back asset
enqueue, security/cleanup, mail, Contact Form 7 tweaks). It's organized into commented sections —
add new hooks under the matching section, in the same `[Handlers\X::class, 'method']` callable
style. Gutenberg blocks are the one exception: they self-register via autoloading
(`Handlers\Blocks\Init::loadBlocks()`), not added here individually — see `blocks/CLAUDE.md`.

## Config system — two layers, don't confuse them

**Theme config** (`Helper\Config::get('key/nested/path')`) — plain PHP arrays merged by
`laminas/laminas-config-aggregator` (`config/container.php` → `config/dependencies.php`):
sources are `config/common/*.php` (always) + `config/{wp_get_environment_type()}/*.php`
(env-specific — `local`/`development`/`staging`/`production`, WordPress's own environment-type
values, not the foundation's `.env` naming directly, though they're intended to line up).
As of this writing only `config/common/` exists on disk — no env-specific override folder has
been added yet, so every deployed environment currently gets the same theme config; that's a gap
to know about, not something to silently create if you're not asked to. A plugin can inject its
own config files via
the `starter_kit/config/additional_files` filter. Missing key → `ConfigEntryNotFoundException`
(fail loud, not silently `null`).

Every `config/common/*.php` file returns one `['config' => ['<group>' => [...]]]` array — the
group name matches the filename. Full inventory (there is no "misc" catch-all, each file owns one
concern):

| File | `Config::get('<group>/...')` | Holds |
| --- | --- | --- |
| `main.php` | `config` (top-level, no group prefix) | `themeSlug`, `themeNamespace`, `hooksPrefix` (`starter_kit`), `settingsPrefix` (`skt_`), `restApiNamespace` (`skt/v1`), `assetsDir`/`assetsUri`, `blocksDir`/`blocksUri`/`blocksNamespace`/`blocksViewDir` |
| `debug.php` | `enableWhoops` (top-level) | Whoops on/off — see below |
| `gutenberg.php` | `gutenberg/*` | `disableRedundantBlocks` (list of core block names, e.g. `core/image`, `core/heading`, `core/group`), `disableAllDefaultBlocks`, `disableDefaultBlocksStyles` — consumed by `Handlers\Blocks\DisableDefaultBlocks` |
| `security.php` | `security/*` | `restrictRestApiToWhitelistOnly`, `RestApiNamespaceWhitelist` (e.g. `contact-form-7`, `carbon-fields`) — consumed by `Handlers\Security\RestApiFilter` |
| `optimization.php` | `optimization/*` | `cleanWpHead`, `cleanBodyClass`, `removeAssetsAttributes`, `disableComments`, `addNoCacheHeaders` |
| `media.php` | `media/bigImageSizeThreshold` | Overrides WP's big-image scaling threshold — `Handlers\SetupTheme::bigImageSizeThreshold()` |
| `frontend.php` | `frontend/preloadFonts` | Font file paths preloaded in `<head>` — `Handlers\Front::preloadFonts()` |
| `logger.php` | `logger/file`, `logger/stderr` | Monolog sinks — also wires the `LoggerInterface::class` DI binding itself (this file returns *both* a config array and a container entry, unlike the others) |
| `replaceKeySample.php.dist` | — | Template for a per-project secret/config file — copy it (drop `.dist`) rather than committing real values into `common/` |

Two config groups are read via a *different* mechanism than `Config::get()` — don't confuse them:
CF-backed theme options use `Utils::getOptionFw()` (see `conventions.md`), not `Config::get()`,
even though both ultimately gate similar-sounding behavior (e.g. image size filtering in
`SetupTheme::filterImageSizes()` reads `Utils::getOptionFw('disable_img_sizes')`, a runtime
admin-editable value, not a `config/common/*.php` constant).

**WordPress options/meta** — a completely different thing, read via `Helper\Utils`, not `Config`.
See `conventions.md` for the `SK_PREFIX` constants and the plain-vs-`Fw` (Carbon Fields) accessor
split.

## Error handling (Whoops)

`Error\ErrorHandler::register()` wires up `filp/whoops` — pretty-page handler in the browser
(with `$wp`/`$wp_query`/`$post` inspector tables + a PhpStorm remote-call editor link), a plain
AJAX handler, a REST API handler, plain-text for WP-CLI — only when `Config::get('enableWhoops')`
is true AND `Utils::isHideErrorsMode()` is false (hidden whenever not in debug-display mode, or in
production). All errors are also `error_log()`'d unconditionally in `handleThrowable`/
`handleWPError`, regardless of Whoops being enabled — that's the persistent trail even with
verbose display off.

## WP-CLI

`Handlers\CLI\CLI::addCommands()` — only registers when `Utils::isDoingWPCLI()`. Add a new command
class implementing `CLICommandInterface` under `Handlers/CLI/Commands/`, then register it here with
`WP_CLI::add_command()`. Existing example: `wp clone-theme` (`Commands\CloneTheme`) — copies the
whole theme directory (skipping `node_modules`/`vendor`/`.git`) into a new
`get_theme_root()/<new-slug>/` folder, then interactively prompts for each `config/common/main.php`
identity value (`themeName`, `themeSlug`, `themeNamespace`, `hooksPrefix`, `settingsPrefix`,
`restApiNamespace`, ...) and does a string search/replace across every non-image file in the copy.
This is the intended way to fork this theme into a new project's theme — not manual find/replace.

## Debug helpers (`src/dev.php`)

Required unconditionally in `functions.php`, before the autoloader — a library of global debug
functions available everywhere, always (not gated by `WP_DEBUG`): `elog()`/`ilog()`/`wlog()`
(colorized/console or file logging), `wp_dump()`/`wp_dump_ext()`/`wp_dd()`/`wp_dd_ext()` (pretty
`var_export`/`var_dump` output, `wp_dd*` also calls `die()`), `debug_backtrace_string()`,
`stGetTime()`/`stGetMemory()`/`stTimeFormatted()`/`stMemoryFormatted()` (timing/memory profiling).
These are this theme's equivalent of `var_dump()`/`dd()` — the foundation's `debug.md` rule
("never leave debug calls in committed code") applies to calls to *these* functions just as much
as to raw `var_dump()`/`print_r()`. `wlog()` additionally writes to
`wp-content/uploads/SK/logs/SK.log` (creates the dir + a deny-all `.htaccess` on first use).
