<?php

namespace StarterKit\Controller;

/**
 * Extend default functional of WP Bakery JS Composer Plugin
 **/
class VisualComposerExtends {

	/**
	 * Constructor
	 **/
	function __construct() {

		// load admin assets
		add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );

		// Add Custom Controls to Visual Composer
		add_action( 'vc_load_default_params', [ $this, 'register_custom_plugin_params' ] );

	}

	/**
	 * Load assets for extended params
	 **/
	function load_assets() {

		wp_enqueue_style( 'jsc-file_picker_field', Starter_Kit()->config['assets_uri'] . '/js_composer_extends/file_picker_field.css', false, Starter_Kit()->config['cache_time'] );

	}

	/**
	 * Register custom param types
	 */
	function register_custom_plugin_params() {

		// file picker
		vc_add_shortcode_param( 'file_picker', [ $this, 'create_file_picker_param' ], Starter_Kit()->config['assets_uri'] . '/js_composer_extends/file_picker_field.js' );

	}

	/**
	 * File picker custom VC param
	 */
	function create_file_picker_param( $settings, $value ) {

		$data = [
			'settings' => $settings,
			'value' => $value
		];

		return Starter_Kit()->View->load( '/app/view/admin/js_composer/param_file_picker', $data, true );

	}

}