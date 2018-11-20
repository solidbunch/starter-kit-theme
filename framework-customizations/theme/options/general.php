<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'starter-kit' ),
			'type'    => 'tab',
			'options' => array(

				'antispam_box' => array(
					'title'   => esc_html__( 'Antispam', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'forms_antispam'	=> array(
							'type'  => 'switch',
							'label' => __('Antispam', 'starter-kit'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'starter-kit')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'starter-kit')
							),
							'desc'  => __('Antispam for all Email Forms', 'starter-kit'),

						),

					)
				),

				'pingbacks' => array(
					'title'   => esc_html__( 'Ping Backs', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'disable_pingbacks'	=> array(
							'type'  => 'switch',
							'label' => __('Trackbacks/Pingbacks', 'starter-kit'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'starter-kit')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'starter-kit')
							),
							'desc'  => __('Disables trackbacks/pingbacks', 'starter-kit'),

						),

					)
				),

			)
		)
	)
);
