<?php

// Parent element
$base_child = ffblank\helper\open_fields::name_fields( dirname( __FILE__ ) );

vc_map( array(
	'name'                    => esc_html__( 'Tabs', 'fruitfulblanktextdomain' ),
	'base'                    => 'tabs',
	'icon'                    => FFBLANK()->config['shortcodes_icon_uri'] . 'tabs.svg',
	'category'                => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description'             => esc_html__( 'Add Tabs', 'fruitfulblanktextdomain' ),
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
			'heading'     => esc_html__( 'Position Tabs', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Please select position', 'fruitfulblanktextdomain' ),
			'param_name'  => 'position',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'Vertical', 'fruitfulblanktextdomain' )   => 'vertical',
				esc_html__( 'Horizontal', 'fruitfulblanktextdomain' ) => 'horizontal',
			),
			'group'       => esc_html__( 'Tabs', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Tabs', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'fruitfulblanktextdomain' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design Options', 'fruitfulblanktextdomain' ),
		),
	),


) );

?>

