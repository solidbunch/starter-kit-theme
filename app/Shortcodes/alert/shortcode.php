<?php
/**
 * Alert Shortcode
 *
 */

use StarterKit\Model\Shortcode;

if ( ! class_exists( 'StarterKitShortcode_Alert' ) ) {
	class StarterKitShortcode_Alert extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'icon'    => '',
				'el_id'   => '',
				'style'   => '',
				'classes' => ''
			], $this->atts( $atts ), $this->shortcode );
			
			if ( $atts['icon'] <> '' ) {
				wp_enqueue_style( 'font-awesome' );
			}
			
			\StarterKit\Helper\Assets::enqueue_style_dist( 'shortcode-' . $this->shortcode . '-style', 'shortcode-' . $this->shortcode . '.css' );
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
			] );
			
			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}


