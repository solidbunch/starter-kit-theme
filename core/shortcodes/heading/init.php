<?php

vc_map( array(
	'name'        => esc_html__( 'Heading', 'tttextdomain' ),
	'base'        => 'heading',
	'category'    => esc_html__( 'Theme Elements', 'tttextdomain' ),
	'description' => esc_html__( 'Add a heading', 'tttextdomain' ),
	'params'      => array(
		
		/**
		 *  Header attributes tab
		 **/
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Heading Title', 'tttextdomain' ),
			'description' => esc_html__( 'Write the heading title content.', 'tttextdomain' ),
			'param_name'  => 'title',
			'value'       => '',
			'holder'      => 'h2',
			'group'       => esc_html__( 'Header Attributes', 'tttextdomain' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Heading Size', 'tttextdomain' ),
			'param_name'  => 'heading',
			'save_always' => true,
			'value'       => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
			),
			'group'       => esc_html__( 'Header Attributes', 'tttextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'tttextdomain' ),
			'param_name' => 'classes',
			'value'      => '',
			'group'      => esc_html__( 'Header Attributes', 'tttextdomain' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'tttextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Header Attributes', 'tttextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'tttextdomain' ),
		),
		
		
		/**
		 *  Styling tab
		 **/
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Header text color', 'tttextdomain' ),
			'param_name' => 'header_color',
			'value'      => '',
			'group'      => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Align', 'tttextdomain' ),
			'param_name' => 'text_align',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'Left', 'tttextdomain' )        => 'left',
				esc_html__( 'Center', 'tttextdomain' )      => 'center',
				esc_html__( 'Right', 'tttextdomain' )       => 'right',
			),
			'group'      => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Transform', 'tttextdomain' ),
			'param_name' => 'text_transform',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'None', 'tttextdomain' )        => 'none',
				esc_html__( 'Uppercase', 'tttextdomain' )   => 'uppercase',
			),
			'group'      => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Style', 'tttextdomain' ),
			'param_name' => 'font_style',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'Normal', 'tttextdomain' )      => 'normal',
				esc_html__( 'Italic', 'tttextdomain' )      => 'italic',
			),
			'group'      => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Weight', 'tttextdomain' ),
			'param_name' => 'font_weight',
			'value'      => array(
				esc_html__( '- Default -', 'tttextdomain' ) => '',
				esc_html__( 'Light', 'tttextdomain' )       => 'lighter',
				esc_html__( 'Normal', 'tttextdomain' )      => 'normal',
				esc_html__( 'Bold', 'tttextdomain' )        => 'bold',
				esc_html__( 'Bolder', 'tttextdomain' )      => 'bolder',
				'100'                                                  => '100',
				'200'                                                  => '200',
				'300'                                                  => '300',
				'400'                                                  => '400',
				'500'                                                  => '500',
				'600'                                                  => '600',
				'700'                                                  => '700',
				'800'                                                  => '800',
				'900'                                                  => '900',
			),
			'group'      => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Letter spacing', 'tttextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 10', 'tttextdomain' ),
			'param_name'  => 'letter_spacing',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size', 'tttextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'tttextdomain' ),
			'param_name'  => 'font_size',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height', 'tttextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'tttextdomain' ),
			'param_name'  => 'line_height',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size (small screens)', 'tttextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'tttextdomain' ),
			'param_name'  => 'font_size_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height (small screens)', 'tttextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'tttextdomain' ),
			'param_name'  => 'line_height_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'tttextdomain' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'tttextdomain' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'tttextdomain' ),
		),
	
	)
) );
