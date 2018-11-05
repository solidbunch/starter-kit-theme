<?php

vc_map( array(
	'name'        => esc_html__( 'Pricing Table', 'fruitfulblanktextdomain' ),
	'base'        => 'pricing_table',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Param Group', 'fruitfulblanktextdomain' ),
	'params'      => array(

		/**
		 * Columns Repeater (to manage columns data)
		 */

		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Columns', 'fruitfulblanktextdomain' ),
			'param_name' => 'columns',
			'value'      => '',
			'group'      => esc_html__( 'Columns', 'fruitfulblanktextdomain' ),
			'params'     => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'fruitfulblanktextdomain' ),
					'param_name' => 'title',
					'value'      => '',
				),
				array(
					'type'       => 'exploded_textarea',
					'heading'    => esc_html__( 'Features', 'fruitfulblanktextdomain' ),
					'param_name' => 'features',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Currency', 'fruitfulblanktextdomain' ),
					'param_name' => 'currency',
					'value'      => '$',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Price', 'fruitfulblanktextdomain' ),
					'param_name' => 'price',
					'value'      => '',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Period', 'fruitfulblanktextdomain' ),
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
					'heading'    => esc_html__( 'Button URL', 'fruitfulblanktextdomain' ),
					'param_name' => 'button_url',
					'value'      => '#',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button Title', 'fruitfulblanktextdomain' ),
					'param_name' => 'button_title',
					'value'      => '',
				)
			)
		),

		/**
		 * Fonts
		 */

		/*

		array(
			'type' => 'google_fonts',
			'param_name' => 'heading_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Heading Font Family.', 'fruitfulblanktextdomain' ),
					'font_style_description' => esc_html__( 'Select Heading Font Style.', 'fruitfulblanktextdomain' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__('Fonts', 'fruitfulblanktextdomain' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'features_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Features Font Family.', 'fruitfulblanktextdomain' ),
					'font_style_description' => esc_html__( 'Select Features Font Style.', 'fruitfulblanktextdomain' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'fruitfulblanktextdomain' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'price_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Price Font Family.', 'fruitfulblanktextdomain' ),
					'font_style_description' => esc_html__( 'Select Price Font Style.', 'fruitfulblanktextdomain' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'fruitfulblanktextdomain' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'button_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Button Font Family.', 'fruitfulblanktextdomain' ),
					'font_style_description' => esc_html__( 'Select Button Font Style.', 'fruitfulblanktextdomain' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'fruitfulblanktextdomain' ),
		),

		*/

		/**
		 * Colors
		 */

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Background Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'header_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Text Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'header_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Background Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Background Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_hover_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Text Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Text Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_hover_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Border Color', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'fruitfulblanktextdomain' ),
		),

		/**
		 * Borders
		 */

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Radius', 'fruitfulblanktextdomain' ),
			'param_name' => 'border_radius',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Width', 'fruitfulblanktextdomain' ),
			'param_name' => 'border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button Border Width', 'fruitfulblanktextdomain' ),
			'param_name' => 'button_border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'fruitfulblanktextdomain' ),
		)
	)
) );
