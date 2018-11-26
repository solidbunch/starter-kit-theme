<?php

/**
 * Form Shortcode / VC Support
 **/

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Contact_Form extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			return Starter_Kit()->Controller->Shortcodes->content($this->settings['base'], $atts, $content);
		}

	}
}