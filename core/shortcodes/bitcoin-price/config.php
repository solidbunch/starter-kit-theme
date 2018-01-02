<?php

vc_map( array(
	'name' => esc_html__( 'Bitcoin Price', 'bvc' ),
	'base' => 'bvc_bitcoin_price',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add Bitcoin Price Info Block', 'bvc' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Percentage of increase for 12 months', 'bvc' ),
			'param_name' => 'ptc',
			'value' => '',
		),

	)
));
