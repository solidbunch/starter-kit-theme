<?php

$options = array(
	array(
		'performance_options_tab' => array(
			'title'   => esc_html__( 'Performance Settings', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(
				'http2' => array(
					'title'   => esc_html__( 'HTTP/2 Preload Options', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'http2_styles_enable' => array(
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for styles', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'HTTP/2 Preload for styles on/off', 'fruitfulblanktextdomain' ),
						),
						'http2_scripts_enable' => array(
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for scripts', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'HTTP/2 Preload for scripts on/off', 'fruitfulblanktextdomain' ),
						),
					)
				),
			)
		)
	)
);
