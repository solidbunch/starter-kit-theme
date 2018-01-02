<?php
/**
 * Team members post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'bvc' ),
		'type'		=> 'box',
		'options'	=> array(

			'position'	=> array(
				'label' => esc_html__( 'Position', 'bvc' ),
				'type' => 'text',
			),
			'email'	=> array(
				'label' => esc_html__( 'Email', 'bvc' ),
				'type' => 'text',
			),
			'phone'	=> array(
				'label' => esc_html__( 'Phone', 'bvc' ),
				'type' => 'text',
			),

		) 
	),

);