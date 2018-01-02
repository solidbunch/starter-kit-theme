<?php
/**
 * Reviews post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'bvc' ),
		'type'		=> 'box',
		'options'	=> array(

			'reviews_number'	=> array(
				'label' => esc_html__( 'Reviews count', 'bvc' ),
				'type' => 'text',
			),
			'rating'	=> array(
				'label' => esc_html__( 'Rating', 'bvc' ),
				'type' => 'text',
			),

		) 
	),

);