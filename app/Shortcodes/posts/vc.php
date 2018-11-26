<?php
/**
 * Posts Shortcode / VC Support
 *
 **/

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Posts extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			return Starter_Kit()->Controller->Shortcodes->content($this->settings['base'], $atts, $content);
		}

	}
}