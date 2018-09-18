<?php

vc_map( array(
	'name'        => esc_html__( 'Alert', 'tttextdomain' ),
	'base'        => 'alert',
	'category'    => esc_html__( 'Theme Elements', 'tttextdomain' ),
	'description' => esc_html__( 'Add an alert', 'tttextdomain' ),
	'params'      => array(
		
		array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Alert Content', 'tttextdomain' ),
			'param_name' => 'content',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'tttextdomain' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'tttextdomain' ),
			'param_name' => 'classes',
			'value'      => '',
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'Element ID', 'tttextdomain' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'tttextdomain' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Primary', 'tttextdomain' )   => 'primary',
				esc_html__( 'Secondary', 'tttextdomain' ) => 'secondary',
				esc_html__( 'Success', 'tttextdomain' )   => 'success',
				esc_html__( 'Danger', 'tttextdomain' )    => 'danger',
				esc_html__( 'Warning', 'tttextdomain' )   => 'warning',
				esc_html__( 'Info', 'tttextdomain' )      => 'info',
				esc_html__( 'Light', 'tttextdomain' )     => 'light',
				esc_html__( 'Dark', 'tttextdomain' )      => 'dark',
			),
		),
	
	)
) );
