<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Utils;
use StarterKit\Helper\View;

/**
 * Extend default functional of WP Bakery JS Composer Plugin
 **/
class VisualComposerExtends {
	
	/**
	 * Load assets for extended params
	 **/
	public static function load_assets() {
		wp_enqueue_style( 'jsc-file_picker_field', Utils::getConfigSetting( 'assets_uri' ) . '/js_composer_extends/file_picker_field.css', false,
			Utils::getConfigSetting( 'cache_time' ) );
	}
	
	/**
	 * Register custom param types
	 */
	public static function register_custom_plugin_params() {
		// file picker
		vc_add_shortcode_param( 'file_picker', [ __CLASS__, 'create_file_picker_param' ],
			Utils::getConfigSetting( 'assets_uri' ) . '/js_composer_extends/file_picker_field.js' );
	}
	
	/**
	 * File picker custom VC param
	 */
	public static function create_file_picker_param( $settings, $value ) {
		$data = [
			'settings' => $settings,
			'value'    => $value,
		];
		
		return View::load( '/app/templates/admin/js_composer/param_file_picker', $data, true );
		
	}
	
}