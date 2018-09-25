<?php

namespace ffblank\controller;

/**
 * Backend controller
 **/
class backend {
	
	/**
	 * Constructor
	 **/
	function __construct() {
		
		// load admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		
		// install required plugins
		require_once get_template_directory() . '/vendor/tgm/class-tgm-plugin-activation.php';
		add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ) );
		
		// Change theme options default menu position
		add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ) );
		
	}
	
	/**
	 * Load admin assets
	 **/
	function load_assets() {
		wp_enqueue_style( 'fruitfulblankprefix-backend', get_template_directory_uri() . '/assets/css/admin/admin.css', false, FFBLANK()->config['cache_time'] );
	}
	
	/**
	 * Install required plugins
	 **/
	function tgmpa_register() {
		
		$plugins = array(
			
			array(
				'name'     => 'Unyson',
				'slug'     => 'unyson',
				'required' => false
			),
			
			array(
				'name'         => 'WPBakery Page Builder',
				'slug'         => 'js_composer',
				'source'       => 'https://fruitfulcode.com/themeforest/js_composer.zip',
				'required'     => false,
				'version'      => '',
				'external_url' => '',
			),
		
		);
		
		// it is not necessairy to provide custom language config for TGM, so just leave it default
		tgmpa( $plugins );
		
	}
	
	/**
	 * Add Website Options Menu
	 **/
	function add_theme_options_menu( $data ) {
		
		add_theme_page(
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);
		
	}
	
}
