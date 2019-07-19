<?php

$options = [
	[
		'performance_options_tab' => [
			'title'   => esc_html__( 'Performance', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [
				
				'img_lazy_load_box' => [
					'title'   => esc_html__( 'Images Lazy Load Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						
						'img_lazy_load'                         => [
							'type'         => 'switch',
							'label'        => __( 'Lazy Load', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Lazy Load Images on/off', 'starter-kit' ),
						
						],
						'lazy_img_min_width'                    => [
							'type'  => 'text',
							'label' => esc_html__( 'Image min width (px)', 'starter-kit' ),
							'value' => '24'
						],
						'lazy_img_min_height'                   => [
							'type'  => 'text',
							'label' => esc_html__( 'Image min height (px)', 'starter-kit' ),
							'value' => '24'
						],
						'placeholder_color'                     => [
							'type'  => 'color-picker',
							'label' => __( 'Placeholder color', 'starter-kit' ),
							'value' => '#555',
							'desc'  => __( 'Image preloader color', 'starter-kit' ),
						],
						'lazy_load_get_sizes_with_getimagesize' => [
							'type'         => 'switch',
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' ),
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Try to get image sizes with getimagesize() if there is no width and heght attributes.
						 Attantion! php function getimagesize() can significantly slow down your site speed. Use neatly', 'starter-kit' ),
						],
					
					]
				],
				
				'http2'   => [
					'title'   => esc_html__( 'HTTP/2 Preload Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						'http2_styles_enable'  => [
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for styles', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'HTTP/2 Preload for styles on/off', 'starter-kit' ),
						],
						'http2_scripts_enable' => [
							'type'         => 'switch',
							'label'        => __( 'Enable/Disable HTTP/2 Preload for scripts', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'HTTP/2 Preload for scripts on/off', 'starter-kit' ),
						],
					]
				],
				'wp_head' => [
					'title'   => esc_html__( 'WP Head Options', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						'clean_wp_head' => [
							'type'         => 'switch',
							'label'        => __( 'Clean Up WP head', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Remove unnecessary link\'s ,Remove inline CSS and JS from WP emoji support, Remove inline CSS used by Recent Comments widget, Remove inline CSS used by posts with galleries, Remove self-closing tag', 'starter-kit' ),
						],
					]
				],

				'assets'  => [
					'title'   => esc_html__( 'HTML/Js/Css additional', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [

						'add_embed_wrap' => [
							'type'         => 'switch',
							'label'        => __( 'Add wrapper to embed code', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Enclose embedded media in a &lt;div class=&quot;embed-wrapper&quot;&gt;', 'starter-kit' ),
						],

						'remove_self_closing_tags' => [
							'type'         => 'switch',
							'label'        => __( 'Remove self closing tags', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'In HTML5 it is not strictly necessary to close certain HTML tags. &lt;img /&gt;, &lt;input /&gt; etc.', 'starter-kit' ),
						],

						'scripts_styles_cleanup' => [
							'type'         => 'switch',
							'label'        => __( 'Clean scripts & styles', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Remove unnecessary "type=", "id=", "media=" attributes', 'starter-kit' ),
						],

						'assets_versions' => [
							'type'         => 'switch',
							'label'        => __( 'Remove Versions', 'starter-kit' ),
							'right-choice' => [
								'value' => '1',
								'label' => __( 'Yes', 'starter-kit' )
							],
							'left-choice'  => [
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'starter-kit' )
							],
							'desc'         => __( 'Resources with a "?" in the URL are not cached by some proxy caching servers.', 'starter-kit' ),
						],
					]
				],
			]
		]
	]
];
