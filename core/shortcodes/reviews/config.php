<?php

vc_map( array(
	'name' => esc_html__( 'Reviews', 'fruitfulblanktextdomain' ),
	'base' => 'fruitfulblankprefix_reviews',
	'category' => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add reviews carousel', 'fruitfulblanktextdomain' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Posts per page', 'fruitfulblanktextdomain' ),
			'param_name' => 'posts_per_page',
			'value' => '8',
			'group' => esc_html__('General', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Posts sorting method', 'fruitfulblanktextdomain'),
			'param_name' => 'order',
			'value' => array(
				esc_html__('Descending', 'fruitfulblanktextdomain') => 'DESC',
				esc_html__('Ascending', 'fruitfulblanktextdomain') => 'ASC',
			),
			'group' => esc_html__('General', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Posts ordering method', 'fruitfulblanktextdomain'),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__('Date', 'fruitfulblanktextdomain') => 'date',
				esc_html__('ID', 'fruitfulblanktextdomain') => 'ID',
				esc_html__('Modified date', 'fruitfulblanktextdomain') => 'modified',
				esc_html__('Title', 'fruitfulblanktextdomain') => 'title',
				esc_html__('Random', 'fruitfulblanktextdomain') => 'rand',
				esc_html__('Menu', 'fruitfulblanktextdomain') => 'menu',
			),
			'group' => esc_html__('General', 'fruitfulblanktextdomain'),
		),

	)
));
