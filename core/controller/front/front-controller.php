<?php

/**
 * Front side controller
 **/
class fruitfulblankprefix_front_controller extends fruitfulblankprefix_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run front-end actions
	**/
	function run() {

		// add site icon
		add_action( 'wp_head', array( $this, 'add_site_icon' ) );

		// load assets
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'remove_assets' ), 99, 1 );

		// Change excerpt dots
		//add_filter( 'excerpt_more', array( $this, 'change_excerpt_more' ) );

		// remove empty paragraphs
		//add_filter('the_content', array( $this, 'remove_empty_p' ), 20, 1);

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

		// JS scripts
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'fruitfulblankprefix-front', get_template_directory_uri() . '/assets/js/front.js', array( 'jquery' ), _FBCONSTPREFIX_CACHE_TIME_, true );

		$js_vars = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'assetsPath' => get_template_directory_uri() . '/assets',
		);

		wp_enqueue_script( 'fruitfulblankprefix-front' );
		wp_localize_script( 'fruitfulblankprefix-front', 'bvcJsVars', $js_vars );

		// CSS styles
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/libs/bootstrap.css', false, _FBCONSTPREFIX_CACHE_TIME_ );
		wp_enqueue_style( 'fruitfulblankprefix-base-style', get_template_directory_uri() . '/assets/css/front-base.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

	}

	function remove_assets() {
		wp_dequeue_style( 'fw-ext-breadcrumbs-add-css' );
	}

	/**
	 * Change excerpt More text
	 **/
	function change_excerpt_more( $more ) {
		return '…';
	}

	/**
	 * Remove empty paragraphs from post content
	 **/
	function remove_empty_p( $content ) {
		$content = str_replace( '<p></p>', '', $content );
		$content = str_replace( '<p>&nbsp;</p>', '', $content );
		return $content;
	}


}
