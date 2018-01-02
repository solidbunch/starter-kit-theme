<?php

vc_map( array(
	'name' => esc_html__( 'Benefits v2', 'fruitfulblanktextdomain' ),
	'base' => 'bvc_benefits_v2',
	'category' => esc_html__( 'BVC Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add a benefit', 'fruitfulblanktextdomain' ),
	'params' => array(

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Icon', 'fruitfulblanktextdomain' ),
			'param_name' => 'image',
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'fruitfulblanktextdomain' ),
			'param_name' => 'title',
			'holder' => 'h2',
			'value' => '',
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Content', 'fruitfulblanktextdomain' ),
			'param_name' => 'content',
			'value' => '',
		),

	)
));
