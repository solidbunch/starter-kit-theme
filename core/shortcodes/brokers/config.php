<?php

vc_map( array(
	'name' => esc_html__( 'Brokers', 'bvc' ),
	'base' => 'bvc_brokers',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add a broker', 'bvc' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Brokers per page', 'bvc' ),
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

	)
));
