<?php
/**
 * Team members post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'position'	=> array(
				'label' => esc_html__( 'Position', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),
			'email'	=> array(
				'label' => esc_html__( 'Email', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),
			'phone'	=> array(
				'label' => esc_html__( 'Phone', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),

		) 
	),

);