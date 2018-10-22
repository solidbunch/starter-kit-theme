<?php

/** list fields base **/
$base_child = ffblank\helper\open_fields::name_fields( dirname( __FILE__ ) );

vc_map(array(
	'name'                    => esc_html__( 'Contact Form', 'fruitfulblanktextdomain' ),
	'base'                    => 'shortcode_contact_form',
	'category'                => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description'             => esc_html__( 'Add contact form', 'fruitfulblanktextdomain' ),
	'as_parent'               => array(
		'only' =>  $base_child  . 'vc_column_text, heading, vc_row' ),
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => true,
	'js_view'                 => is_admin() ? 'VcColumnView' : '',
	'params'                  => array(
		
		/**
		 *  Form tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Email To', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'The form will be sent to this email address.', 'fruitfulblanktextdomain '),
			'param_name'  => 'email_to',
			'save_always' => true,
			'value'       => get_option( 'admin_email' ),
			'group'       => esc_html__( 'Form', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Subject Message', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will be used as subject message for the email', 'fruitfulblanktextdomain' ),
			'param_name'  => 'subject_message',
			'value'       => esc_html__( 'New message', 'fruitfulblanktextdomain' ),
			'group'       => esc_html__( 'Form', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Form', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'fruitfulblanktextdomain' ),
		),
		/**
		 *  Redirect tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Redirect on success', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Type here any URL where user will be redirected after form submit, e.g. to the Thank You page.', 'fruitfulblanktextdomain' ),
			'param_name'  => 'redirect_on_success',
			'value'       => '',
			'group'       => esc_html__( 'Redirect', 'fruitfulblanktextdomain' ),
		),
		
		/**
		 * Messages tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Success Message', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will be displayed when the form will successfully send', 'fruitfulblanktextdomain' ),
			'param_name'  => 'success_message',
			'value'       => esc_html__( 'Message sent!', 'fruitfulblanktextdomain' ),
			'group'       => esc_html__( 'Messages', 'fruitfulblanktextdomain' ),
		),	
		
	)
));
