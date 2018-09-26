<?php

vc_map( array(
	'name'        => esc_html__( 'Alert', 'fruitfulblanktextdomain' ),
	'base'        => 'alert',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add an alert', 'fruitfulblanktextdomain' ),
	'params'      => array(

		array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Alert Content', 'fruitfulblanktextdomain' ),
			'param_name' => 'content',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'fruitfulblanktextdomain' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'fruitfulblanktextdomain' ),
			'param_name' => 'classes',
			'value'      => '',
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'fruitfulblanktextdomain' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Primary', 'fruitfulblanktextdomain' )   => 'primary',
				esc_html__( 'Secondary', 'fruitfulblanktextdomain' ) => 'secondary',
				esc_html__( 'Success', 'fruitfulblanktextdomain' )   => 'success',
				esc_html__( 'Danger', 'fruitfulblanktextdomain' )    => 'danger',
				esc_html__( 'Warning', 'fruitfulblanktextdomain' )   => 'warning',
				esc_html__( 'Info', 'fruitfulblanktextdomain' )      => 'info',
				esc_html__( 'Light', 'fruitfulblanktextdomain' )     => 'light',
				esc_html__( 'Dark', 'fruitfulblanktextdomain' )      => 'dark',
			),
		),

	)
) );
