# Fruitful Blank Theme
**Requirements**
 
 1. PHP5.6+
 
 2. NodeJs

**Optional utilities** 
 1. WP_CLI (https://wp-cli.org/)

**Setup**
 
 1. clone repo
 
 2. run `npm i` or  `yarn`  command (setup node depencies)
 
 3. to run webpack use next commands
     - > `npm run prod`  or  `yarn prod` - build minified assets
     - > `npm run dev` or `yarn dev`- build assets with source maps (for development) 
     - > `npm run watch`  or `yarn watch`- start watcher 
     - > `npm run browser-sync` or `yarn browser-sync` - to start watcher with broser sync
    - To use browser sync make sure that you copied **`build/broswer-sync.config.js.sample`** to  `build/broswer-sync.config.js` - and configured your local domain

 4. WP_CLI
	- create shortcode :  
	  - `php wp-cli.phar create:shortcode --name=shortcode_name --path='path/to/wordpress'`
	  - create a shortcode dirrectory with `init.php`, `shortcode.php`, `view/view.php` files and starter code


#Sturcture 
 - assets/ – all assets (css,scss,images,fonts,js files)
   - css/
   - images/
   - js/
   - libs/
   - fonts/
 - core/ – main theme files
   - controller/
     - backend.php – all for wp-admin
     - front.php – all for front-end
     - init.php – theme initialization
     - lazy_load.php – lazy load for images
     - menu.php – menu registration hooks and methods
     - post_types.php – registering custom post types
     - visual_composer.php – settings for Page Builder
   - helper/ – Helplers classes
   - model/ – models to work with database
   - shortcodes/ – all shortcodes (regular and for Page Builder)
   - view/ – templates (included in controller)
   - widgets/ – widgets (included in controller)
  - framework-customizations/ – Unyson customization (see https://github.com/ThemeFuse/Scratch-Theme)
  - template-parts/ – default WordPress templates (included in files below)
 - 404.php
 - comments.php
 - footer.php
 - functions.php
 - header.php
 - index.php
 - page.php
 - page-tpl-no-sidebar.php
 - screenshot.png
 - sidebar.php
 - single.php
 - single-video.php
 - style.css
 
#Naming conventions

**shortcodes/widgets**
 
 1. all styles and scripts files should be in `{shortcode/widget}/assets` - folder
 
 2. styles should be named  - `style.scss`
 
 3. JS files should be named - `scripts.js`ß
 
 4. enque in shortcode  - `style.css` and `scritps.min.js`
 
#Shortcodes
 
 Shortcodes in the shortcodes folder are loaded with the autoloader. That is, you can simply create a folder of a new shortcode with the necessary files and this shortcode will be automatically available. Each shortcode has its view files, its assets directory, which contains its own, individual css, js, images, fonts, etc. (these attachments need to be connected via wp_enqueue_style and wp_enqueue_script in the shortcode.php file, they are not automatically connected). This is necessary to ensure that shortcode shortcuts are loaded only when the shortcode is active and that you can transfer the shortcodes by simply copying the shortcode folder. In the future, you can connect the plugin combining styles and scripts to optimize the number of requests (or connect scripts via defer).
 The folder structure can be any, you can add your files, but here are two files ajax.php and shortcode.php - loaded autoloader
 
 File structure
 
 view/ – templates
 assets/ – all assets (images, styles,scripts,fonts,etc)
 ajax.php – backend for ajax queries( not required)
 init.php – vc_map
 shortcode.php – main shortcode controller which must be child class of `WPBakeryShortCode`
 
