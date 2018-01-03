<?php

vc_map( array(
	'name' => esc_html__( 'Coins', 'fruitfulblanktextdomain' ),
	'base' => 'fruitfulblankprefix_coins',
	'category' => esc_html__( 'BVC Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add a grid of coins', 'fruitfulblanktextdomain' ),
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
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Hide Price and "Buy" button?', 'fruitfulblanktextdomain' ),
            'param_name' => 'is_hidden_price_button',
            'group' => esc_html__('Additional settings', 'fruitfulblanktextdomain'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Show 8 columns in row?', 'fruitfulblanktextdomain' ),
            'param_name' => 'is_eight_in_row',
            'description' => esc_html__( 'Show 8 columns in row. 4 by default.', 'fruitfulblanktextdomain' ),
            'group' => esc_html__('Additional settings', 'fruitfulblanktextdomain'),
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Display load more button', 'fruitfulblanktextdomain' ),
			'param_name' => 'load_more',
			'value' => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
            'group' => esc_html__('Additional settings', 'fruitfulblanktextdomain'),

        ),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Load more button text', 'fruitfulblanktextdomain' ),
			'param_name' => 'load_more_text',
			'value' => esc_html__( 'Show more', 'fruitfulblanktextdomain' ),
			'dependency' => array(
				'element' => 'load_more',
				'not_empty' => true,
			),
            'group' => esc_html__('Additional settings', 'fruitfulblanktextdomain'),

        ),

	)
));
