<?php

return array(
	'name'            => esc_html__( 'Form File Uploader', 'starter-kit' ),
	'base'            => 'form_file_uploader',
	'icon'            => Starter_Kit()->config['shortcodes_icon_uri'] . 'file.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'starter-kit' ),
	'as_child'        => array(
		'only' => 'contact_form,vc_column_inner'
	),
	'params'          => array(
			
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'starter-kit' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'starter-kit' ),
			'param_name'  => 'label',
			'holder'	  => 'h2',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'starter-kit' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'starter-kit' ),
			'param_name'  => 'placeholder',
			'value'       => '',
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Used in "name" attribute', 'starter-kit' ),
		),	
	)
);