<?php

vc_map( array(
	'name'        => esc_html__( 'Pricing Table', 'fruitfulblanktextdomain' ),
	'base'        => 'pricing_table',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Param Group', 'fruitfulblanktextdomain' ),
	'params'      => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Border Color',
			'param_name' => 'border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Border Radius',
			'param_name' => 'border_radius',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Border Width',
			'param_name' => 'border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Heading Background Color',
			'param_name' => 'header_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Heading Text Color',
			'param_name' => 'header_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Button Background Color',
			'param_name' => 'button_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Button Hover Background Color',
			'param_name' => 'button_hover_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Button Text Color',
			'param_name' => 'button_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Button Hover Text Color',
			'param_name' => 'button_hover_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Button Border Width',
			'param_name' => 'button_border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => 'Button Border Color',
			'param_name' => 'button_border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'param_group',
			'heading'    => 'Columns',
			'param_name' => 'columns',
			'value'      => '',
			'group'      => esc_html__( 'Columns', 'fruitfulblanktextdomain' ),
			'params'     => array(
				array(
					'type'       => 'textfield',
					'heading'    => 'Title',
					'param_name' => 'title',
					'value'      => '',
				),
				array(
					'type'       => 'exploded_textarea',
					'heading'    => 'Features',
					'param_name' => 'features',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Currency',
					'param_name' => 'currency',
					'value'      => '$',
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Price',
					'param_name' => 'price',
					'value'      => '',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => 'Period',
					'param_name' => 'period',
					'value'      => array(
						"Per Day" => "per<br>day",
						"Per Week" => "per<br>week",
						"Per Month" => "per<br>month",
						"Per Year" => "per<br>year",
						"Forever" => "forever"
					)
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Button URL',
					'param_name' => 'button_url',
					'value'      => '#',
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Button Title',
					'param_name' => 'button_title',
					'value'      => '',
				)
			)
		)
	)
) );
