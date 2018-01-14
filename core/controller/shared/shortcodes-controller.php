<?php

/**
 * Shortcodes controller
 **/
class fruitfulblankprefix_shortcodes_controller extends fruitfulblankprefix_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run shortcodes actions
	**/
	function run() {

		// add shortcodes
		add_action( 'vc_after_init', array( $this, 'register_vc_shortcodes') );

		// AJAX actions for shortcodes
		$this->setup_shortcodes_ajax_actions();

	}

	/**
		Custom theme shortcodes
	**/
	function register_vc_shortcodes() {

		if( function_exists( 'vc_map') ) {

			$shortcodes = glob( get_template_directory() . '/core/shortcodes/*' , GLOB_ONLYDIR );

			foreach( $shortcodes as $shortcode ) {
				$shortcode_name = str_replace( '-', '_', basename( $shortcode ));

				if( in_array( $shortcode_name, $shortcodes ) ) {
					continue;
				}

				require_once( $shortcode . '/shortcode.php' );

			}

		}

	}

	/**
		AJAX actions for shortcodes
	**/
	function setup_shortcodes_ajax_actions() {

		$shortcodes = glob( get_template_directory() . '/core/shortcodes/*' , GLOB_ONLYDIR );

		foreach( $shortcodes as $shortcode ) {
			$shortcode_name = str_replace( '-', '_', basename( $shortcode ));

			if( in_array( $shortcode_name, $shortcodes ) ) {
				continue;
			}

			$ajax_file = $shortcode . '/ajax.php';

			if( file_exists( $ajax_file ) ) {
				require_once( $ajax_file );
			}

		}

	}

}
