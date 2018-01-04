<?php

/**
  * Benefits Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Benefits extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			$assets_path = get_template_directory_uri() . '/core/shortcodes/benefits/assets';

			wp_enqueue_style( 'fruitfulblankprefix-benefits', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}