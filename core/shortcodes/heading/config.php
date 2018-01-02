<?php

vc_map( array(
	'name' => esc_html__( 'Heading', 'bvc' ),
	'base' => 'bvc_heading',
	'category' => esc_html__( 'BVC Elements', 'bvc' ),
	'description' => esc_html__( 'Add a heading', 'bvc' ),
	'params' => array(

		/**
		 *  Header attributes tab
		**/
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Heading Title', 'bvc' ),
			'description' => esc_html__( 'Write the heading title content.', 'bvc' ),
			'param_name' => 'title',
			'value' => '',
			'holder'		=> 'h2',
			'group' => esc_html__('Header Attributes', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Heading Size', 'bvc'),
			'param_name' => 'heading',
			'save_always' => true,
			'value' => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
			),
			'group' => esc_html__('Header Attributes', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'CSS classes', 'bvc' ),
			'param_name' => 'classes',
			'value' => '',
			'group' => esc_html__('Header Attributes', 'bvc'),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Element ID', 'bvc' ),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'group' => esc_html__('Header Attributes', 'bvc'),
			'description' => esc_html__( 'Unique identifier of this element', 'bvc' ),
		),


		/**
		 *  Styling tab
		**/
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Header text color', 'bvc' ),
			'param_name' => 'header_color',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text Align', 'bvc'),
			'param_name' => 'text_align',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('Left', 'bvc') => 'left',
				esc_html__('Center', 'bvc') => 'center',
				esc_html__('Right', 'bvc') => 'right',
			),
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text Transform', 'bvc'),
			'param_name' => 'text_transform',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('None', 'bvc') => 'none',
				esc_html__('Uppercase', 'bvc') => 'uppercase',
			),
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Font Style', 'bvc'),
			'param_name' => 'font_style',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('Normal', 'bvc') => 'normal',
				esc_html__('Italic', 'bvc') => 'italic',
			),
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Font Weight', 'bvc'),
			'param_name' => 'font_weight',
			'value' => array(
				esc_html__('- Default -', 'bvc') => '',
				esc_html__('Light', 'bvc') => 'lighter',
				esc_html__('Normal', 'bvc') => 'normal',
				esc_html__('Bold', 'bvc') => 'bold',
				esc_html__('Bolder', 'bvc') => 'bolder',
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
			),
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Letter spacing', 'bvc' ),
			'description' => esc_html__( 'In pixels, for example: 10', 'bvc' ),
			'param_name' => 'letter_spacing',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Font size', 'bvc' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'bvc' ),
			'param_name' => 'font_size',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Line height', 'bvc' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'bvc' ),
			'param_name' => 'line_height',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Font size (small screens)', 'bvc' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'bvc' ),
			'param_name' => 'font_size_mobile',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Line height (small screens)', 'bvc' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'bvc' ),
			'param_name' => 'line_height_mobile',
			'value' => '',
			'group' => esc_html__('Styling', 'bvc'),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'Css', 'bvc' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design options', 'bvc' ),
		),


	)
));
