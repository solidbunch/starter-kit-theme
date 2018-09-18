<?php

$options = array(
	'details' => array(
		'title'   => esc_html__( 'Portfolio Details', 'tttextdomain' ),
		'type'    => 'box',
		'options' => array(
			
			'images' => array(
				'label'       => esc_html__( 'Gallery Images', 'tttextdomain' ),
				'type'        => 'multi-upload',
				'images_only' => true,
			),
		
		
		)
	),
);