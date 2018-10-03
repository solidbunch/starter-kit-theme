<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

				'img_lazy_load_box' => array(
					'title'   => esc_html__( 'Extra', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'img_lazy_load' => array(
							'type'         => 'switch',
							'label'        => __( 'Lazy Load Images', 'fruitfulblanktextdomain' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'fruitfulblanktextdomain' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'fruitfulblanktextdomain' )
							),
							'desc'         => __( 'Lazy Load Images on site', 'fruitfulblanktextdomain' ),

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

			)
		)
	)
);
