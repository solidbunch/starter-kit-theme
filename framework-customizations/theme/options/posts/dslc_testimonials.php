<?php
/**
 * Testimonials post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'bvc' ),
		'type'		=> 'box',
		'options'	=> array(

			'name'	=> array(
				'label' => esc_html__( 'Name', 'bvc' ),
				'type' => 'text',
			),
			'position'	=> array(
				'label' => esc_html__( 'Position', 'bvc' ),
				'type' => 'text',
			),

		) 
	),

);