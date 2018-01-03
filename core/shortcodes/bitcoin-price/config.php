<?php

vc_map( array(
	'name' => esc_html__( 'Bitcoin Price', 'fruitfulblanktextdomain' ),
	'base' => 'fruitfulblankprefix_bitcoin_price',
	'category' => esc_html__( 'BVC Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add Bitcoin Price Info Block', 'fruitfulblanktextdomain' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Percentage of increase for 12 months', 'fruitfulblanktextdomain' ),
			'param_name' => 'ptc',
			'value' => '',
		),

	)
));
