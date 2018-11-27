<?php
/**
 * Pricing Table Shortcode
 *
 */

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Pricing_Table' ) ) {
	class StarterKitShortcode_Pricing_Table extends Shortcode {

		public function content( $atts, $content = null ) {

			$this->content = $content;

			$this->atts = shortcode_atts( [
				'columns' 			    => '',
				'border_color' 		    => '',
				'header_bg_color'		=> '',
				'header_text_color'		=> '',
				'button_bg_color'		=> '',
				'button_hover_bg_color'	=> '',
				'button_text_color'		=> '',
				'button_hover_text_color'=> '',
				'button_border_color'	=> '',
				'border_radius'		    => '',
				'border_width'		    => '',
				'button_border_width'	=> ''

			], $this->atts($atts), $this->shortcode );

			$this->enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );

			$columns = $this->getColumsData();

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
				'columns' => $columns
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

		/**
		 * Get columns data
		 *
		 * @return array
		 */
		protected function getColumsData() {
			$pricing_columns = $this->param_group_parse_atts( $this->atts['columns'] );

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

			return $columns;
		}

	}
}