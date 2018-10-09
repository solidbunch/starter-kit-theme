<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

				'img_lazy_load_box' => array(
					'title'   => esc_html__( 'Lazy Load Options', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
					
						'img_lazy_load' => array(
							'type'         => 'switch',
							'label'        => __( ' Lazy Load Enable/Disable', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'Lazy Load Images on/off site', 'fruitfulblanktextdomain' ),

						),
						'placeholder_color' => array(
							'type' => 'color-picker',
							'label' => __('Placeholder color', 'fruitfulblanktextdomain'),
							'value' => '#555',
							'desc'         => __( 'Add placeholder color' ),
						),
						'lazy_load_get_sizes_with_getimagesize' => array(
							'type' => 'switch',
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'fruitfulblanktextdomain'),
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'Try to get image sizes with getimagesize() if there is no width and heght attributes.
						 Attantion! php function getimagesize() can significantly slow down your site speed. Use neatly', 'fruitfulblanktextdomain' ),
						),

					)
				),

				'antispam_box' => array(
					'title'   => esc_html__( 'Antispam', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'forms_antispam'	=> array(
							'type'  => 'switch',
							'label' => __('Antispam', 'fruitfulblanktextdomain'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'fruitfulblanktextdomain')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'fruitfulblanktextdomain')
							),
							'desc'  => __('Antispam for all Email Forms', 'fruitfulblanktextdomain'),

						),

					)
				),

				'pingbacks' => array(
					'title'   => esc_html__( 'Ping Backs', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'disable_pingbacks'	=> array(
							'type'  => 'switch',
							'label' => __('Antispam', 'fruitfulblanktextdomain'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'fruitfulblanktextdomain')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'fruitfulblanktextdomain')
							),
							'desc'  => __('Disables trackbacks/pingbacks', 'fruitfulblanktextdomain'),

						),

					)
				),

			)
		)
	)
);
