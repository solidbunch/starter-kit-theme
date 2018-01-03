<?php

vc_map(array(
	'name' => esc_html__('Checkbox Field', 'fruitfulblanktextdomain'),
	'base' => 'fruitfulblankprefix_contact_form_checkbox',
	'content_element' => true,
	'category' => esc_html__('Form Fields', 'fruitfulblanktextdomain'),
	'as_child' => array('only' => 'fruitfulblankprefix_contact_form,vc_column_inner'),
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
			'type' => 'checkbox',
			'heading' => esc_html__('Mandatory Field', 'fruitfulblanktextdomain'),
			'description' => esc_html__('Make this field mandatory?', 'fruitfulblanktextdomain'),
			'param_name' => 'required',
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
	class WPBakeryShortCode_fruitfulblankprefix_Contact_Form_Checkbox extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null){
			
			$atts = vc_map_get_attributes($this->getShortcode(), $atts);

			$attributes = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';

			if (filter_var($atts['required'], FILTER_VALIDATE_BOOLEAN)) {
				$attributes[] = 'required="required"';
			}			
			
			ob_start();
			require get_template_directory() . '/core/shortcodes/form/view/contact_form_checkbox.php';
			return ob_get_clean();
			
		}
		
	}
}
