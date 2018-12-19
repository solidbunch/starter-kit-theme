<?php

return array(
	'name'        => esc_html__( 'Heading', 'starter-kit' ),
	'base'        => 'heading',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'heading.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add a heading', 'starter-kit' ),
	'params'      => array(

		/**
		 *  Header attributes tab
		 **/
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Heading Title', 'starter-kit' ),
			'description' => esc_html__( 'Write the heading title content.', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'holder'      => 'h2',
			'group'       => esc_html__( 'Header Attributes', 'starter-kit' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Heading Size', 'starter-kit' ),
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
			'group'       => esc_html__( 'Header Attributes', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'classes',
			'value'      => '',
			'group'      => esc_html__( 'Header Attributes', 'starter-kit' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Header Attributes', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		),


		/**
		 *  Styling tab
		 **/
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Header text color', 'starter-kit' ),
			'param_name' => 'header_color',
			'value'      => '',
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Align', 'starter-kit' ),
			'param_name' => 'text_align',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Left', 'starter-kit' )        => 'left',
				esc_html__( 'Center', 'starter-kit' )      => 'center',
				esc_html__( 'Right', 'starter-kit' )       => 'right',
			),
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Transform', 'starter-kit' ),
			'param_name' => 'text_transform',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'None', 'starter-kit' )        => 'none',
				esc_html__( 'Uppercase', 'starter-kit' )   => 'uppercase',
			),
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Style', 'starter-kit' ),
			'param_name' => 'font_style',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Normal', 'starter-kit' )      => 'normal',
				esc_html__( 'Italic', 'starter-kit' )      => 'italic',
			),
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Weight', 'starter-kit' ),
			'param_name' => 'font_weight',
			'value'      => array(
				esc_html__( '- Default -', 'starter-kit' ) => '',
				esc_html__( 'Light', 'starter-kit' )       => 'lighter',
				esc_html__( 'Normal', 'starter-kit' )      => 'normal',
				esc_html__( 'Bold', 'starter-kit' )        => 'bold',
				esc_html__( 'Bolder', 'starter-kit' )      => 'bolder',
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
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Letter spacing', 'starter-kit' ),
			'description' => esc_html__( 'In pixels, for example: 10', 'starter-kit' ),
			'param_name'  => 'letter_spacing',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size', 'starter-kit' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'starter-kit' ),
			'param_name'  => 'font_size',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height', 'starter-kit' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'starter-kit' ),
			'param_name'  => 'line_height',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size (small screens)', 'starter-kit' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'starter-kit' ),
			'param_name'  => 'font_size_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height (small screens)', 'starter-kit' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'starter-kit' ),
			'param_name'  => 'line_height_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'starter-kit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'starter-kit' ),
		),

	)
);
