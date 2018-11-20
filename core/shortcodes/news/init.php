<?php

vc_map( array(
	'name'        => esc_html__( 'News', 'fruitfulblanktextdomain' ),
	'base'        => 'news',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'newspaper.svg',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'News', 'fruitfulblanktextdomain' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News ordering method', 'fruitfulblanktextdomain' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'fruitfulblanktextdomain' )          => 'date',
				esc_html__( 'ID', 'fruitfulblanktextdomain' )            => 'ID',
				esc_html__( 'Modified date', 'fruitfulblanktextdomain' ) => 'modified',
				esc_html__( 'Title', 'fruitfulblanktextdomain' )         => 'title',
				esc_html__( 'Random', 'fruitfulblanktextdomain' )        => 'rand',
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News sorting method', 'fruitfulblanktextdomain' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'fruitfulblanktextdomain' ) => 'DESC',
				esc_html__( 'Ascending', 'fruitfulblanktextdomain' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'General', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'fruitfulblanktextdomain' ),
		),

		/**
		 *  Appearance tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display thumbnail', 'fruitfulblanktextdomain' ),
			'param_name' => 'display_thumb',
			'value'      => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'fruitfulblanktextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display news title', 'fruitfulblanktextdomain' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'fruitfulblanktextdomain' ),
			'std'        => 'yes'
		),
	),
) );
