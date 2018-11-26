<?php
/**
 * Form Text Datepicker Field / Form Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Form_Text_Datepicker' ) ) {
	class StarterKitShortcode_Form_Text_Datepicker extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'         =>  '',
				'required'      => '',
				'placeholder'   => '',
				'create_event'  => ''
			], $this->atts($atts), $this->shortcode );

			$attributes   = [];
			$attributes[] = 'id = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder = "' . esc_attr($atts['placeholder']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required = "required"';
			}

			$this->enqueue_scripts();

			$data = $this->data( array(
				'atts'    => $atts,
				'attributes' => $attributes
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

		/**
		 *
		 * Add Styles and scripts
		 *
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			$this->enqueue_script( 'shortcode-air-datepicker', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/js/datepicker.min.js' );
			$this->enqueue_script( 'shortcode-air-datepicker-i18n', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/js/i18n/datepicker.en.js' );
			$this->enqueue_script( 'shortcode-air-datepicker-init', $this->shortcode_uri.'/assets/date-picker-init.js' );

			$this->enqueue_style( 'shortcode-air-datepicker', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/css/datepicker.min.css' );
		}

	}
}