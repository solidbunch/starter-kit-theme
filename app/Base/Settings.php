<?php


namespace StarterKit\Base;


/**
 * Settings functionality for the theme
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Settings {
	
	public static function init() {
		if ( ! class_exists( \Carbon_Fields\Carbon_Fields::class ) ) {
			self::autoload();
		}
		add_action( 'after_setup_theme', [ \Carbon_Fields\Carbon_Fields::class, 'boot' ] );
		// strange, but on each save theme_option and meta_fields CF delete old records from the DB
		// this filter prevent this behavior, but some functionality working wrong 
		// add_filter( 'carbon_fields_should_delete_field_value_on_save', __return_false() );
	}
	
	
	private static function autoload() {
		if ( ! defined( 'VENDOR_DIR' ) ) {
			return;
		}
		spl_autoload_register( function ( $class ) {
			
			// project-specific namespace prefix
			$prefix = 'Carbon_Fields\\';
			
			// base directory for the namespace prefix
			$base_dir = get_template_directory() . '/' . VENDOR_DIR . '/carbon-fields/core/';
			
			// does the class use the namespace prefix?
			$len = strlen( $prefix );
			if ( strncmp( $prefix, $class, $len ) !== 0 ) {
				// no, move to the next registered autoloader
				return;
			}
			
			// get the relative class name
			$relative_class = substr( $class, $len );
			
			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php
			$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
			
			// if the file exists, require it
			if ( file_exists( $file ) ) {
				require $file;
			}
		} );
	}
}