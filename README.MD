# Fruitful Blank Theme
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
#Naming conventions

*shortcodes/widgets*
 1. all styles and scripts files should be in `{shortcode/widget}/assets` - folder
 2. styles should be named  - `style.scss`
 3. JS files should be named - `scripts.js`ß
 4. enque in shortcode  - `style.css` and `scritps.min.js`