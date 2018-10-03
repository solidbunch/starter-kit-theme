<?php

$options = array(
	array(
		'footer_options_tab' => array(
			'title'   => esc_html__( 'Footer', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

				'bottom_bar-settings-box' => array(
					'title'   => esc_html__( 'Bottom Bar', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'bottom_bar_text' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Bottom bar text', 'fruitfulblanktextdomain' ),
							'value' => ''
						),

					)
				),

			)
		)
	)
);
