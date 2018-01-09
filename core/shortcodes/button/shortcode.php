<?php

/**
  * Button Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_fruitfulblankprefix_Button extends WPBakeryShortCode {

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

			/** Shortcode data to output **/
			$data = array(
				'id' => $id,
				'css_class' => $atts['classes'],
				'button_style' => $atts['button_style'],
				'button_align' => $atts['button_align'],
				'link' => $atts['link'],
				'title' => $atts['title'],
				'icon' => $atts['icon'],
			);
			
			return apply_filters('theme_get_template', 'view', $data, dirname( __FILE__ ).'/view/');
      
		}

	}
}