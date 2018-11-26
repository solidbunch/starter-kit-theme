<?php
/**
 * Menu Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Menu' ) ) {
	class StarterKitShortcode_Menu extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'             => '',
				'menu'		        => '',
				'menu_id' 			=> '',
				'menu_class' 		=> '',
				'container'         => '',
				'container_class'   => '',
				'container_id'      => '',
				'depth'             => '',
				'classes' 		    => ''
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}