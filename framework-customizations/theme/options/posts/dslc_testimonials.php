<?php
/**
 * Testimonials post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'name'	=> array(
				'label' => esc_html__( 'Name', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),
			'position'	=> array(
				'label' => esc_html__( 'Position', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),

		) 
	),

);