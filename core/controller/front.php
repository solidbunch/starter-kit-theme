<?php

namespace ffblank\controller;

/**
 * Front side controller
 **/
class front {
	
	/**
	 * Constructor
	 **/
	function __construct() {
		
		// add site icon
		add_action( 'wp_head', array( $this, 'add_site_icon' ) );
		
		// load assets
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		// remove default styles for Unyson Breadcrummbs
		add_action( 'wp_enqueue_scripts', array( $this, 'remove_assets' ), 99, 1 );
		add_action( 'wp_footer', array( $this, 'remove_assets' ) );
		
		// Change excerpt dots
		add_filter( 'excerpt_more', array( $this, 'change_excerpt_more' ) );
		
		// remove jquery migrate for optimization reasons
		add_filter( 'wp_default_scripts', array( $this, 'dequeue_jquery_migrate' ) );
		
	}
	
	/**
	 * Add site icon from customizer
	 **/
	function add_site_icon() {
		
		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			wp_site_icon();
		}
		
	}
	
	/**
	 * Load JavaScript and CSS files in a front-end
	 **/
	function load_assets() {
		
		// add support for visual composer animations, row stretching, parallax etc
		if ( function_exists( 'vc_asset_url' ) ) {
			wp_enqueue_script( 'waypoints', vc_asset_url( 'lib/waypoints/waypoints.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true );
			wp_enqueue_script( 'wpb_composer_front_js', vc_asset_url( 'js/dist/js_composer_front.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true );
		}
		
		// JS scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/libs/popper/popper.min.js', array( 'jquery' ), FFBLANK()->config['cache_time'], true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/libs/bootstrap/bootstrap.min.js', array( 'jquery' ), FFBLANK()->config['cache_time'], true );

		wp_register_script( 'google-fonts', get_template_directory_uri() . '/assets/libs/google-fonts/webfont.js', false, FFBLANK()->config['cache_time'], true );
		wp_register_script( 'fruitfulblankprefix-front', get_template_directory_uri() . '/assets/js/front.js', array(
			'jquery',
			'google-fonts'
		), FFBLANK()->config['cache_time'], true );
		
		$js_vars = array(
			'ajaxurl'    => esc_url(admin_url( 'admin-ajax.php' )),
			'assetsPath' => get_template_directory_uri() . '/assets',
		);
		
		wp_enqueue_script( 'fruitfulblankprefix-front' );
		wp_localize_script( 'fruitfulblankprefix-front', 'themeJsVars', $js_vars );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		
		// CSS styles
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/libs/font-awesome/css/font-awesome.min.css', false, FFBLANK()->config['cache_time'] );
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/libs/animatecss/animate.min.css', false, FFBLANK()->config['cache_time'] );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/libs/bootstrap/bootstrap.min.css', false, FFBLANK()->config['cache_time'] );
		//wp_enqueue_style( 'uikit', get_template_directory_uri() . '/assets/libs/uikit/style.css', false, FFBLANK()->config['cache_time'] );
		//wp_enqueue_style( 'uikit-elements', get_template_directory_uri() . '/assets/libs/uikit/elements.css', false, FFBLANK()->config['cache_time'] );
		wp_enqueue_style( 'fruitfulblankprefix-style', get_template_directory_uri() . '/assets/css/front/front.css', false, FFBLANK()->config['cache_time'] );
		
	}
	
	function remove_assets() {
		
		// disable huge default JS composer styles
		wp_dequeue_style( 'js_composer_front' );
		wp_dequeue_style( 'animate-css' );
		//wp_dequeue_style( 'fw-ext-breadcrumbs-add-css' );
		
	}
	
	/**
	 * Change excerpt More text
	 **/
	function change_excerpt_more( $more ) {
		return '…';
	}
	
	/**
	 * Remove jquery migrate for optimization reasons
	 **/
	function dequeue_jquery_migrate( $scripts ) {
		if ( ! is_admin() ) {
			$scripts->remove( 'jquery' );
			$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
		}
	}
	
}
