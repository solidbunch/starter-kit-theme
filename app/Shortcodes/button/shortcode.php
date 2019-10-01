<?php

/**
 * Button Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( ! class_exists( 'StarterKitShortcode_Button' ) ) {
	class StarterKitShortcode_Button extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'title'        => '',
				'link'         => '',
				'icon'         => '',
				'button_align' => '',
				'button_size'  => '',
				'button_style' => 'primary',
				'outline'      => '',
				'css'          => '',
				'el_id'        => '',
				'classes'      => ''
			], $this->atts( $atts ), $this->shortcode );
			
			if ( $atts['icon'] <> '' ) {
				\StarterKit\Helper\Assets::enqueue_style( 'font-awesome' );
			}

			\StarterKit\Helper\Assets::enqueue_style_dist( 'shortcode-' . $this->shortcode . '-style', 'shortcode-' . $this->shortcode . '.css' );
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			] );
			
			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}
