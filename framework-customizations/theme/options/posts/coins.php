<?php
/**
 * Team members post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'code'	=> array(
				'label' => esc_html__( 'Currency code', 'fruitfulblanktextdomain' ),
				'type' => 'short-text',
			),
			
			'currency_name'	=> array(
				'label' => esc_html__( 'Currency name', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),
			
			'the_coin_margin'	=> array(
				'label' => esc_html__( 'Margin to exchange rate in % ', 'fruitfulblanktextdomain' ),
				'type' => 'short-text',
			),
			
			'only_in_landing' => array(
				'label' => esc_html__( 'Show only in landing page form', 'fruitfulblanktextdomain' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'fruitfulblanktextdomain' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'fruitfulblanktextdomain' )
				),
				'value' => 'no',
				'fw-storage' => array(
					'type' => 'post-meta',
					'post-meta' => 'only_in_landing',
				),
			),
			
		
		)
	),

	'landing' => array(
		'title'		=> esc_html__( 'Landing info', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'landing_title'	=> array(
				'label' => esc_html__( 'Landing title', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),
			'landing_text'	=> array(
				'label' => esc_html__( 'Landing text', 'fruitfulblanktextdomain' ),
				'type' => 'textarea',
			),
			'ptc'	=> array(
				'label' =>  esc_html__( 'Percentage of increase for 12 months', 'fruitfulblanktextdomain' ),
				'type' => 'text',
			),

		
		)
	),

);