<?php

return array(
	'name'            => esc_html__( 'Form Submit', 'starter-kit' ),
	'base'            => 'form_submit',
	'icon'            => Starter_Kit()->config['shortcodes_icon_uri'] . 'enter.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'starter-kit' ),
	'as_child'        => array(
		'only' => 'contact_form, vc_column_inner'
	),
	'params'          => array(
		
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label', 'starter-kit' ),
			'description' => esc_html__( 'This text will appear in submit button', 'starter-kit' ),
			'param_name'  => 'submit_button_text',
			'holder'	  => 'h2',
			'value'       => esc_html__( 'Send', 'starter-kit' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Align', 'starter-kit' ),
			'param_name'  => 'align',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'None', 'wplab-bvc-core' )   => '',
				esc_html__( 'Left', 'wplab-bvc-core' )   => 'left',
				esc_html__( 'Center', 'wplab-bvc-core' ) => 'center',
				esc_html__( 'Right', 'wplab-bvc-core' )  => 'right',
			),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Button ID', 'starter-kit' ),
			'description' => esc_html__( 'Here you can set unique identifier for this button', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'value'       => '',
		),	
	)
);