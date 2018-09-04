<?php


if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_param_group extends WPBakeryShortCode {

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ) {

			$shortcode_dir = __DIR__;
			$shortcode     = basename( $shortcode_dir );

			//$this->addStyles( $shortcode );
			$data = $this->getDataArray( $atts, $content );

			try {
				return FFBLANK()->view->load( '/view/view', $data, true, $shortcode_dir );
			} catch ( \Exception $exception ) {
				error_log( $exception );

				return false;
			}

		}

		/**
		 *
		 * Add Styles and scripts
		 *
		 * @param $shortcode
		 *
		 * @return void
		 */
		protected function addStyles( $shortcode ) {
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );

			wp_enqueue_style( 'param_group', $shortcode_uri . '/assets/styles.css' );
		}

		/**
		 * filter attrs for data
		 *
		 *
		 * @param $atts
		 * @param null $content
		 *
		 * @return array
		 */
		protected function getDataArray( $atts, $content = null ) {
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			//parse param_group sting to array
			$images = vc_param_group_parse_atts($atts['images']);


			$image_blocks = array();
			foreach ( $images as $image ) {
				$image_blocks[] = array(
					'src' => \wp_get_attachment_image_url($image['image'],'full'),
					'alt' => \get_post_meta( $image['image'], '_wp_attachment_image_alt', true ),
					'caption' => $image['caption'],
					'text' => $image['hover_text']
				);
			}

			/** Shortcode data to output **/

			return array(
				'atts'            => $atts,
				'content'         => $content,
				'image_blocks'    => $image_blocks
			);
		}

	}
}
