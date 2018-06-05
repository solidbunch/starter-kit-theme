<?php

$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Portfolio Details', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'images'	=> array(
				'label' => esc_html__( 'Gallery Images', 'fruitfulblanktextdomain' ),
				'type'  => 'multi-upload',
				'images_only' => true,
			),


		)
	),
);