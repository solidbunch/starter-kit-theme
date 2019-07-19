<?php

$options = [
	[
		'footer_options_tab' => [
			'title'   => esc_html__( 'Footer', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [
				
				'bottom_bar-settings-box' => [
					'title'   => esc_html__( 'Bottom Bar', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						
						'bottom_bar_text' => [
							'type'  => 'text',
							'label' => esc_html__( 'Bottom bar text', 'starter-kit' ),
							'value' => '{year} &copy; Copyright'
						],
					
					]
				],
			
			]
		]
	]
];
