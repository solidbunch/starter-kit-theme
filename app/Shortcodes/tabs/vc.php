<?php

/**
 * Tabs Shortcode
 **/

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Tabs extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			return Starter_Kit()->Controller->Shortcodes->content($this->settings['base'], $atts, $content);
		}

	}
}