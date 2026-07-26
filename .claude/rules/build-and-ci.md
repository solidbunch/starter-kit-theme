# Build, lint, test, CI

## Node / build (`package.json`, `webpack.mix.js` — Laravel Mix 6 on webpack)

Pinned engines: `node >=18 <19`, `npm >=9 <11` — don't assume a newer Node works, Mix 6 + the
babel/webpack chain here is pinned to this range.

```bash
npm run dev      # mix — dev build, no minification
npm run watch    # mix watch — rebuild on change (pair with foundation's `make watch` for BrowserSync)
npm run prod     # mix --production — minified build
npm run lint     # stylelint + eslint
npm run lint:js / lint:js:fix
npm run lint:style / lint:style:fix
```

`webpack.mix.js` does two distinct things:

1. **Icon fonts** (`applyFontRule('block-icons')`, `applyFontRule('icons')`) — compiles
   `webfonts-loader/*.font.js` into `assets/build/fonts/*` via `webfonts-loader` +
   `mini-css-extract-plugin`. Add a new icon font by adding its own `webfonts-loader/<name>.font.js`
   and an `applyFontRule('<name>')` call, not by hand-editing generated font CSS.
2. **Block bundling** — `glob.sync('{blocks/!(_)**/src/!(_)*.scss,blocks/!(_)**/src/*.{js,jsx}}')`
   auto-discovers every non-underscore-prefixed block's `src/*.scss`/`src/*.{js,jsx}` and compiles
   each into that block's own `build/`. This is why a new block just needs a `src/` folder in the
   right shape (see `blocks/CLAUDE.md`) — nothing to register in `webpack.mix.js` itself. The
   `_StarterBlock` template block and any `_`-prefixed folder are excluded from both the compiler
   glob and the PHP autoloader (`Init::loadBlocks()`) — same underscore convention on both sides.

Lint tool versions are old (ESLint 8, Stylelint 13) — don't introduce ESLint 9 flat-config or
Stylelint 16+ syntax, the installed CLI won't understand it.

Besides blocks and icon fonts, Mix also compiles the theme-wide bundle from `assets/src/`:
`styles/theme.scss` (frontend, split into `layout/` partials — `_header`, `_footer`, `_type`,
`_fonts`, `_contact-forms-7`, `_single-doc-page` — plus `utils/` mixins/functions/placeholders and
a `custom_bootstrap/` override layer for Bootstrap's Sass maps/variables) and separately
`styles/editor.scss` / `styles/admin.scss`; `js/app.js` (frontend) and `js/editor.js` (block
editor), each pulling in `js/FrontComponents/` or `js/EditorComponents/` respectively —
`EditorComponents/Handlers/{BlockHandlers,BlockEvents,BootstrapSpacers}.js` is the JS side of the
spacer/attribute system whose PHP counterpart is `BlockAbstract::generateSpacersClasses()` (see
`blocks/CLAUDE.md`). `js/bootstrap/*.js` are hand-picked individual Bootstrap 5 JS modules
(`alert`, `collapse`, `dropdown`, `offcanvas` — not the full bundle), registered piecemeal by
`Handlers\Front::enqueueBootstrap()`.

## PHP lint (`composer.json` scripts, `phpcs.xml`)

```bash
composer lint      # phpcs --standard=phpcs.xml   (PSR-12 + PHPCompatibilityWP)
composer lintfix    # phpcbf --standard=phpcs.xml  (auto-fixable subset only)
```

`phpcs.xml` excludes `vendor/`, `vendor-custom/`, `node_modules/`, `.git/`, `.github/`. Its
`testVersion="8.4-"` (open-ended range) matches `composer.json`'s `>=8.4` floor.

## Tests (`phpunit.xml`, `tests/`)

```bash
composer tests   # vendor/bin/phpunit -c phpunit.xml --colors=always --testdox
```

`StarterKitTests\` (PSR-4, `tests/`). Current coverage is narrow: `tests/Unit/Container/` tests the
PHP-DI container wiring itself (`ContainerTest.php` + `Fixtures/{Inner,Middle,Outer,...}.php`) —
there is no test coverage yet for Handlers, Repositories, or Blocks. `tests/bootstrap.php` is the
PHPUnit bootstrap — check it before assuming WP function stubs/mocks are available in a new test.

## CI (`.github/workflows/workflow-code-qa.yml`)

Runs on every push except `master`/`develop` (i.e. feature branches), plus manual
`workflow_dispatch`. Three sequential jobs, each depending on the previous via cache handoff
(`actions/cache` keyed by `github.run_number`, not restored across separate runs):
`php-code-sniffer` (`composer update` + `composer lint`) → `stylelint` (`npm run install-dev` +
`npm run lint:style`) → `eslint` (`npm run lint:js`). Runs `PHP_VERSION: '8.4'` / `NODE_VERSION: '18'`
— matches `composer.json`'s `>=8.4` floor, same as `phpcs.xml` and `README.MD` (see `conventions.md`
/ the theme's root `CLAUDE.md` — no PHP-version drift left anywhere in this repo as of this pass).
This workflow only lints; it does not run `composer tests` / PHPUnit and does not build/deploy — deployment is
entirely the foundation's CI (`ci.md` in the foundation root rules), which pulls this theme in via
Composer VCS (stable tag normally, `dev-develop` in the `dev` environment via
`composer run switch-theme-dev`).
