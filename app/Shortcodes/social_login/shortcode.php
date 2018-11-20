<?php

/**
 * Social Login Shortcode
 **/

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Social_Login extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \StarterKit\Helper\Utils::get_shortcodes_uri( $shortcode );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'shortcode-social-login',
				\StarterKit\Helper\Utils::get_shortcodes_uri( $shortcode, '/assets/style.css' ) );

			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
				'wpb'     => $this
			);

			return Starter_Kit()->View->load( '/view/view', $data, true, $shortcode_dir );

		}

	}
}
