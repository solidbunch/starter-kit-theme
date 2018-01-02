<?php

vc_map( array(
	'name' => esc_html__( 'Benefits v2', 'bvc' ),
	'base' => 'bvc_benefits_v2',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add a benefit', 'bvc' ),
	'params' => array(

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Icon', 'bvc' ),
			'param_name' => 'image',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'bvc' ),
			'param_name' => 'title',
			'holder' => 'h2',
			'value' => '',
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Content', 'bvc' ),
			'param_name' => 'content',
			'value' => '',
		),

	)
));
