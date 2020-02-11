<?php
/**
 * Social Login Shortcode
 *
 */

use StarterKit\Base\Shortcode;
use StarterKit\Helper\Assets;
use StarterKit\Helper\View;

if ( ! class_exists( 'StarterKitShortcode_Social_Login' ) ) {
	class StarterKitShortcode_Social_Login extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [], $this->atts( $atts ), $this->shortcode );
			
			Assets::enqueue_style( 'font-awesome' );
			Assets::enqueue_style_dist(
				$this->shortcode . '-style',
				'shortcode-social_login.css'
			);
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}
