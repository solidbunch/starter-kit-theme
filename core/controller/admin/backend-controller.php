<?php

/**
 * Backend controller
 **/
class fruitfulblankprefix_backend_controller extends fruitfulblankprefix_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run backend actions
	**/
	function run() {

		// load admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets') );

		// Change admin menu position
		//add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ));

		// disable VC front-end
		add_action( 'vc_before_init', array( $this, 'setup_vc') );
		
		require_once _FBCONSTPREFIX_LIBRARY_DIR_ . '/tgm/class-tgm-init.php';

	}

	/**
	 * Load admin assets
	**/
	function load_assets() {
		wp_enqueue_style( 'fruitfulblankprefix-backend', get_template_directory_uri() . '/assets/css/admin.css' );
	}

	/**
	 * Add Website Options Menu
	**/
	function add_theme_options_menu( $data ) {

		add_menu_page(
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

	}

	/**
	 * Setup Visual Composer
	 * disable front-end mode
	**/
	function setup_vc() {
		if( function_exists( 'vc_disable_frontend') ) {
			vc_disable_frontend();
		}
	}

}
