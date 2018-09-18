<?php

vc_map( array(
	'name'        => esc_html__( 'News', 'tttextdomain' ),
	'base'        => 'news',
	'category'    => esc_html__( 'Theme Elements', 'tttextdomain' ),
	'description' => esc_html__( 'News', 'tttextdomain' ),
	'params'      => array(
		
		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News ordering method', 'tttextdomain' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'tttextdomain' )          => 'date',
				esc_html__( 'ID', 'tttextdomain' )            => 'ID',
				esc_html__( 'Modified date', 'tttextdomain' ) => 'modified',
				esc_html__( 'Title', 'tttextdomain' )         => 'title',
				esc_html__( 'Random', 'tttextdomain' )        => 'rand',
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News sorting method', 'tttextdomain' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'tttextdomain' ) => 'DESC',
				esc_html__( 'Ascending', 'tttextdomain' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'tttextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'General', 'tttextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'tttextdomain' ),
		),
		
		/**
		 *  Appearance tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display thumbnail', 'tttextdomain' ),
			'param_name' => 'display_thumb',
			'value'      => array( esc_html__( 'Yes', 'tttextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'tttextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display news title', 'tttextdomain' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'tttextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'tttextdomain' ),
			'std'        => 'yes'
		),	
	),
) );
