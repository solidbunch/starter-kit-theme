<?php

// Parent element
$base_child = StarterKit\Helper\OpenFields::name_fields( dirname( __FILE__ ) );

vc_map( array(
	'name'                    => esc_html__( 'Tabs', 'starter-kit' ),
	'base'                    => 'tabs',
	'icon'                    => Starter_Kit()->config['shortcodes_icon_uri'] . 'tabs.svg',
	'category'                => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description'             => esc_html__( 'Add Tabs', 'starter-kit' ),
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
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Position Tabs', 'starter-kit' ),
			'description' => esc_html__( 'Please select position', 'starter-kit' ),
			'param_name'  => 'position',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'Vertical', 'starter-kit' )   => 'vertical',
				esc_html__( 'Horizontal', 'starter-kit' ) => 'horizontal',
			),
			'group'       => esc_html__( 'Tabs', 'starter-kit' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Tabs', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		),
//		array(
//			'type'       => 'css_editor',
//			'heading'    => esc_html__( 'CSS box', 'starter-kit' ),
//			'param_name' => 'css',
//			'group'      => esc_html__( 'Design Options', 'starter-kit' ),
//		),
	),


) );

?>

