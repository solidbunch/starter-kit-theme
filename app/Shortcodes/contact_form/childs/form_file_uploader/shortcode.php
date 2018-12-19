<?php
/**
 * Form File Uploader Field / Form Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Form_File_Uploader' ) ) {
	class StarterKitShortcode_Form_File_Uploader extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'         =>  '',
				'label'         => '',
				'placeholder'   => ''
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
			$this->enqueue_script( 'shortcode-uploader', $this->shortcode_uri.'/assets/uploader.js' );
		}

	}
}