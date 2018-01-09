<?php

vc_map( array(
	'name' => esc_html__( 'Simple Posts Shortcode', 'fruitfulblanktextdomain' ),
	'base' => 'fruitfulblankprefix_postsimple',
	'category' => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add testimonials carousel', 'fruitfulblanktextdomain' ),
	'params' => array(

		/**
		 *  Attributes tab
		**/
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Posts per page', 'fruitfulblanktextdomain' ),
			'param_name' => 'posts_per_page',
			'value' => '2',
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
			'type' => 'textfield',
			'heading' => esc_html__( 'CSS classes', 'fruitfulblanktextdomain' ),
			'param_name' => 'classes',
			'value' => '',
			'group' => esc_html__('General', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'group' => esc_html__('General', 'fruitfulblanktextdomain'),
			'description' => esc_html__( 'Unique identifier of this element', 'fruitfulblanktextdomain' ),
		),


		/**
		 *  Styling tab
		**/
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Header text color', 'fruitfulblanktextdomain' ),
			'param_name' => 'header_color',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text Align', 'fruitfulblanktextdomain'),
			'param_name' => 'text_align',
			'value' => array(
				esc_html__('- Default -', 'fruitfulblanktextdomain') => '',
				esc_html__('Left', 'fruitfulblanktextdomain') => 'left',
				esc_html__('Center', 'fruitfulblanktextdomain') => 'center',
				esc_html__('Right', 'fruitfulblanktextdomain') => 'right',
			),
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text Transform', 'fruitfulblanktextdomain'),
			'param_name' => 'text_transform',
			'value' => array(
				esc_html__('- Default -', 'fruitfulblanktextdomain') => '',
				esc_html__('None', 'fruitfulblanktextdomain') => 'none',
				esc_html__('Uppercase', 'fruitfulblanktextdomain') => 'uppercase',
			),
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Font Style', 'fruitfulblanktextdomain'),
			'param_name' => 'font_style',
			'value' => array(
				esc_html__('- Default -', 'fruitfulblanktextdomain') => '',
				esc_html__('Normal', 'fruitfulblanktextdomain') => 'normal',
				esc_html__('Italic', 'fruitfulblanktextdomain') => 'italic',
			),
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Font Weight', 'fruitfulblanktextdomain'),
			'param_name' => 'font_weight',
			'value' => array(
				esc_html__('- Default -', 'fruitfulblanktextdomain') => '',
				esc_html__('Light', 'fruitfulblanktextdomain') => 'lighter',
				esc_html__('Normal', 'fruitfulblanktextdomain') => 'normal',
				esc_html__('Bold', 'fruitfulblanktextdomain') => 'bold',
				esc_html__('Bolder', 'fruitfulblanktextdomain') => 'bolder',
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
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Letter spacing', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 10', 'fruitfulblanktextdomain' ),
			'param_name' => 'letter_spacing',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Font size', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'fruitfulblanktextdomain' ),
			'param_name' => 'font_size',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Line height', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'fruitfulblanktextdomain' ),
			'param_name' => 'line_height',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Font size (small screens)', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'fruitfulblanktextdomain' ),
			'param_name' => 'font_size_mobile',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Line height (small screens)', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'fruitfulblanktextdomain' ),
			'param_name' => 'line_height_mobile',
			'value' => '',
			'group' => esc_html__('Styling', 'fruitfulblanktextdomain'),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'Css', 'fruitfulblanktextdomain' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design options', 'fruitfulblanktextdomain' ),
		),



	)
));
