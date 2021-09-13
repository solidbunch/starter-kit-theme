<!--suppress HtmlDeprecatedAttribute -->
<p align="center">

  <img alt="Starter Kit Theme" src="https://starter-kit.io/images/logo.png" height="100">

</p>

<p align="center">

  <a href="LICENSE.md">
    <img alt="GitHub" src="https://img.shields.io/github/license/solidbunch/starter-kit-theme">
  </a>

  <a href="https://github.com/solidbunch/starter-kit-theme/releases">
    <img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/solidbunch/starter-kit-theme?color=blueviolet">
  </a>

</p>

<p align="center">
<strong>WordPress starter theme with a modern development stack for launching projects faster and easily.</strong>

</p>

## Requirements

- [PHP](https://secure.php.net/manual/en/install.php) 7.2+
- [WordPress](https://wordpress.org/) 5.4+
- [Node.js](http://nodejs.org/) 10+ (optional) or [Yarn](https://yarnpkg.com/en/docs/install) (optional)
 
## How to use

### Installation

1. Create a new theme directory in wp-content/themes:

```bash
mkdir you-theme-dir && cd you-theme-dir
```

2. Install Starter Kit Theme:

```bash
git clone --depth=1 git@github.com:solidbunch/starter-kit-theme.git . && rm -rf .git
```

3. Setup node dependencies:

```bash
npm i
```

4. Edit theme config object in `gulpfile.js`. Change theme name, theme prefix, main class, etc.


5. Run replace names command:

```bash
npm run replaceNames
```

### Build commands

- Build minified assets for production:

```bash
npm run prod
```

- Build assets with source maps for development:

```bash
npm run dev
```

- Start watcher for development:

```bash
npm run watch
```

- Start watcher with browser sync for development 

Copy `build/broswer-sync.config.js.sample` to `build/broswer-sync.config.js`, edit it, and configure your local domain. After that run:

```bash
npm run browser-sync
```

<details>
  <summary>Yarn commands</summary>

- `yarn` - setup node dependencies;
- `yarn prod` - build minified assets;
- `yarn dev`- build assets with source maps (for development);
- `yarn watch`- start watcher;
- `yarn browser-sync` - start watcher with browser sync;

</details>

## Structure

```
── app/                                # Main theme functionality files
   ├── Base/                           # Base theme functions
   │   ├──Hooks.php                    # Registering hooks
   │   ├──Settings.php                 # Theme settings framework initialization
   │   ├──Shortcode.php                # Shortcode object configuration
   │   └──ShortcodesManager.php        # Register and load shortcodes
   │
   ├── config/                         # Base theme configuration
   │   ├──_animations.php              # CSS animations declaration
   │   ├──_social_icons.php            # Social CSS classes settings. Font Awesome default
   │   ├──_social_profiles.php         # Register social profiles meta for website options 
   │   └──config.php                   # Bootstrap config file
   │
   ├── Handlers/                       # Theme hook handlers, main functionality
   │   ├──PostMeta/                    # Registering meta fields for post types. Each file separately. Runs by Base/Hooks
   │   ├──PostTypes/                   # Registering custom post types with Taxonomies. Runs by Base/Hooks
   │   ├──Settings/                    #
   │   │  └──ThemeSettings.php/        # Theme settings creation. Look in wp-admin Appearance/Theme Settings
   │   ├──Backend.php                  # wp-admin functions
   │   ├──Front.php                    # Basic Front handlers
   │   ├──HTTP2.php                    # HTTP2 support
   │   ├──LayoutGlobal.php             # Builds global theme layout using actions
   │   ├──LayoutSingle.php             # Builds single post / page etc. layout using actions
   │   ├──LazyLoad.php                 # Lazy load for images
   │   ├──Menu.php                     # Menu registration hooks and methods
   │   ├──OAuth.php                    # Oauth support
   │   ├──Optimization.php             # Removes unnecessary tags, performance optimization
   │   ├──Security.php                 # Provides some security options. Disable xmlrpc, etc
   │   ├──SetupTheme.php               # Setup theme handlers
   │   ├──VisualComposer.php           # Rewrite default WPBakery Page Builder functions
   │   └──VisualComposerExtends.php    # Extend default functional of WPBakery Page Builder
   │
   ├── Helper/                         # Helpers classes
   │   ├──ResponsiveImages/            # Modern responsive images with <picture> or <img>
   │   ├──Assets.php                   # Helper to work with assets processed by webpack
   │   ├──Front.php                    # Helper functions for templates and Front handler
   │   ├──Media.php                    # Functions to help to output and resize media
   │   ├──Utils.php                    # Other useful functions
   │   └──View.php                     # Connect and output templates
   │
   ├── Repository/                     # Repositories, help to receive data from DB
   │   └──*.php                        # Classes by each post type
   │
   ├── Shortcodes/                     # Shortcodes library (works with/without WPBakery Page Builder)
   │   ├── alert/                      # Alert block (icon, styling)
   │   ├── button/                     # Button element (icon, link, layout, styling)
   │   ├── contact_form/               # Form and form elements (checkbox, email, file uploader, text, datepicker and other)
   │   ├── google_map/                 # Improved Google Map
   │   ├── heading/                    # Heading h1,h2,h3,h4,h5,h6 (font styling, layout)
   │   ├── menu/                       # Custom menu with desktop and mobile devices support
   │   ├── news/                       # News block
   │   ├── posts/                      # Posts block (pagination, styling)
   │   ├── pricing_table/              # Pricing table (price settings, styling)
   │   ├── social_login/               # Login using social networks Facebook, Twitter, Google 
   │   ├── tabs/                       # Tabs shortcode 
   │   └── toggles/                    # Accordion shortcode
   │
   ├── templates/                      # HTML or other templates
   ├── Widgets/                        # Theme widgets
   ├── AbstractSingleton.php           # Abstract Class for creating Singleton Classes
   ├── App.php                         # Application Singleton. Entrypoint
   └── dev.php                         # Some developers functions for debug, logging, etc
   
── assets/                             # Theme assets
   ├── css/
   ├── fonts/
   ├── images/
   ├── js/
   └── libs/
   
── build/                              # Webpack configs
── dist/                               # The compiled assets
── template-parts/                     # Front templates

── vendor-custom/                      # Third-party development
   ├── aq_resizer/                     # Resizes WordPress images on the fly
   ├── carbon-fields/                  # Developer-oriented library for WordPress custom fields for all types of WordPress content
   ├── oauth/                          # Facebook, Google, Twitter libs for OAuth
   ├── tgm/                            # Required plugin installation
   └── wp-bootstrap-navwalker/         # Make awesome bootstrap menu
   
── 404.php
── comments.php
── footer.php
── functions.php
── gulpfile.js
── header.php
── index.php
── package.json
── page.php
── page-tpl-no-sidebar.php
── postcss.config.js
── screenshot.png
── sidebar.php
── single.php
── style.css
── webpack.config.js

```
 
## Naming conventions

**shortcodes | widgets**
 
 1. all styles and scripts files should be in `{Shortcodes|Widgets}/assets` - folder
 
 2. styles should be named  - `style.scss`
 
 3. JS files should be named - `scripts.js`
 
 4. enqueue in the shortcode  - `style.css` and `scritps.min.js`
 
## Shortcodes
 
 Shortcodes in the shortcodes folder are loaded with the autoloader. That is, you can simply create a folder of a new shortcode with the necessary files and this shortcode will be automatically available. 
 
 Each shortcode has its view files, its assets directory, which contains its own, individual css, js, images, fonts, etc. (these attachments need to be connected via wp_enqueue_style and wp_enqueue_script in the shortcode.php file, they are not automatically connected). This is necessary to ensure that shortcode shortcuts are loaded only when the shortcode is active and that you can transfer the shortcodes by simply copying the shortcode folder. 
 
 In the future, you can connect the plugin combining styles and scripts to optimize the number of requests (or connect scripts via defer).The folder structure can be any, you can add your files, but here are two files ajax.php and shortcode.php - loaded autoloader

**File structure**
 
 - assets/ – all assets (styles, scripts, fonts, etc)
    - assets/style.scss - styles
    - assets/scripts.js - scripts
    - assets/images/ - images
 - childs/ – nested shortcodes, have the same structure as another shortcodes     
 - view/ – shortcode templates    
 - ajax.php – backend for ajax queries (optional)
 - config.php – shortcode config
 - shortcode.php – shortcode controller
 - vc.php - WPBakery Page Builder support