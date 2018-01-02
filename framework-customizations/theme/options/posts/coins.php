<?php
/**
 * Team members post type options array
 **/
$options = array(
	'details' => array(
		'title'		=> esc_html__( 'Details', 'bvc' ),
		'type'		=> 'box',
		'options'	=> array(

			'code'	=> array(
				'label' => esc_html__( 'Currency code', 'bvc' ),
				'type' => 'short-text',
			),
			
			'currency_name'	=> array(
				'label' => esc_html__( 'Currency name', 'bvc' ),
				'type' => 'text',
			),
			
			'the_coin_margin'	=> array(
				'label' => esc_html__( 'Margin to exchange rate in % ', 'bvc' ),
				'type' => 'short-text',
			),
		
		)
	),

);