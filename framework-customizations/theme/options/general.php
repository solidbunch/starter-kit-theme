<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

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
							'label' => __('Trackbacks/Pingbacks', 'fruitfulblanktextdomain'),
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
