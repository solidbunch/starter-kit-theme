<?php

require_once 'shortcode.php';

// Parent element
vc_map( array(
	'name' => esc_html__( 'Toggles', 'fruitfulblanktextdomain' ),
	'base' => 'toggles',
	'category' => esc_html__( 'Content Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add accordion / toggles', 'fruitfulblanktextdomain' ),
	'as_parent' => array( 'only' => 'toggle' ),
	'content_element' => true,
	'is_container' => true,
	'show_settings_on_create' => false,
	'js_view' => 'VcColumnView',
	'params' => array(



	)
));

// Child element
vc_map( array(
	'name' => esc_html__( 'Toggle Section', 'fruitfulblanktextdomain' ),
	'base' => 'toggle',
	'content_element' => true,
	'as_child' => array( 'only' => 'toggles' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'fruitfulblanktextdomain' ),
			'param_name' => 'title',
			'value' => '',
			'admin_label' => true,
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Text', 'fruitfulblanktextdomain' ),
			'param_name' => 'content',
			'value' => '',
		),
    array(
      'type' => 'checkbox',
      'heading' => esc_html__( 'Open by defaults', 'fruitfulblanktextdomain' ),
      'param_name' => 'open',
      'value' => array( esc_html__( 'Yes', 'wplab-albedo-core-plugin' ) => 'yes' ),
    ),

	)
));
