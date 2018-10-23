<?php

vc_map(array(
	'name'            => esc_html__( 'Form Text Field with Datepicker', 'fruitfulblanktextdomain' ),
	'base'            => 'shortcode_contact_form_text_datepicker',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'calendar.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'fruitfulblanktextdomain' ),
	'as_child'        => array(
		'only' => 'shortcode_contact_form,vc_column_inner'
	),
	'params'          => array(
		
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'fruitfulblanktextdomain' ),
			'param_name'  => 'label',
			'holder'	  => 'h2',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'fruitfulblanktextdomain' ),
			'param_name'  => 'placeholder',
			'value'       => '',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Mandatory Field', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Make this field mandatory?', 'fruitfulblanktextdomain' ),
			'param_name'  => 'required',
			'value'       => array( esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Create event in Google Calendar', 'fruitfulblanktextdomain' ),
			'param_name' => 'create_event',
			'value'      => array( esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Used in "name" attribute', 'fruitfulblanktextdomain' ),
		),	
	)
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_shortcode_Contact_Form_Text_Datepicker extends WPBakeryShortCode{

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ){		

			/** init script **/
			$this->enqueue_scripts();

			$atts         = vc_map_get_attributes( $this->getShortcode(), $atts );
			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr( $atts['el_id'] ) . '"';
			$attributes[] = 'name="field_' . esc_attr( $atts['el_id'] ) . '"';
			$attributes[] = 'placeholder="' . esc_attr( $atts['placeholder'] ) . '"';

			if ( filter_var($atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required="required"';
			}

			$data = array(
				'atts'        => $atts,
				'attributes'  => $attributes,
			);

			return FFBLANK()->view->load( '/../view/contact_form_text_datepicker', $data, true, dirname( __FILE__ ) );		
		}

		/**
		 *
		 * Add Styles and scripts
		 *		 		 
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode ) .'..';
			
			/** scripts **/
			wp_register_script( 'shortcode-air-datepicker', $shortcode_uri. '/form/assets/libs/air-datepicker/dist/js/datepicker.min.js', array('jquery'), FFBLANK()->config['cache_time'], true );
			wp_register_script('shortcode-air-datepicker-i18n', $shortcode_uri . '/form/assets/libs/air-datepicker/dist/js/i18n/datepicker.en.js', array('jquery'), FFBLANK()->config['cache_time'], true );
			wp_register_script( 'shortcode-air-datepicker-init', $shortcode_uri. '/form/assets/date-picker-init.js', array('jquery'), FFBLANK()->config['cache_time'], true );
			
			wp_enqueue_script( 'shortcode-air-datepicker' );
			wp_enqueue_script( 'shortcode-air-datepicker-i18n' );
			wp_enqueue_script( 'shortcode-air-datepicker-init' );
			
			/** style **/
			wp_enqueue_style( 'shortcode-air-datepicker', $shortcode_uri . '/form/assets/libs/air-datepicker/dist/css/datepicker.min.css', false, FFBLANK()->config['cache_time'] );
		}
		
	}
}
