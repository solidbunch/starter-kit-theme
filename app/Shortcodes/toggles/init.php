<?php

// Parent element
vc_map( array(
	'name'                    => esc_html__( 'Toggles', 'starter-kit' ),
	'base'                    => 'toggles',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'category'                => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description'             => esc_html__( 'Add accordion / toggles', 'starter-kit' ),
	'as_parent'               => array( 'only' => 'toggle' ),
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => false,
	'js_view'                 => 'VcColumnView',
	'params'                  => array()
) );

// Child element
vc_map( array(
	'name'            => esc_html__( 'Toggle Section', 'starter-kit' ),
	'base'            => 'toggle',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'content_element' => true,
	'as_child'        => array( 'only' => 'toggles' ),
	'params'          => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Text', 'starter-kit' ),
			'param_name' => 'content',
			'value'      => '',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Open by defaults', 'starter-kit' ),
			'param_name' => 'open',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
		),

	)
) );
