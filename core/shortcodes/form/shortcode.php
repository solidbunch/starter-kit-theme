<?php
/**
 * ShortcodeContact Form
**/

/** open files fields **/
ffblank\helper\open_fields::open_file( dirname( __FILE__ ) );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_shortcode_contact_form extends WPBakeryShortCodesContainer {	

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ) {

			/** init script and style  **/
			$this->enqueue_scripts();
			/** init content **/
			$data = $this->getDataArray( $atts, $content );
			return FFBLANK()->view->load( '/view/view', $data, true, dirname( __FILE__ ) );			
			
		}

		/**
		 *
		 * add styles and scripts
		 *		 
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			/** scripts **/
			wp_register_script( 'shortcode-contact-form', \ffblank\helper\utils::get_shortcodes_uri( basename( dirname( __FILE__ ) ) ) . 'assets/form-scripts.js',array( 'jquery' ), FFBLANK()->config['cache_time'] );
			wp_enqueue_script( 'shortcode-contact-form' );			
			wp_localize_script( 'shortcode-contact-form', 'ShortcodeContactForm', array(
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'strSuccess'             => esc_html__( 'Success', 'fruitfulblanktextdomain'),
				'strError'               => esc_html__('Error', 'fruitfulblanktextdomain'),
				'strAJAXError'           => esc_html__('An AJAX error occurred when performing a query. Please contact support if the problem persists.', 'fruitfulblanktextdomain'),
				'strServerResponseError' => esc_html__('The script have received an invalid response from the server. Please contact support if the problem persists.', 'fruitfulblanktextdomain'),
				'strFormError'           => esc_html__('Form validation error. Please check all required fields and try again.', 'fruitfulblanktextdomain'),
			));	

			/** styles **/
			wp_enqueue_style( 'shortcode-contact-form', \ffblank\helper\utils::get_shortcodes_uri( basename( dirname( __FILE__ ) ) ) . 'assets/style.css', false, FFBLANK()->config['cache_time'] );			
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

			$atts    = vc_map_get_attributes( $this->getShortcode(), $atts );
			$classes = $attributes = $form_data = array();

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			if ( $atts['redirect_on_success'] <> '' ) {
				$attributes[] = 'data-redirect-url="' . esc_attr( $atts['redirect_on_success'] ) . '"';
			}

			$attributes[]                 = 'data-msg-success="' . esc_attr( $atts['success_message'] ) . '"';
			$attributes[]                 = 'data-nonce="' . wp_create_nonce('shortcode-contact-form') . '"';
			$form_data['email_to']        = $atts['email_to'];
			$form_data['subject_message'] = $atts['subject_message'];
			$form_data['form_id']         = $atts['el_id'];
			$attributes[]                 = 'data-form-data="' . base64_encode( serialize( $form_data ) ) . '"';

			/** Shortcode data to output **/
			return array(
				'id'         => $id,
				'atts'       => $atts,
				'content'    => $content,
				'attributes' => $attributes,
				'classes'    => $classes,
				'wpb'        => $this,
			);
		}

	}
}
