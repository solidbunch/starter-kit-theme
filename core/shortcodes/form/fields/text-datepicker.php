<?php

vc_map(array(
	'name' => esc_html__('Form Text Field with Datepicker', 'fruitfulblanktextdomain'),
	'base' => 'bvc_contact_form_text_datepicker',
	'content_element' => true,
	'category' => esc_html__('Form Fields', 'fruitfulblanktextdomain'),
	'as_child' => array('only' => 'bvc_contact_form,vc_column_inner'),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Field name', 'fruitfulblanktextdomain'),
			'description' => esc_html__('Enter a field name for Humans', 'fruitfulblanktextdomain'),
			'param_name' => 'label',
			'holder'		=> 'h2',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Placeholder', 'fruitfulblanktextdomain'),
			'description' => esc_html__('This text will be used as field placeholder', 'fruitfulblanktextdomain'),
			'param_name' => 'placeholder',
			'value' => '',
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Mandatory Field', 'fruitfulblanktextdomain'),
			'description' => esc_html__('Make this field mandatory?', 'fruitfulblanktextdomain'),
			'param_name' => 'required',
			'value' => array(esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes'),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Create event in Google Calendar', 'fruitfulblanktextdomain'),
			'param_name' => 'create_event',
			'value' => array(esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes'),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__('Field ID', 'fruitfulblanktextdomain'),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'description' => esc_html__('Used in "name" attribute', 'fruitfulblanktextdomain'),
		),
	
	)
));

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_bvc_Contact_Form_Text_Datepicker extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null)
		{
			$shortcode_uri =  get_template_directory_uri() . '/core/shortcodes/form/';
			
			wp_register_script( 'bvc-air-datepicker', $shortcode_uri. '/assets/libs/air-datepicker/dist/js/datepicker.min.js', array('jquery'), _BVC_CACHE_TIME_, true );
			wp_register_script('bvc-air-datepicker-i18n', $shortcode_uri . '/assets/libs/air-datepicker/dist/js/i18n/datepicker.en.js', array('jquery'), _BVC_CACHE_TIME_, true );
			wp_register_script( 'bvc-air-datepicker-init', $shortcode_uri. '/assets/date-picker-init.js', array('jquery'), _BVC_CACHE_TIME_, true );
			
			wp_enqueue_script( 'bvc-air-datepicker' );
			wp_enqueue_script( 'bvc-air-datepicker-i18n' );
			wp_enqueue_script( 'bvc-air-datepicker-init' );
			
			wp_enqueue_style( 'bvc-air-datepicker', $shortcode_uri . '/assets/libs/air-datepicker/dist/css/datepicker.min.css', false, _BVC_CACHE_TIME_ );
			
			
			ob_start();
			require get_template_directory() . '/core/shortcodes/form/view/contact_form_text_datepicker.php';
			return ob_get_clean();
			
		}
		
	}
}
