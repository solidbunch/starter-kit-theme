<?php
/**
 * Checkbox / Form Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Form_Email' ) ) {
	class StarterKitShortcode_Form_Email extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'         =>  '',
				'label'		    => '',
				'required'      => '',
				'placeholder'   => ''
			], $this->atts($atts), $this->shortcode );

			$attributes   = [];
			$attributes[] = 'id = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder = "' . esc_attr($atts['placeholder']) . '"';
			$attributes[] = 'class = "form-control"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required = "required"';
			}

			$data = $this->data( array(
				'atts'    => $atts,
				'attributes' => $attributes
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}