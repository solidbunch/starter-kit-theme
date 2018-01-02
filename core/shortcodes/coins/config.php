<?php

vc_map( array(
	'name' => esc_html__( 'Coins', 'bvc' ),
	'base' => 'bvc_coins',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add a grid of coins', 'bvc' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Posts per page', 'bvc' ),
			'param_name' => 'posts_per_page',
			'value' => '8',
			'group' => esc_html__('General', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Posts sorting method', 'bvc'),
			'param_name' => 'order',
			'value' => array(
				esc_html__('Descending', 'bvc') => 'DESC',
				esc_html__('Ascending', 'bvc') => 'ASC',
			),
			'group' => esc_html__('General', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Posts ordering method', 'bvc'),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__('Date', 'bvc') => 'date',
				esc_html__('ID', 'bvc') => 'ID',
				esc_html__('Modified date', 'bvc') => 'modified',
				esc_html__('Title', 'bvc') => 'title',
				esc_html__('Random', 'bvc') => 'rand',
				esc_html__('Menu', 'bvc') => 'menu',
			),
			'group' => esc_html__('General', 'bvc'),
		),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Hide Price and "Buy" button?', 'bvc' ),
            'param_name' => 'is_hidden_price_button',
            'group' => esc_html__('Additional settings', 'bvc'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Show 8 columns in row?', 'bvc' ),
            'param_name' => 'is_eight_in_row',
            'description' => esc_html__( 'Show 8 columns in row. 4 by default.', 'bvc' ),
            'group' => esc_html__('Additional settings', 'bvc'),
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Display load more button', 'bvc' ),
			'param_name' => 'load_more',
			'value' => array( esc_html__( 'Yes', 'bvc' ) => 'yes' ),
            'group' => esc_html__('Additional settings', 'bvc'),

        ),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Load more button text', 'bvc' ),
			'param_name' => 'load_more_text',
			'value' => esc_html__( 'Show more', 'bvc' ),
			'dependency' => array(
				'element' => 'load_more',
				'not_empty' => true,
			),
            'group' => esc_html__('Additional settings', 'bvc'),

        ),

	)
));
