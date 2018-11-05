<?php


if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_pricing_table extends WPBakeryShortCode {

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ) {

			$shortcode_dir = __DIR__;
			$shortcode     = basename( $shortcode_dir );

			$this->addStyles( $shortcode );
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

			wp_enqueue_style( 'pricing_table', $shortcode_uri . '/assets/style.css' );
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
			//parse pricing_table sting to array
			$pricing_columns = vc_param_group_parse_atts( $atts['columns'] );

			$columns = array();
				
			foreach ( $pricing_columns as $column ) {
				$columns[] = array(
					'title'         => $column['title'],
					'features'      => $column['features'],
					'currency'      => $column['currency'],
					'price'         => $column['price'],
					'period'        => $column['period'],
					'button_url'    => $column['button_url'],
					'button_title'  => $column['button_title']
				);
			}

			/** Shortcode data to output **/

			return array(
				'atts'      => $atts,
				'content'   => $content,
				'columns'   => $columns
			);
		}

	}
}
