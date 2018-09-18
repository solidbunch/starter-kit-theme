<?php

vc_map( array(
	'name'        => esc_html__( 'Button', 'tttextdomain' ),
	'base'        => 'button',
	'category'    => esc_html__( 'Theme Elements', 'tttextdomain' ),
	'description' => esc_html__( 'Add a button', 'tttextdomain' ),
	'params'      => array(
		
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button title', 'tttextdomain' ),
			'param_name' => 'title',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button link', 'tttextdomain' ),
			'param_name' => 'link',
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
			'heading'    => esc_html__( 'Button Align', 'tttextdomain' ),
			'param_name' => 'button_align',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'Left', 'tttextdomain' )        => 'left',
				esc_html__( 'Center', 'tttextdomain' )      => 'center',
				esc_html__( 'Right', 'tttextdomain' )       => 'right',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Size', 'tttextdomain' ),
			'param_name' => 'button_size',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'Small', 'tttextdomain' )       => 'btn-sm',
				esc_html__( 'Large', 'tttextdomain' )       => 'btn-lg',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Style', 'tttextdomain' ),
			'param_name' => 'button_style',
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
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Outline', 'tttextdomain' ),
			'param_name' => 'outline',
			'value'      => array(
				esc_html__( 'No', 'tttextdomain' )  => '',
				esc_html__( 'Yes', 'tttextdomain' ) => 'yes',
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'tttextdomain' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'tttextdomain' ),
		),
	
	
	)
) );
