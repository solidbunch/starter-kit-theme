<?php


namespace StarterKit\Base;

use StarterKit\Handlers;

/**
 * Hooks functionality for the theme
 *
 * Run hook handlers
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Hooks {
	
	public static function runHooks() {
		
		/************************************
		 *            Backend
		 ************************************/
		
		// load admin assets
		add_action( 'admin_enqueue_scripts', [ Handlers\Backend::class, 'load_assets' ] );
		
		// install required plugins
		require_once get_template_directory() . '/vendor-custom/tgm/class-tgm-plugin-activation.php';
		add_action( 'tgmpa_register', [ Handlers\Backend::class, 'tgmpa_register' ] );
		
		// Change theme options default menu position
		add_action( 'fw_backend_add_custom_settings_menu', [ Handlers\Backend::class, 'add_theme_options_menu' ] );
		
		
		/************************************
		 *              Front
		 ************************************/
		
		// add site icon
		add_action( 'wp_head', [ Handlers\Front::class, 'add_site_icon' ] );
		
		// load assets
		add_action( 'wp_enqueue_scripts', [ Handlers\Front::class, 'load_critical_css' ], 5 );
		add_action( 'wp_enqueue_scripts', [ Handlers\Front::class, 'load_assets' ] );
		// remove default some styles 
		add_action( 'wp_enqueue_scripts', [ Handlers\Front::class, 'remove_assets' ], 99, 1 );
		add_action( 'wp_footer', [ Handlers\Front::class, 'remove_assets' ] );
		
		// Change excerpt dots
		add_filter( 'excerpt_more', [ Handlers\Front::class, 'change_excerpt_more' ] );
		
		// remove jquery migrate for optimization reasons
		add_filter( 'wp_default_scripts', [ Handlers\Front::class, 'dequeue_jquery_migrate' ] );
		
		// Anti-spam
		add_action( 'phpmailer_init', [ Handlers\Front::class, 'antispam_form' ] );
		
		// add GTM
		add_action( 'wp_head', [ Handlers\Front::class, 'add_gtm_head' ] );
		add_action( 'wp_footer', [ Handlers\Front::class, 'add_gtm_body' ] );
		
		// add Google Analytics code to head
		add_action( 'wp_head', [ Handlers\Front::class, 'add_analytics_head' ] );
		
		
		/************************************
		 *              HTTP2
		 ************************************/
		
		add_action( 'init', [ new Handlers\HTTP2, 'http2_init' ] );
		
		
		/************************************
		 *           Setup Theme
		 ************************************/
		
		// Add theme translation support
		add_action( 'after_setup_theme', [ Handlers\SetupTheme::class, 'load_theme_textdomain' ] );
		
		// add theme support
		add_action( 'after_setup_theme', [ Handlers\SetupTheme::class, 'add_theme_support' ] );
		
		// register sidebars
		add_action( 'widgets_init', [ Handlers\SetupTheme::class, 'register_sidebars' ] );
		
		// filter image sizes
		add_filter( 'intermediate_image_sizes', [ Handlers\SetupTheme::class, 'filter_image_sizes' ] );
		
		
		/************************************
		 *          LayoutGlobal
		 ************************************/
		
		// Header
		add_action( 'StarterKit/before_header', [ Handlers\LayoutGlobal::class, 'before_header' ] );
		add_action( 'StarterKit/header', [ Handlers\LayoutGlobal::class, 'header' ] );
		add_action( 'StarterKit/after_header', [ Handlers\LayoutGlobal::class, 'after_header' ] );
		
		// Footer
		add_action( 'StarterKit/before_footer', [ Handlers\LayoutGlobal::class, 'before_footer' ] );
		add_action( 'StarterKit/footer', [ Handlers\LayoutGlobal::class, 'footer' ] );
		add_action( 'StarterKit/after_footer', [ Handlers\LayoutGlobal::class, 'after_footer' ] );
		
		// Grid
		add_action( 'StarterKit/layout_start', [ Handlers\LayoutGlobal::class, 'layout_start' ] );
		add_action( 'StarterKit/layout_end', [ Handlers\LayoutGlobal::class, 'layout_end' ] );
		
		// Sidebar
		add_action( 'StarterKit/sidebar', [ Handlers\LayoutGlobal::class, 'sidebar' ] );
		
		// Page 404
		add_action( 'StarterKit/before_page_404_content', [ Handlers\LayoutGlobal::class, 'before_page_404_content' ] );
		add_action( 'StarterKit/page_404_content', [ Handlers\LayoutGlobal::class, 'page_404_content' ] );
		add_action( 'StarterKit/after_page_404_content', [ Handlers\LayoutGlobal::class, 'after_page_404_content' ] );
		
		// Loops
		add_action( 'StarterKit/before_loop', [ Handlers\LayoutGlobal::class, 'before_loop' ] );
		add_action( 'StarterKit/after_loop', [ Handlers\LayoutGlobal::class, 'after_loop' ] );
		
		
		/************************************
		 *          LayoutSingle
		 ************************************/
		
		// Post layout
		add_action( 'StarterKit/before_single_post', [ Handlers\LayoutSingle::class, 'before_single_post' ] );
		add_action( 'StarterKit/after_single_post', [ Handlers\LayoutSingle::class, 'after_single_post' ] );
		
		// Post thumbnail
		add_action( 'StarterKit/before_single_post_thumbnail',
			[ Handlers\LayoutSingle::class, 'before_single_post_thumbnail' ] );
		add_action( 'StarterKit/single_post_thumbnail', [ Handlers\LayoutSingle::class, 'single_post_thumbnail' ] );
		add_action( 'StarterKit/after_single_post_thumbnail',
			[ Handlers\LayoutSingle::class, 'after_single_post_thumbnail' ] );
		
		// Post title
		add_action( 'StarterKit/before_single_post_title',
			[ Handlers\LayoutSingle::class, 'before_single_post_title' ] );
		add_action( 'StarterKit/single_post_title', [ Handlers\LayoutSingle::class, 'single_post_title' ] );
		add_action( 'StarterKit/after_single_post_title', [ Handlers\LayoutSingle::class, 'after_single_post_title' ] );
		
		// Post content
		add_action( 'StarterKit/before_single_post_content', [ Handlers\LayoutSingle::class, 'before_single_post_content' ] );
		add_action( 'StarterKit/single_post_content', [ Handlers\LayoutSingle::class, 'single_post_content' ] );
		add_action( 'StarterKit/after_single_post_content', [ Handlers\LayoutSingle::class, 'after_single_post_content' ] );
		
		// Post comments
		add_action( 'StarterKit/before_single_post_comments', [ Handlers\LayoutSingle::class, 'before_single_post_comments' ] );
		add_action( 'StarterKit/single_post_comments', [ Handlers\LayoutSingle::class, 'single_post_comments' ] );
		add_action( 'StarterKit/after_single_post_comments',
			[ Handlers\LayoutSingle::class, 'after_single_post_comments' ] );
		
		
		/************************************
		 *             LazyLoad
		 ************************************/
		
		add_action( 'init', [ new Handlers\LazyLoad, 'run_lazy_load' ] );
		
		
		/************************************
		 *              Menu
		 ************************************/
		
		// register menus
		add_action( 'after_setup_theme', [ Handlers\Menu::class, 'register_menus' ] );
		
		//startbootstrapmenu
		// add wp-bootstrap-navwalker
		require_once get_template_directory() . '/vendor-custom/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';
		add_filter( 'nav_menu_link_attributes', [ Handlers\Menu::class, 'nav_menu_link_attributes' ], 10, 4 );
		add_filter( 'walker_nav_menu_start_el', [ Handlers\Menu::class, 'walker_nav_menu_start_el' ], 10, 4 );
		//endbootstrapmenu
		
		// here we can add custom menu fields, modify admin walkers etc
		
		
		/************************************
		 *              OAuth
		 ************************************/
		
		add_action( 'template_redirect', [ new Handlers\OAuth, 'check_request' ] );
		
		
		/************************************
		 *            Optimization
		 ************************************/
		
		add_action( 'init', [ new Handlers\Optimization, 'init' ] );
		
		
		/************************************
		 *             Security
		 ************************************/
		
		add_action( 'init', [ new Handlers\Security, 'init' ] );
		
		
		/************************************
		 *          VisualComposer
		 ************************************/
		
		// replace default VC grid classes
		add_filter( 'vc_shortcodes_css_class', [ Handlers\VisualComposer::class, 'custom_css_classes_for_vc_grid' ], 10, 2 );
		
		// Remove default VC elements
		add_action( 'vc_after_init', [ Handlers\VisualComposer::class, 'setup_vc' ] );
		
		
		/************************************
		 *       VisualComposerExtends
		 ************************************/
		
		// load admin assets
		add_action( 'admin_enqueue_scripts', [ Handlers\VisualComposerExtends::class, 'load_assets' ] );
		
		// Add Custom Controls to Visual Composer
		add_action( 'vc_load_default_params', [ Handlers\VisualComposerExtends::class, 'register_custom_plugin_params' ] );
		
		
		/************************************
		 *     PostTypes with Taxonomies
		 ************************************/
		
		add_action( 'init', [ Handlers\PostTypes\ComposerLayout::class, 'register_post_type' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\News::class, 'register_post_type' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\News::class, 'register_taxonomy' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\Portfolio::class, 'register_post_type' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\Portfolio::class, 'register_taxonomy' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\TeamMembers::class, 'register_post_type' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\TeamMembers::class, 'register_taxonomy' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\Testimonials::class, 'register_post_type' ], 5 );
		add_action( 'init', [ Handlers\PostTypes\Testimonials::class, 'register_taxonomy' ], 5 );
		
		
		/************************************
		 *          Theme Settings
		 ************************************/
		
		add_action( 'carbon_fields_register_fields', [ Handlers\Settings\ThemeSettings::class, 'make' ] );
		
		
		/************************************
		 *            Meta Fields
		 ************************************/
		
		add_action( 'carbon_fields_register_fields', [ Handlers\PostMeta\ThemeLayoutsSidebars::class, 'make' ] );
		add_action( 'carbon_fields_register_fields', [ Handlers\PostMeta\Composerlayout::class, 'make' ] );
		add_action( 'carbon_fields_register_fields', [ Handlers\PostMeta\Page::class, 'make' ] );
		add_action( 'carbon_fields_register_fields', [ Handlers\PostMeta\Portfolio::class, 'make' ] );
	}
}