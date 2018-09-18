<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title' => esc_html__( 'Base Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'img_lazy_load_box' => array(
					'title'   => esc_html__( 'Extra', 'tttextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'img_lazy_load'	=> array(
							'type'  => 'switch',
							'label' => __('Lazy Load Images', 'tttextdomain'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'tttextdomain')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'tttextdomain')
							),
							'desc'  => __('Lazy Load Images on site', 'tttextdomain'),
						
						),
					
					)
				),

			)
		)
	)
);