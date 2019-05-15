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

						'analytics_code' => [
							'type'  => 'text',
							'label' => esc_html__( 'Analytics Code', 'starter-kit' ),
							'attr'  => [ 'placeholder' => 'UA-XXXXXXXXX-X' ],
							'value' => '',
							'desc'  => __( 'For a better speed performance, please insert the analytics code through the tag manager. Turn on google Analytics Scripts Local Load option' , 'starter-kit' ),
						],

						'analytics_js_lazy_load' => [
							'type'         => 'switch',
							'label'        => __( 'Analytics Scripts Local Load', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Load Tag Manager and Analytics scripts from local directory', 'starter-kit' ),
						],
					
					]
				],
			
			]
		]
	]
];
