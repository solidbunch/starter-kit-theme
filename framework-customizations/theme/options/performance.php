<?php

$options = array(
	array(
		'performance_options_tab' => array(
			'title'   => esc_html__( 'Performance Settings', 'starter-kit' ),
			'type'    => 'tab',
			'options' => array(

				'img_lazy_load_box' => array(
					'title'   => esc_html__( 'Lazy Load Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'img_lazy_load' => array(
							'type'         => 'switch',
							'label'        => __( 'Lazy Load', 'starter-kit' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'Lazy Load Images on/off', 'starter-kit' ),

						),
						'lazy_img_min_width' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Image min width (px)', 'starter-kit' ),
							'value' => '24'
						),
						'lazy_img_min_height' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Image min height (px)', 'starter-kit' ),
							'value' => '24'
						),
						'placeholder_color' => array(
							'type' => 'color-picker',
							'label' => __('Placeholder color', 'starter-kit' ),
							'value' => '#555',
							'desc'  => __( 'Image preloader color' , 'starter-kit' ),
						),
						'lazy_load_get_sizes_with_getimagesize' => array(
							'type' => 'switch',
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'starter-kit'),
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'Try to get image sizes with getimagesize() if there is no width and heght attributes.
						 Attantion! php function getimagesize() can significantly slow down your site speed. Use neatly', 'starter-kit' ),
						),

					)
				),

				'http2' => array(
					'title'   => esc_html__( 'HTTP/2 Preload Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'http2_styles_enable' => array(
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for styles', 'starter-kit' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'HTTP/2 Preload for styles on/off', 'starter-kit' ),
						),
						'http2_scripts_enable' => array(
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for scripts', 'starter-kit' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'HTTP/2 Preload for scripts on/off', 'starter-kit' ),
						),
					)
				),
				'wp_head' => array(
					'title'   => esc_html__( 'WP Head Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'clean_wp_head' => array(
							'type'         => 'switch',
							'label'        => __( 'Clen Up WP head', 'starter-kit' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'Remove unnecessary link\'s ,Remove inline CSS and JS from WP emoji support, Remove inline CSS used by Recent Comments widget, Remove inline CSS used by posts with galleries, Remove self-closing tag', 'starter-kit' ),
						),
					)
				),
				'assets' => array(
					'title'   => esc_html__( 'Js/Css additional', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						'assets_versions' => array(
							'type'         => 'switch',
							'label'        => __( 'Remove Versions', 'starter-kit' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							),
							'desc'         => __( 'Resources with a "?" in the URL are not cached by some proxy caching servers.', 'starter-kit' ),
						),
					)
				),
			)
		)
	)
);
