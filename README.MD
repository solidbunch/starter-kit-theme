# Starter Kit Theme

**Requirements**
 
 1. PHP5.6+
 2. NodeJs

# Setup
 
 1. clone repo
 
 2. run `npm i` or  `yarn`  command (setup node depencies)
 
 3. to replace names use command
    - > `npm run replaceNames` - doing replacement by config object (edit first in gulpfile.js)
 
 3. to run webpack use next commands
     - > `npm run prod`  or  `yarn prod` - build minified assets
     - > `npm run dev` or `yarn dev`- build assets with source maps (for development) 
     - > `npm run watch`  or `yarn watch`- start watcher 
     - > `npm run browser-sync` or `yarn browser-sync` - to start watcher with broser sync
    - To use browser sync make sure that you copied **`build/broswer-sync.config.js.sample`** to  `build/broswer-sync.config.js` - and configured your local domain

# Sturcture
 - app/ – main theme files 
    - Controller/
        - Backend.php – wp-admin functions
        - Front.php – front-end functions
        - HTTP2.php – HTTP2 support
        - Init.php – theme initialization
        - LazyLoad.php – lazy load for images
        - Menu.php – menu registration hooks and methods
        - OAuth.php – Oauth support
        - Optimization.php – removes unnecessary tags
        - PostTypes.php – registering custom post types
        - Shortcodes.php – registering shortcodes
        - VisualComposer.php – settings for Page Builder
        - WalkerBootstrap.php – add bootstrap menu walker
    - Helper/ – Helpers classes
        - Front.php - front-end page helpers
        - Media.php - media helpers
        - Utils.php - other useful functions
    - Model/ – models to work with database
        - Database.php - DB model
        - Layout.php - page layout model
        - News.php - posts model
        - Post.php - news post type model
        - Shortcode.php - shortcode model
    - Shortcodes/ – shortcodes library (works with/without WPBakery Page Builder)
        - Alert - alert block (icon, styling)
        - Button - button element (icon, link, layout, styling)
        - Contact Form - form and form elements (checkbox, email, file uploader, text, datepicker and other)
        - Google Map
        - Heading - heading h1,h2,h3,h4,h5,h6 (font styling, layout)
        - Menu - custom menu with desktop and mobile devices support
        - News - news block
        - Posts - posts block (pagination, styling)
        - Pricing Table - pricing table (price settings, styling)
        - Social Login - login using social networks Facebook, Twitter, Google 
        - Tabs - tabs shortcode 
        - Toggles - accordion shortcode
    - View/ – templates (included in controller)
    - Widgets/ – widgets (included in controller)
 - assets/ – theme assets
   - css/
   - fonts/
   - images/
   - js/
   - libs/
 - build - webpack configs 
 - framework-customizations/ – Unyson customization (see https://github.com/ThemeFuse/Scratch-Theme)
 - template-parts/ – default WordPress templates (included in files below)
 - vendor/ – third-party development
 - 404.php
 - comments.php
 - footer.php
 - functions.php
 - gulpfile.js
 - header.php
 - index.php
 - package.json
 - page.php
 - page-tpl-no-sidebar.php
 - postcss.config.css
 - screenshot.png
 - sidebar.php
 - single.php
 - style.css
 - webpack.config.js
 
# Naming conventions

**shortcodes | widgets**
 
 1. all styles and scripts files should be in `{Shortcodes|Widgets}/assets` - folder
 
 2. styles should be named  - `style.scss`
 
 3. JS files should be named - `scripts.js`
 
 4. enqueue in shortcode  - `style.css` and `scritps.min.js`
 
# Shortcodes
 
 Shortcodes in the shortcodes folder are loaded with the autoloader. That is, you can simply create a folder of a new shortcode with the necessary files and this shortcode will be automatically available. 
 
 Each shortcode has its view files, its assets directory, which contains its own, individual css, js, images, fonts, etc. (these attachments need to be connected via wp_enqueue_style and wp_enqueue_script in the shortcode.php file, they are not automatically connected). This is necessary to ensure that shortcode shortcuts are loaded only when the shortcode is active and that you can transfer the shortcodes by simply copying the shortcode folder. 
 
 In the future, you can connect the plugin combining styles and scripts to optimize the number of requests (or connect scripts via defer).
 The folder structure can be any, you can add your files, but here are two files ajax.php and shortcode.php - loaded autoloader

 
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
