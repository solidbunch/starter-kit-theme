<?php

/**
 * Tabs Container / Tabs Shortcode
 **/

use StarterKit\Base\Shortcode;
use StarterKit\Helper\Assets;
use StarterKit\Helper\View;

if ( ! class_exists( 'StarterKitShortcode_Tabs' ) ) {
	class StarterKitShortcode_Tabs extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'position' => '',
				'el_id'    => '',
				'classes'  => ''
			], $this->atts( $atts ), $this->shortcode );
			
			Assets::enqueue_style_dist( 'shortcode-' . $this->shortcode . '-style', 'shortcode-' . $this->shortcode . '.css' );
			Assets::enqueue_script( $this->shortcode . '-script', $this->shortcode_uri . '/assets/scripts.js' );
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}
