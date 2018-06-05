<?php

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Alert extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			if( $atts['icon'] <> '' ) {
				wp_enqueue_style( 'font-awesome' );
			}

			//wp_enqueue_style( 'my-style', \ffblank\helper\utils::get_shortcodes_uri( $shortcode, '/assets/my-style.css') );

			$data = array(
				'id' => $id,
				'atts' => $atts,
				'content' => $content,
			);

			return FFBLANK()->view->load( '/view/view', $data, true, $shortcode_dir );
		}

	}
}
