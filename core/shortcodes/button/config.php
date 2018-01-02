<?php

vc_map( array(
	'name' => esc_html__( 'Button', 'bvc' ),
	'base' => 'bvc_button',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add a button', 'bvc' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Button title', 'bvc' ),
			'param_name' => 'title',
			'holder' => 'h2',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Button link', 'bvc' ),
			'param_name' => 'link',
			'value' => '',
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__('Icon', 'bvc'),
			'param_name' => 'icon',
			'settings' => array(
				'emptyIcon' => true,
				'type' => 'fontawesome',
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'CSS classes', 'bvc' ),
			'param_name' => 'classes',
			'value' => '',
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Element ID', 'bvc' ),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Button Align', 'bvc'),
			'param_name' => 'button_align',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('Left', 'bvc') => 'left',
				esc_html__('Center', 'bvc') => 'center',
				esc_html__('Right', 'bvc') => 'right',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Button Style', 'bvc'),
			'param_name' => 'button_style',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('White', 'bvc') => 'white',
			),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'Css', 'bvc' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design options', 'bvc' ),
		),


	)
));
