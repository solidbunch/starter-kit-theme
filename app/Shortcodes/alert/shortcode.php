<?php

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Alert' ) ) {
	class StarterKitShortcode_Alert extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'icon' 			=> '',
				'el_id' 		=> '',
				'style' 		=> '',
				'classes'		=> ''
			], $this->atts($atts), $this->shortcode );

			if ( $atts['icon'] <> '' ) {
				wp_enqueue_style( 'font-awesome' );
			}

			$this->add_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );
			$this->add_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/script.js' );

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}


