<?php
/**
 * Social Login Shortcode
 *
 */

use StarterKit\Model\Shortcode;
use StarterKit\Helper\Assets;

if ( !class_exists( 'StarterKitShortcode_Social_Login' ) ) {
	class StarterKitShortcode_Social_Login extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [], $this->atts($atts), $this->shortcode );

			Assets::enqueue_style( 'font-awesome' );
			Assets::enqueue_style_dist(
				$this->shortcode.'-style',
				'shortcode-social_login.css'
			);

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}
