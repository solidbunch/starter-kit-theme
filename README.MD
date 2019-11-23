# Starter Kit Theme

[![TotalDownloads](https://img.shields.io/github/downloads/SolidBunch/starter-kit/total.svg?style=plastic)](https://github.com/SolidBunch/starter-kit/releases)
[![Release](https://img.shields.io/github/release/SolidBunch/starter-kit.svg?style=plastic)](https://github.com/SolidBunch/starter-kit/releases)
[![GitHub Issues](https://img.shields.io/github/issues/SolidBunch/starter-kit.svg?style=plastic)](https://github.com/SolidBunch/starter-kit/issues)
[![License](https://img.shields.io/github/license/SolidBunch/starter-kit.svg?style=plastic)](https://github.com/SolidBunch/starter-kit/blob/master/LICENSE)
[![Last Commit](https://img.shields.io/github/last-commit/SolidBunch/starter-kit.svg?style=plastic)](https://github.com/SolidBunch/starter-kit/)

**Requirements**
 
 1. PHP7.2+
 2. NodeJs (v10 +) (optional)
	
**StarterKit Generator**

You can include / exclude functional using online generator tool https://solidbunch.github.io/starter-kit-generator/

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
    - Base/
        - Hooks.php - base hooks functionality for the theme
        - Settings.php - theme settings framework initialization
        - ShortcodesManager.php – registering shortcodes
    - Handlers/
        - Settings/ThemeSettings.php – theme settings creation
        - PostTypes/* – registering custom post types
        - PostMeta/*  – registering meta fields
        - Backend.php – wp-admin functions
        - Front.php – front-end functions
        - HTTP2.php – HTTP2 support
        - SetupTheme.php – Theme setup
        - LazyLoad.php – lazy load for images
        - Menu.php – menu registration hooks and methods
        - OAuth.php – Oauth support
        - Optimization.php – removes unnecessary tags
        - VisualComposer.php – settings for Page Builder
    - Helper/ – Helpers classes
        - Front.php - front-end page helpers
        - Media.php - media helpers
        - Utils.php - other useful functions
        - Assets.php - Helper to work with assets processed by webpack
        - View.php - works with templates
    - Repository/* - Repositories, help to receive data from DB
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
    - templates/ – html or other templates
    - Widgets/ – Theme widgets
 - assets/ – theme assets
   - css/
   - fonts/
   - images/
   - js/
   - libs/
 - build - webpack configs 
 - template-parts/ – default WordPress templates (included in files below)
 - vendor-custom/ – third-party development
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

# Helpers usage

## Media

Media helper contains functions for working with images. 

### img_resize()

The `img_resize()` function returns a link to the modified image according to the passed parameters. You can see examples in index.php.

**Usage:**

     <img src="<?php echo Media::img_resize( $url, $width, $height, $crop ); ?>" >


- `$url` - URL to image file to resize
- `$width` - width value, integer 
- `$height` - height value, integer
- `$crop` - bool flag crop or not
    
**Returns:**
`string` resized image path

**Example:**

    use StarterKit\Helper\Media;
    
    <img src="<?php echo Media::img_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 380, 250, false ); ?>" >

### the_img()

Function `the_img()` is universal and can print a full &lt;img&gt; tag with various attributes. All parameters are optional. The function is friendly with built-in theme Lazy Load controller. Lazy Load needs to know image sizes (width & height or data-width & data-height or [width]x[height] in the image file name)

**Usage:**

    Media::the_img( $image_atts = array(), $func_atts = array() );
    
- `$image_atts` - array of &lt;img&gt; tag attributes
    - `src` - URL to image file, string, the system tries to fill automatically from global $post featured image
    - `width` - width value, integer, not used if empty
    - `height` - height value, integer, not used if empty
    - `title` - title attribute, string, not used if empty
    - `alt` - alt attribute, string, the system tries to fill automatically
    - `id`- id attribute, string, not used if empty
    - `class` - class attribute, string, not used if empty
    - ... - You can add any custom attribute to use in &lt;img&gt; tag 
- `$func_atts` - array of functional attributes - needs to prepare image
    - `attachment_id` - WP media id, integer, the system tries to fill automatically from global $post featured image
    - `hdmi` - default true, srcset flag, boolean
    - `size` - default 'full', WP image sizes, string, 'thumbnail', 'medium', 'large', 'full' or custom
    - `crop` - default false, bool flag crop or not
    - `upscale` - default false, resizes smaller images, boolean
    - `resize` - default true, do resize or not, boolean 

**Returns:**
echo  `string` image tag or return `false` if error

**Example:**

You can call it in posts loop without parameters and function will print featured image from Post in 'full' size (function use global $post when image src and attachment_id is empty)
    
    use StarterKit\Helper\Media;
        
    Media::the_img();
    
or 

    \StarterKit\Helper\Media::the_img();
   
With different parameters:

Print image with sizes atts and with srcset
        
    Media::the_img(array('width' => 380, 'height' => 250) );
    
Print image without strong sizes, but with lazy load and with srcset
    
    Media::the_img(array('data-width' => 380, 'data-height' => 250) );
    
An example how to print image tag without srcset

    Media::the_img(array('data-width' => 380, 'data-height' => 250), array('hdmi' => false) );
    
With different and custom attributes

    Media::the_img(array('width' => 380, 'height' => 250, 'class' => 'image-class', 'data-my-attr' => $my-attr-value), array('attachment_id' => $attachment_id) );
    
With no attributes, only standart WP size in post

    Media::the_img(array(), array('size' => 'medium') );
    

### Media::pictureForPost, Media::imgForPost

Helpers `Media::pictureForPost` and `Media::imgForPost` return a Responsive &lt;picture&gt; or &lt;img&gt; tag by post id. The helpers is friendly with built-in theme Lazy Load functionality.

**Usage:**

    Media::pictureForPost( $postId, array $mediaQueriesWithWidth = [], $hasDoubleDevicePixelRatio = true )
    
    Media::imgForPost( $postId, array $mediaQueriesWithWidth = [], $hasDoubleDevicePixelRatio = true )
    
**Returns:**

    string <picture> or <img> tag accordingly or empty string on error

**Example:**

```php
echo Media::pictureForPost(
		get_the_ID(),
		[   // format: ['metaQuery' => widthInPx(int), ... , defaultWidthInPx(int) ]
			'(min-width: 1200px)' => 730,
			'(min-width: 768px)'  => 690,
			545, // dafault width, if no media query aplied
		],
		false
	);

echo  Media::imgForPost(
		get_the_ID(),
		[
			'(min-width: 1200px)' => 730,
			'(min-width: 768px)'  => 690,
			545
		] );
```

**Also you can do any combination of parameters of Picture or Img responsive tags with StarterKit\Helper\ResponsiveImages\ classes :**

```php
if ( has_post_thumbnail( $postId ) ) {
    try {
        $originUrl = get_the_post_thumbnail_url( $postId, 'full' );
        $resizer   = Resizer::makeByUrl( $originUrl );
        $img =
            Picture::make(
                $originUrl, // original url for default img tag
                'customAlt', // alt for default img tag
                null, // width for img tag lazy load placeholder, by default as at $originUrl image 
                null, // height for img tag lazy load placeholder, by default as at $originUrl image 
                [     // sourses
                    Source::make( [ // SrcsetItems
                        SrcsetItem::makeWithResize( $resizer->setWidth( 730 ), '1x' ),
                        SrcsetItem::makeWithResize( $resizer->setWidth( 730 * 2 ), '2x' ),
                    ],
                        [], // may add sizes
                        '(min-width: 1200px)', // may add media
                        'image/jpeg'  // may add image mime-type
                    ),
                    
                    Source::make( [
                        SrcsetItem::makeWithResize( $resizer->setWidth( 690 ), '1x' ),
                        SrcsetItem::makeWithResize( $resizer->setWidth( 690 * 2 ), '2x' ),
                    ],
                        [],
                        '(min-width: 768px)'
                    ),
                    
                    Source::make( [
                        SrcsetItem::makeWithResize( $resizer->setWidth( 545 ), '1x' ),
                        SrcsetItem::makeWithResize( $resizer->setWidth( 545 * 2 ), '2x' ),
                    ] ),
                ] )
                   ->addPictureAttr( 'class', 'custom-picture-class' )
                   ->addPictureAttr( 'data-some', 'custom-picture-attr' )
                   ->addImgAttr( 'class', 'custom-img-class' )
                   ->addImgAttr( 'data-some', 'custom-img-attr' )
                   ->render();
    } catch ( \Exception $ex ) {
        error_log( "\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n" );
        $img = '';
    }
    echo $img;
} 
```