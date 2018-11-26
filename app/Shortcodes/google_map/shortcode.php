<?php
/**
 * Google Map Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Google_Map' ) ) {
	class StarterKitShortcode_Google_Map extends Shortcode {

		public function content( $atts, $content = null ) {

			/** Form data **/
			$atts = shortcode_atts( [
				'el_id'         => '',
				'api_key'       => '',
				'address'       => '',
				'height'        => '',
				'zoom'          => '',
				'pin_icon'      => '',
				'pin_offset_x'  => '',
				'pin_offset_y'  => '',
				'hue'           => '',
				'saturation'    => '',
				'lightness'     => '',
				'gamma'         => ''
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			]);

			$api_key = $atts['api_key'] <> '' ? '?key=' . $atts['api_key'] : '';
			$this->enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js' . $api_key);

			ob_start();
			require_once 'view/google_map_init.php';
			$map_loader_script = ob_get_clean();
			$this->add_inline_script( 'google-maps-api', $map_loader_script );

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}