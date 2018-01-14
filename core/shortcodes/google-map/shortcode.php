<?php

/**
 * Google Map Shortcode
 **/
// !!! Need update js

// Map VC shortcode
require_once 'config.php';

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_fruitfulblankprefix_Map extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null)
		{
			
			global $ff_fruitfulblankprefix_core;
			
			$shortcode_path = __DIR__ . DIRECTORY_SEPARATOR;
			$shortcode_uri =  get_template_directory_uri() . '/core/shortcodes/google-map/';
			
			/** styles **/
			wp_enqueue_style('ff-fruitfulblankprefix-map', $shortcode_uri . 'assets/style.css', array(), '1.0.0');
			
			/** load view **/
			ob_start();
			require 'view/view.php';
			return ob_get_clean();
			
		}
		
	}
}
