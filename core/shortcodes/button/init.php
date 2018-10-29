<?php

vc_map( array(
	'name'        => esc_html__( 'Button', 'fruitfulblanktextdomain' ),
	'base'        => 'button',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'button.svg',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add a button', 'fruitfulblanktextdomain' ),
	'params'      => array(

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button title', 'fruitfulblanktextdomain' ),
			'param_name' => 'title',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button link', 'fruitfulblanktextdomain' ),
			'param_name' => 'link',
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
			'heading'    => esc_html__( 'Button Align', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_align',
			'value'      => array(
				esc_html__( '- Default -', 'fruitfulblanktextdomain' ) => '',
				esc_html__( 'Left', 'fruitfulblanktextdomain' )        => 'left',
				esc_html__( 'Center', 'fruitfulblanktextdomain' )      => 'center',
				esc_html__( 'Right', 'fruitfulblanktextdomain' )       => 'right',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Size', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_size',
			'value'      => array(
				esc_html__( '- Default -', 'fruitfulblanktextdomain' ) => '',
				esc_html__( 'Small', 'fruitfulblanktextdomain' )       => 'btn-sm',
				esc_html__( 'Large', 'fruitfulblanktextdomain' )       => 'btn-lg',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Style', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_style',
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
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Outline', 'fruitfulblanktextdomain' ),
			'param_name' => 'outline',
			'value'      => array(
				esc_html__( 'No', 'fruitfulblanktextdomain' )  => '',
				esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes',
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'fruitfulblanktextdomain' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'fruitfulblanktextdomain' ),
		),


	)
) );
