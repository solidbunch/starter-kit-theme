<?php

$options = array(
	'details' => array(
		'title'   => esc_html__( 'Portfolio Details', 'starter-kit' ),
		'type'    => 'box',
		'options' => array(

			'images' => array(
				'label'       => esc_html__( 'Gallery Images', 'starter-kit' ),
				'type'        => 'multi-upload',
				'images_only' => true,
			),


		)
	),
);
