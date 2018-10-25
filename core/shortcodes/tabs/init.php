<?php

// Parent element
$base_child = ffblank\helper\open_fields::name_fields( dirname( __FILE__ ) );

vc_map( array(
	'name'                    => esc_html__( 'Tabs', 'fruitfulblanktextdomain' ),
	'base'                    => 'tabs',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'tabs.svg',
	'category'                => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description'             => esc_html__( 'Add tabs / toggles', 'fruitfulblanktextdomain' ),
	'as_parent'               => array( 'only' => $base_child ),
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => true,
	'js_view'                 => is_admin() ? 'VcColumnView' : '',
	'params'                  => array(

		/**
		 *  Form tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Vertical', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'The form will be sent to this email address.', 'fruitfulblanktextdomain '),
			'param_name'  => 'position',
			'save_always' => true,
			'value'       => get_option( 'admin_email' ),
			'group'       => esc_html__( 'Form', 'fruitfulblanktextdomain' ),
		)	
	),
) );