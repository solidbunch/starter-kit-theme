<?php

/**
 * Toggles / Accordion Shortcode
 **/

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Toggles extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			/** Shortcode data to output **/
			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
			);

			return FFBLANK()->view->load( '/view/view_container', $data, true, $shortcode_dir );

		}

	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Toggle extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );
			$atts          = vc_map_get_attributes( $this->getShortcode(), $atts );

			/** Shortcode data to output **/
			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
			);

			return FFBLANK()->view->load( '/view/view_content', $data, true, $shortcode_dir );

		}

	}
}
