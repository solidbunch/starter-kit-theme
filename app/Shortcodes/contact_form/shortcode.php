<?php
/**
 * Form Shortcode
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Contact_Form' ) ) {
	class StarterKitShortcode_Contact_Form extends Shortcode {

		public function content( $atts, $content = null ) {

			/** Form data **/
			$atts = shortcode_atts( [
				'el_id'                 => '',
				'classes'               => '',
				'email_to'              => '',
				'redirect_on_success'   => '',
				'success_message'       => '',
				'subject_message'       => ''
			], $this->atts($atts), $this->shortcode );

			$attributes = $form_data = [];

			if ( $atts['redirect_on_success'] <> '' ) {
				$attributes[] = 'data-redirect-url="' . esc_attr( $atts['redirect_on_success'] ) . '"';
			}

			$attributes[]                 = 'data-msg-success="' . esc_attr( $atts['success_message'] ) . '"';
			$attributes[]                 = 'data-nonce="' . wp_create_nonce('contact-form') . '"';
			$form_data['email_to']        = $atts['email_to'];
			$form_data['subject_message'] = $atts['subject_message'];
			$form_data['form_id']         = $atts['el_id'];
			$attributes[]                 = 'data-form-data="' . base64_encode( serialize( $form_data ) ) . '"';

			/** Add styles and scripts **/
			$this->enqueue_scripts();

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
				'attributes' => $attributes
			]);
			//dd($data);

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

		/**
		 * Add styles and scripts
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			$this->enqueue_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/scripts.js' );
			$this->localize_script( $this->shortcode.'-script', 'ShortcodeContactForm', array(
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'strSuccess'             => esc_html__('Success', 'starter-kit'),
				'strError'               => esc_html__('Error', 'starter-kit'),
				'strAJAXError'           => esc_html__('An AJAX error occurred when performing a query. Please contact support if the problem persists.', 'starter-kit'),
				'strServerResponseError' => esc_html__('The script have received an invalid response from the server. Please contact support if the problem persists.', 'starter-kit'),
				'strFormError'           => esc_html__('Form validation error. Please check all required fields and try again.', 'starter-kit'),
			));

			$this->enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );
		}

		/**
		 * AJAX hooks
		 *
		 * @return void
		 */
		public function ajax_script() {
		}
	}
}