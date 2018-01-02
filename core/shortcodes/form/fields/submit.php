<?php

vc_map(array(
	'name' => esc_html__('Form Submit', 'bvc'),
	'base' => 'bvc_contact_form_submit',
	'content_element' => true,
	'category' => esc_html__('Form Fields', 'bvc'),
	'as_child' => array('only' => 'bvc_contact_form,vc_column_inner'),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Label', 'bvc'),
			'description' => esc_html__('This text will appear in submit button', 'bvc'),
			'param_name' => 'submit_button_text',
			'holder'		=> 'h2',
			'value' => esc_html__('Send', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Button Align', 'bvc'),
			'param_name' => 'align',
			'save_always' => true,
			'value' => array(
				esc_html__('None', 'wplab-bvc-core') => '',
				esc_html__('Left', 'wplab-bvc-core') => 'left',
				esc_html__('Center', 'wplab-bvc-core') => 'center',
				esc_html__('Right', 'wplab-bvc-core') => 'right',
			),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__('Button ID', 'bvc'),
			'description' => esc_html__('Here you can set unique identifier for this button', 'bvc'),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'value' => '',
		),
	
	)
));

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_bvc_Contact_Form_Submit extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null)
		{
			
			ob_start();
			require get_template_directory() . '/core/shortcodes/form/view/contact_form_submit.php';
			return ob_get_clean();
			
		}
		
	}
}
