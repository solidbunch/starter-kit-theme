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
		
		)
	),

);