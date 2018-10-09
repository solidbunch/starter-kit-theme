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
				'wp_head' => array(
					'title'   => esc_html__( 'WP Head Options', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'clean_wp_head' => array(
							'type'         => 'switch',
							'label'        => __( 'Clen Up WP head', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'Remove unnecessary link\'s ,Remove inline CSS and JS from WP emoji support, Remove inline CSS used by Recent Comments widget, Remove inline CSS used by posts with galleries, Remove self-closing tag', 'fruitfulblanktextdomain' ),
						),
					)
				),
				'assets' => array(
					'title'   => esc_html__( 'Js/Css additional', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'assets_versions' => array(
							'type'         => 'switch',
							'label'        => __( 'Remove Versions', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'Resources with a "?" in the URL are not cached by some proxy caching servers.', 'fruitfulblanktextdomain' ),
						),
					)
				),
			)
		)
	)
);
