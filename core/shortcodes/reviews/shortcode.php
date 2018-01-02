<?php

/**
  * Reviews Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_BVC_Reviews extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			
			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			$assets_path = get_template_directory_uri() . '/core/shortcodes/reviews/assets';

			wp_enqueue_style( 'star-rating-svg' );
			wp_enqueue_style( 'bvc-reviews', $assets_path . '/style.css', false, _BVC_CACHE_TIME_ );

			wp_enqueue_script( 'star-rating-svg' );
			wp_register_script( 'bvc-reviews', $assets_path . '/scripts.js', array( 'jquery', 'slick-carousel', 'star-rating-svg' ) );
			wp_enqueue_script( 'bvc-reviews' );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}