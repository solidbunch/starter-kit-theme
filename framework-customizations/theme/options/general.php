<?php

$options = [
	[
		'base_options_tab' => [
			'title'   => esc_html__( 'General', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [
				
				'header_box' => [
					'title'   => esc_html__( 'Header', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [

						'fixed_header' => [
							'type'         => 'switch',
							'label'        => __( 'Fixed header', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Fix header top', 'starter-kit' ),

						],
					
					]
				],

			]
		]
	]
];
