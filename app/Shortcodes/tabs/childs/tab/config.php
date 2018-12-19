<?php
return [
	'name'            => esc_html__( 'Tab', 'starter-kit' ),
	'base'            => 'tab',
	'content_element' => true,
	'as_child'        => [ 'only' => 'tabs'	],
	'params'          => [
		[
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		],
		[
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Text', 'starter-kit' ),
			'param_name'  => 'content',
			'value'       => '',
			'description' => esc_html__( 'Enter your content.', 'starter-kit' )
		],
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'starter-kit' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		)
	]
];



