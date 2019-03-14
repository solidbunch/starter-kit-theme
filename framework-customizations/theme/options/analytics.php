<?php

$options = [
	[
		'analytics_options_tab' => [
			'title'   => esc_html__( 'Analytics', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [
				
				'google' => [
					'title'   => esc_html__( 'Google', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						
						'tag_manager_code' => [
							'type'  => 'text',
							'label' => esc_html__( 'Tag Manager Code', 'starter-kit' ),
							'attr'  => [ 'placeholder' => 'GTM-XXXXXXX' ],
							'value' => ''
						],
					
					]
				],
			
			]
		]
	]
];
