# Starter Kit theme
<!--suppress HtmlDeprecatedAttribute -->

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

- [PHP](https://secure.php.net/manual/en/install.php) 8.1
- [WordPress](https://wordpress.org/) 6.1
- [Composer](https://getcomposer.org/) 2.6
- [Node.js](http://nodejs.org/) 18

## How to use

### Installation

1. Create a new theme directory in wp-content/themes:

```bash
mkdir you-theme-dir && cd you-theme-dir
```

2. Clone Starter Kit Theme:

```bash
git clone --depth=1 git@github.com:solidbunch/starter-kit-theme.git . && rm -rf .git
```

3. Setup php dependencies:

```bash
composer install
```

4. Setup node dependencies:

```bash
npm install
```

<!-- 5. Edit theme config object in `gulpfile.js`. Change theme name, theme prefix, main class, etc.


5. Run replace names command:

```bash
npm run replaceNames
```
-->
### Build commands

- Build minified assets for production:

```bash
npm run prod
```

- Build assets with source maps for development:

```bash
npm run dev
```

- Start watcher with browser sync for development:

```bash
npm run watch
```

## Structure

```
── config/                      # Base theme configuration
── src/                         # Main theme functionality files
   ├── Base/                    # Base theme functions
   │   └──Hooks.php             # Registering hooks
   │
   ├── Handlers/                # Theme hook handlers, main functionality
   │   ├──Blocks/               # Blocks functionality
   │   ├──CLI/                  # WP CLI comands
   │   ├──Errors/               # Error handlers
   │   ├──Meta/                 # Registering meta fields for post types, taxonomis, users etc. Runs by Base/Hooks
   │   ├──PostTypes/            # Registering custom post types with Taxonomies. Runs by Base/Hooks
   │   ├──Settings/             # Theme settings creation.
   │   │  └──ThemeSettings.php  # Main theme settings. Look in wp-admin Theme Settings
   │   ├──Optimization /        # Removes unnecessary things, performance optimization
   │   ├──Security /            # Provides some security options. Disable xmlrpc, etc
   │   ├──Back.php              # wp-admin functions
   │   ├──Front.php             # Basic Front handlers
   │   └──SetupTheme.php        # Setup theme handlers
   │
   ├── Helper/                  # Helpers classes
   │   ├──Assets.php            # Helper to work with assets processed by webpack
   │   ├──Config.php            # Helper functions for theme configuration
   │   ├──Logger.php            # Logging helper
   │   └──Utils.php             # Other useful functions
   │
   ├── Repository/              # Repositories, help to receive data from DB
   │                            # Classes by each post type
   │
   ├── AbstractSingleton.php    # Abstract Class for creating Singleton Classes
   ├── App.php                  # Application Singleton. Entrypoint
   └── dev.php                  # Some developers functions for debug, logging, etc

── assets/                      # Theme assets
   ├── build/                   # The compiled assets
   ├── fonts/
   ├── images/
   └── src /                    # Assets source files
       ├── js/
       └── styles/

── parts/                       # Custom template parts for the theme. Include things like headers, footers, and sidebars.
── patterns/                    # Reusable patterns.
── templates/                   # Templates, represent the overall document structure of the front-end.
                                  Templates, parts, patterns are made up of block markup.
                                  WordPress will automatically register files included in this folder.

── functions.php
── package.json
── composer.json
── screenshot.png
── style.css
── webpack.mix.js
── .editorconfig
── .gitignore

```

## Blocks

### Overview

 Gutenberg Blocks in the `blocks/` folder are loaded with the autoloader. That is, you can simply create a folder of a new block with the necessary files and this blocks will be automatically available.

Use `StarterBlock` as an example to create new blocks.

 <!-- Each shortcode has its view files, its assets directory, which contains its own, individual css, js, images, fonts, etc. (these attachments need to be connected via wp_enqueue_style and wp_enqueue_script in the shortcode.php file, they are not automatically connected). This is necessary to ensure that shortcode shortcuts are loaded only when the shortcode is active and that you can transfer the shortcodes by simply copying the shortcode folder. -->
