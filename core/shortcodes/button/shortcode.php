<?php

/**
  * Button Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Button extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			if( $atts['icon'] <> '' ) {
				wp_enqueue_style( 'font-awesome' );
			}

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}