<?php

use StarterKit\Helper\Utils;

return [
	'name'        => esc_html__( 'Pricing Table', 'starter-kit' ),
	'base'        => 'pricing_table',
	'icon'        => Utils::getConfigSetting( 'shortcodes_icon_uri' ) . 'viral-marketing.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Param Group', 'starter-kit' ),
	'params'      => [
		
		/**
		 * Columns Repeater (to manage columns data)
		 */
		
		[
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Columns', 'starter-kit' ),
			'param_name' => 'columns',
			'value'      => '',
			'group'      => esc_html__( 'Columns', 'starter-kit' ),
			'params'     => [
				[
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'starter-kit' ),
					'param_name' => 'title',
					'value'      => '',
				],
				[
					'type'       => 'exploded_textarea',
					'heading'    => esc_html__( 'Features', 'starter-kit' ),
					'param_name' => 'features',
					'value'      => '',
				],
				[
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Currency', 'starter-kit' ),
					'param_name' => 'currency',
					'value'      => '$',
				],
				[
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Price', 'starter-kit' ),
					'param_name' => 'price',
					'value'      => '',
				],
				[
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Period', 'starter-kit' ),
					'param_name' => 'period',
					'value'      => [
						"Per Day"   => "per<br>day",
						"Per Week"  => "per<br>week",
						"Per Month" => "per<br>month",
						"Per Year"  => "per<br>year",
						"Forever"   => "forever"
					]
				],
				[
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button URL', 'starter-kit' ),
					'param_name' => 'button_url',
					'value'      => '#',
				],
				[
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button Title', 'starter-kit' ),
					'param_name' => 'button_title',
					'value'      => '',
				]
			]
		],
		
		/**
		 * Fonts
		 */
		
		/*

		array(
			'type' => 'google_fonts',
			'param_name' => 'heading_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Heading Font Family.', 'starter-kit' ),
					'font_style_description' => esc_html__( 'Select Heading Font Style.', 'starter-kit' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__('Fonts', 'starter-kit' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'features_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Features Font Family.', 'starter-kit' ),
					'font_style_description' => esc_html__( 'Select Features Font Style.', 'starter-kit' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'starter-kit' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'price_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Price Font Family.', 'starter-kit' ),
					'font_style_description' => esc_html__( 'Select Price Font Style.', 'starter-kit' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'starter-kit' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'button_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Button Font Family.', 'starter-kit' ),
					'font_style_description' => esc_html__( 'Select Button Font Style.', 'starter-kit' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'starter-kit' ),
		),

		*/
		
		/**
		 * Colors
		 */
		
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'starter-kit' ),
			'param_name' => 'border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Background Color', 'starter-kit' ),
			'param_name' => 'header_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Text Color', 'starter-kit' ),
			'param_name' => 'header_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Background Color', 'starter-kit' ),
			'param_name' => 'button_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Background Color', 'starter-kit' ),
			'param_name' => 'button_hover_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Text Color', 'starter-kit' ),
			'param_name' => 'button_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Text Color', 'starter-kit' ),
			'param_name' => 'button_hover_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		[
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Border Color', 'starter-kit' ),
			'param_name' => 'button_border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'starter-kit' ),
		],
		
		/**
		 * Borders
		 */
		
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Radius, px', 'starter-kit' ),
			'param_name' => 'border_radius',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'starter-kit' ),
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Width, px', 'starter-kit' ),
			'param_name' => 'border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'starter-kit' ),
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button Border Width, px', 'starter-kit' ),
			'param_name' => 'button_border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'starter-kit' ),
		],
		
		/**
		 * Other
		 */
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'el_classes',
			'value'      => '',
			'group'      => esc_html__( 'Other', 'starter-kit' ),
		],
		[
			'type'       => 'el_id',
			'heading'    => esc_html__( 'CSS id', 'starter-kit' ),
			'param_name' => 'el_id',
			'value'      => '',
			'group'      => esc_html__( 'Other', 'starter-kit' ),
		],
	],
];
