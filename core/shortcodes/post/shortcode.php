<?php

/**
  * Heading Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Form_content extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			
			if (!empty($atts['form'])) {
				$data_post = get_post($atts['form']);
			}
			
			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}