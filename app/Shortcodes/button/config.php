<?php

return array(
	'name'        => esc_html__( 'Button', 'starter-kit' ),
	'base'        => 'button',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'button.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add a button', 'starter-kit' ),
	'params'      => array(

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button title', 'starter-kit' ),
			'param_name' => 'title',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button link', 'starter-kit' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'starter-kit' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'classes',
			'value'      => '',
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Align', 'starter-kit' ),
			'param_name' => 'button_align',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Left', 'starter-kit' )        => 'left',
				esc_html__( 'Center', 'starter-kit' )      => 'center',
				esc_html__( 'Right', 'starter-kit' )       => 'right',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Size', 'starter-kit' ),
			'param_name' => 'button_size',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Small', 'starter-kit' )       => 'btn-sm',
				esc_html__( 'Large', 'starter-kit' )       => 'btn-lg',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Style', 'starter-kit' ),
			'param_name' => 'button_style',
			'value'      => array(
				esc_html__( 'Primary', 'starter-kit' )   => 'primary',
				esc_html__( 'Secondary', 'starter-kit' ) => 'secondary',
				esc_html__( 'Success', 'starter-kit' )   => 'success',
				esc_html__( 'Danger', 'starter-kit' )    => 'danger',
				esc_html__( 'Warning', 'starter-kit' )   => 'warning',
				esc_html__( 'Info', 'starter-kit' )      => 'info',
				esc_html__( 'Light', 'starter-kit' )     => 'light',
				esc_html__( 'Dark', 'starter-kit' )      => 'dark',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Outline', 'starter-kit' ),
			'param_name' => 'outline',
			'value'      => array(
				esc_html__( 'No', 'starter-kit' )  => '',
				esc_html__( 'Yes', 'starter-kit' ) => 'yes',
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS', 'starter-kit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'starter-kit' ),
		),


	)
);
