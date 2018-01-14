<?php

/**
  * Form printing Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_fruitfulblankprefix_Form_content extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			
			if (!empty($atts['form'])) {
				$data_post = get_post($atts['form']);
			}
			
			/** Shortcode data to output **/
			$data = array(
				'data_post' => $data_post,
			);
			
			return apply_filters('theme_get_template', 'view', $data, dirname( __FILE__ ).'/view/');
      
		}

	}
}