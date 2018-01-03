<?php

/**
  * Testimonials Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Testimonials extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			$id = 'shortcode-' . $atts['el_id'];

			$assets_path = get_template_directory_uri() . '/core/shortcodes/testimonials/assets';

			wp_enqueue_style( 'bvc-testimonials', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

			wp_register_script( 'bvc-testimonials', $assets_path . '/scripts.js', array( 'jquery', 'slick-carousel' ) );
			wp_enqueue_script( 'bvc-testimonials' );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}