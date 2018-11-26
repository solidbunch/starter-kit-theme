<?php

return array(
	'name'        => esc_html__( 'News', 'starter-kit' ),
	'base'        => 'news',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'newspaper.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'News', 'starter-kit' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'starter-kit' ),
			'param_name' => 'title',
			'value'      => __('Recent News', 'starter-kit'),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News ordering method', 'starter-kit' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'starter-kit' )          => 'date',
				esc_html__( 'ID', 'starter-kit' )            => 'ID',
				esc_html__( 'Modified date', 'starter-kit' ) => 'modified',
				esc_html__( 'Title', 'starter-kit' )         => 'title',
				esc_html__( 'Random', 'starter-kit' )        => 'rand',
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News sorting method', 'starter-kit' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'starter-kit' ) => 'DESC',
				esc_html__( 'Ascending', 'starter-kit' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'General', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		),

		/**
		 *  Appearance tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display thumbnail', 'starter-kit' ),
			'param_name' => 'display_thumb',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'starter-kit' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display news title', 'starter-kit' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'starter-kit' ),
			'std'        => 'yes'
		),
	),
);
