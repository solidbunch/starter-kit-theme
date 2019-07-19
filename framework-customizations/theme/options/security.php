<?php

$options = [
	[
		'security_options_tab' => [
			'title'   => esc_html__( 'Security', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [

				'antispam_box' => [
					'title'   => esc_html__( 'Antispam', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [

						'forms_antispam' => [
							'type'         => 'switch',
							'label'        => __( 'Antispam', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Antispam for all Email Forms', 'starter-kit' ),

						],

					]
				],

			]
		]
	]
];
