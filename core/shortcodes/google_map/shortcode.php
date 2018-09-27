<?php

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_G_Map extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
			);

			$api_key = $data['atts']['api_key'] <> '' ? '?key=' . $data['atts']['api_key'] : '';
			wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js' . $api_key, false,
				FFBLANK()->config['cache_time'], true );

			ob_start();

			require_once 'view/google_map_init.php';

			$map_loader_script = ob_get_clean();

			wp_add_inline_script( 'google-maps-api', $map_loader_script );

			return FFBLANK()->view->load( '/view/view', $data, true, $shortcode_dir );
		}

	}
}
