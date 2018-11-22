<?php

return array(
	'name'        => esc_html__( 'Alert', 'starter-kit' ),
	'base'        => 'alert',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'alerts.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add an alert', 'starter-kit' ),
	'params'      => array(

		array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Alert Content', 'starter-kit' ),
			'param_name' => 'content',
			'holder'     => 'h2',
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
			'heading'    => esc_html__( 'Style', 'starter-kit' ),
			'param_name' => 'style',
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

	)
);