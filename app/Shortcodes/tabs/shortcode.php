<?php

/**
 * Tabs Container / Tabs Shortcode
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Tabs' ) ) {
	class StarterKitShortcode_Tabs extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'position'          => '',
				'el_id'             => '',
				'classes'           => ''
			], $this->atts($atts), $this->shortcode );

			$this->enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );
			$this->enqueue_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/scripts.js' );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			]);

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}