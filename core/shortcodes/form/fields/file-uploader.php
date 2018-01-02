<?php

vc_map(array(
	'name' => esc_html__('Form File Uploader', 'bvc'),
	'base' => 'bvc_contact_form_file_uploader',
	'content_element' => true,
	'category' => esc_html__('Form Fields', 'bvc'),
	'as_child' => array('only' => 'bvc_contact_form,vc_column_inner'),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Field name', 'bvc'),
			'description' => esc_html__('Enter a field name for Humans', 'bvc'),
			'param_name' => 'label',
			'holder'		=> 'h2',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Placeholder', 'bvc'),
			'description' => esc_html__('This text will be used as field placeholder', 'bvc'),
			'param_name' => 'placeholder',
			'value' => '',
		),
//		array(
//			'type' => 'checkbox',
//			'heading' => esc_html__('Mandatory Field', 'bvc'),
//			'description' => esc_html__('Make this field mandatory?', 'bvc'),
//			'param_name' => 'required',
//			'value' => array(esc_html__('Yes', 'bvc') => 'yes'),
//		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__('Field ID', 'bvc'),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'description' => esc_html__('Used in "name" attribute', 'bvc'),
		),
	
	)
));

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_bvc_Contact_Form_File_Uploader extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null)
		{
			
			ob_start();
			require get_template_directory() . '/core/shortcodes/form/view/contact_form_file_uploader.php';
			return ob_get_clean();
			
		}
		
	}
}
