<?php

/**
 * Tab Shortcode
 **/

use StarterKit\Base\Shortcode;
use StarterKit\Helper\View;

if ( ! class_exists( 'StarterKitShortcode_Tab' ) ) {
	class StarterKitShortcode_Tab extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'icon'    => '',
				'title'   => '',
				'classes' => ''
			], $this->atts( $atts ), $this->shortcode );
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}