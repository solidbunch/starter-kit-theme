<?php

use StarterKit\Helper\Utils;

return [
	'name'        => esc_html__( 'Button', 'starter-kit' ),
	'base'        => 'button',
	'icon'        => Utils::getConfigSetting( 'shortcodes_icon_uri' ) . 'button.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add a button', 'starter-kit' ),
	'params'      => [
		
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button title', 'starter-kit' ),
			'param_name' => 'title',
			'holder'     => 'h2',
			'value'      => '',
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button link', 'starter-kit' ),
			'param_name' => 'link',
			'value'      => '',
		],
		[
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'starter-kit' ),
			'param_name' => 'icon',
			'settings'   => [
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			]
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'classes',
			'value'      => '',
		],
		[
			'type'       => 'el_id',
			'heading'    => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name' => 'el_id',
			'settings'   => [
				'auto_generate' => true,
			],
		],
		[
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Align', 'starter-kit' ),
			'param_name' => 'button_align',
			'value'      => [
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Left', 'starter-kit' )        => 'left',
				esc_html__( 'Center', 'starter-kit' )      => 'center',
				esc_html__( 'Right', 'starter-kit' )       => 'right',
			],
		],
		[
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Size', 'starter-kit' ),
			'param_name' => 'button_size',
			'value'      => [
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Small', 'starter-kit' )       => 'btn-sm',
				esc_html__( 'Large', 'starter-kit' )       => 'btn-lg',
			],
		],
		[
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Style', 'starter-kit' ),
			'param_name' => 'button_style',
			'value'      => [
				esc_html__( 'Primary', 'starter-kit' )   => 'primary',
				esc_html__( 'Secondary', 'starter-kit' ) => 'secondary',
				esc_html__( 'Success', 'starter-kit' )   => 'success',
				esc_html__( 'Danger', 'starter-kit' )    => 'danger',
				esc_html__( 'Warning', 'starter-kit' )   => 'warning',
				esc_html__( 'Info', 'starter-kit' )      => 'info',
				esc_html__( 'Light', 'starter-kit' )     => 'light',
				esc_html__( 'Dark', 'starter-kit' )      => 'dark',
			],
		],
		[
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Outline', 'starter-kit' ),
			'param_name' => 'outline',
			'value'      => [
				esc_html__( 'No', 'starter-kit' )  => '',
				esc_html__( 'Yes', 'starter-kit' ) => 'yes',
			],
		],
		[
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS', 'starter-kit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'starter-kit' ),
		],
	
	
	]
];
