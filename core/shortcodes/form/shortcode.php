<?php

/**
 * Contact Form Shortcode
 **/

// Map primary VC shortcode
require_once 'config.php';

require_once 'fields/email.php';
require_once 'fields/text.php';
require_once 'fields/text-datepicker.php';
require_once 'fields/select-coin.php';
require_once 'fields/checkbox.php';
require_once 'fields/textarea.php';
require_once 'fields/submit.php';
require_once 'fields/file-uploader.php';


if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_bvc_contact_form extends WPBakeryShortCodesContainer
	{
		
		protected function content($atts, $content = null) {
			global $ff_bvc_core;
			
			$atts = vc_map_get_attributes($this->getShortcode(), $atts);

			$classes = $attributes = $form_data = array();

			// Form attributes
			$attributes[] = 'id="bvc-form-' . esc_attr($atts['el_id']) . '"';

			if ($atts['redirect_on_success'] <> '') {
				$attributes[] = 'data-redirect-url="' . esc_attr($atts['redirect_on_success']) . '"';
			}

			$attributes[] = 'data-msg-success="' . esc_attr($atts['success_message']) . '"';

			$attributes[] = 'data-nonce="' . wp_create_nonce('bvc-contact-form') . '"';

			$form_data['email_to'] = $atts['email_to'];
			$form_data['subject_message'] = $atts['subject_message'];
			$form_data['form_id'] = $atts['el_id'];

			$attributes[] = 'data-form-data="' . base64_encode(serialize($form_data)) . '"';

			$shortcode_path = __DIR__ . DIRECTORY_SEPARATOR;
			$shortcode_uri =  get_template_directory_uri() . '/core/shortcodes/form/';
			
			/** scripts **/
			wp_register_script('bvc-contact-form', $shortcode_uri . 'assets/form-scripts.js',array('jquery'), _BVC_CACHE_TIME_);
			wp_enqueue_script('bvc-contact-form');
			
			$js_vars = array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'strSuccess' => esc_html__('Success', 'bvc'),
				'strError' => esc_html__('Error', 'bvc'),
				'strAJAXError' => esc_html__('An AJAX error occurred when performing a query. Please contact support if the problem persists.', 'bvc'),
				'strServerResponseError' => esc_html__('The script have received an invalid response from the server. Please contact support if the problem persists.', 'bvc'),
				'strFormError' => esc_html__('Form validation error. Please check all required fields and try again.', 'bvc'),
			);
			
			wp_localize_script('bvc-contact-form', 'bvcContactForm', $js_vars);
			
			/** styles **/
			wp_enqueue_style('ff-bvc-contact-form', $shortcode_uri . 'assets/style.css', false, _BVC_CACHE_TIME_);
			
			/** load template **/
			ob_start();
			require 'view/contact_form.php';
			return ob_get_clean();
			
		}
		
	}
}
