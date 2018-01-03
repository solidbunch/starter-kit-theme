<?php

/**
  * Brokers Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Brokers extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			$assets_path = get_template_directory_uri() . '/core/shortcodes/brokers/assets';

			wp_enqueue_style( 'bvc-brokers', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

			wp_register_script( 'bvc-brokers', $assets_path . '/scripts.js', array( 'jquery', 'slick-carousel' ) );
			wp_enqueue_script( 'bvc-brokers' );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}