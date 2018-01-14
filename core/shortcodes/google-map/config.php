<?php

vc_map(array(
	'name' => esc_html__('Map', 'fruitfulblanktextdomain'),
	'base' => 'fruitfulblankprefix_map',
	'category' => esc_html__('Theme Elements', 'fruitfulblanktextdomain'),
	'description' => esc_html__('Add Google Map', 'fruitfulblanktextdomain'),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Address', 'fruitfulblanktextdomain'),
			'param_name' => 'address',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Google API Key', 'fruitfulblanktextdomain'),
			'description' => esc_html__('Insert here your Google API Key to avoid request limitations and JavaScript errors.', 'fruitfulblanktextdomain'),
			'param_name' => 'api_key',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Map Height', 'fruitfulblanktextdomain'),
			'param_name' => 'height',
			'value' => '650',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Map zoom', 'fruitfulblanktextdomain'),
			'param_name' => 'zoom',
			'save_always' => true,
			'value' => array(
				'16' => '16',
				'15' => '15',
				'14' => '14',
				'13' => '13',
				'12' => '12',
				'11' => '11',
				'10' => '10',
				'9' => '9',
				'8' => '8',
				'7' => '7',
				'6' => '6',
				'5' => '5',
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1',
			),
		),
		
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Pin Icon', 'fruitfulblanktextdomain'),
			'param_name' => 'pin_icon',
			),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Pin offset X', 'fruitfulblanktextdomain'),
			'param_name' => 'pin_offset_x',
			'value' => 0,
			'default' => 0,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Pin offset Y', 'fruitfulblanktextdomain'),
			'param_name' => 'pin_offset_y',
			'value' => 0,
			'default' => 0,
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Display info window', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window',
			'value' => array(esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_title',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Phone number', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_phone',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Email', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_email',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Address', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_address',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Working hours', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_wh',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Follow Us text', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_follow_us_text',
			'value' => esc_html__('FOLLOW US:', 'fruitfulblanktextdomain'),
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Facebook URL', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_fb_url',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Twitter URL', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_twitter_url',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Google Plus URL', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_google_plus_url',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Linked In URL', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_linkedin_url',
			'value' => '',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Info Window offset X', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_offset_x',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'value' => '',
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Info Window offset Y', 'fruitfulblanktextdomain'),
			'param_name' => 'info_window_offset_y',
			'group' => esc_html__('Info window', 'fruitfulblanktextdomain'),
			'value' => '',
			'dependency' => array(
				'element' => 'info_window',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__('Element ID', 'fruitfulblanktextdomain'),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'description' => esc_html__('Unique identifier of this element', 'fruitfulblanktextdomain'),
		),
	
	)
));
