<?php

$options = [
	'details' => [
		'title'   => esc_html__( 'Portfolio Details', 'starter-kit' ),
		'type'    => 'box',
		'options' => [
			
			'images' => [
				'label'       => esc_html__( 'Gallery Images', 'starter-kit' ),
				'type'        => 'multi-upload',
				'images_only' => true,
			],
		
		
		]
	],
];
