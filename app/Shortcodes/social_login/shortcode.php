<?php
/**
 * Social Login Shortcode
 *
 */

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Social_Login' ) ) {
	class StarterKitShortcode_Social_Login extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
			], $this->atts($atts), $this->shortcode );

			$this->enqueue_style( 'font-awesome' );
			$this->enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}