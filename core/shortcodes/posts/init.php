<?php

vc_map( array(
	'name'        => esc_html__( 'Posts', 'fruitfulblanktextdomain' ),
	'base'        => 'posts',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Any post type with pagination', 'fruitfulblanktextdomain' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Post type', 'fruitfulblanktextdomain' ),
			'param_name' => 'post_type',
			'value'      => array(
				esc_html__( 'Blog post', 'fruitfulblanktextdomain' )            => 'post',
				esc_html__( 'Portfolio', 'fruitfulblanktextdomain' )            => 'portfolio',
				esc_html__( 'Testimonials', 'fruitfulblanktextdomain' )         => 'testimonials',
				esc_html__( 'Team Members', 'fruitfulblanktextdomain' )         => 'team_members',
				esc_html__( 'WooCommerce Products', 'fruitfulblanktextdomain' ) => 'product',
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Posts per page', 'fruitfulblanktextdomain' ),
			'param_name' => 'posts_per_page',
			'value'      => '9',
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts ordering method', 'fruitfulblanktextdomain' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'fruitfulblanktextdomain' )          => 'date',
				esc_html__( 'ID', 'fruitfulblanktextdomain' )            => 'ID',
				esc_html__( 'Modified date', 'fruitfulblanktextdomain' ) => 'modified',
				esc_html__( 'Title', 'fruitfulblanktextdomain' )         => 'title',
				esc_html__( 'Random', 'fruitfulblanktextdomain' )        => 'rand',
				esc_html__( 'Menu', 'fruitfulblanktextdomain' )          => 'menu',
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts sorting method', 'fruitfulblanktextdomain' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'fruitfulblanktextdomain' ) => 'DESC',
				esc_html__( 'Ascending', 'fruitfulblanktextdomain' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Query from category', 'fruitfulblanktextdomain' ),
			'param_name'  => 'tax_query_type',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'All', 'fruitfulblanktextdomain' )    => '',
				esc_html__( 'Only', 'fruitfulblanktextdomain' )   => 'only',
				esc_html__( 'Except', 'fruitfulblanktextdomain' ) => 'except',
			),
			'group'       => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Taxonomy slug', 'fruitfulblanktextdomain' ),
			'param_name' => 'taxonomy_slug',
			'value'      => 'category',
			'dependency' => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'      => esc_html__( 'General', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Categories', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma',
				'fruitfulblanktextdomain' ),
			'param_name'  => 'taxonomy_terms',
			'admin_label' => true,
			'value'       => '',
			'dependency'  => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'       => esc_html__( 'General', 'fruitfulblanktextdomain' ),
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
		 *  Pagination tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display pagination', 'fruitfulblanktextdomain' ),
			'param_name' => 'pagination',
			'value'      => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Pagination', 'fruitfulblanktextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pagination button text', 'fruitfulblanktextdomain' ),
			'param_name' => 'ajax_load_more_button_text',
			'dependency' => array(
				'element'   => 'pagination',
				'not_empty' => true,
			),
			'value'      => esc_html__( 'Load more', 'fruitfulblanktextdomain' ),
			'group'      => esc_html__( 'Pagination', 'fruitfulblanktextdomain' ),
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
			'heading'    => esc_html__( 'Display post title', 'fruitfulblanktextdomain' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'fruitfulblanktextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display post excerpt', 'fruitfulblanktextdomain' ),
			'param_name' => 'display_excerpt',
			'value'      => array( esc_html__( 'Yes', 'fruitfulblanktextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'fruitfulblanktextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Excerpt lenght', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'how many words should we display?', 'fruitfulblanktextdomain' ),
			'param_name'  => 'excerpt_length',
			'value'       => '13',
			'dependency'  => array(
				'element'   => 'display_excerpt',
				'not_empty' => true,
			),
			'group'       => esc_html__( 'Appearance', 'fruitfulblanktextdomain' ),
		),

		/**
		 *  Style tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Thumbnails dimensions', 'fruitfulblanktextdomain' ),
			'param_name' => 'thumbs_dimensions',
			'value'      => array(
				esc_html__( 'Original size (full)', 'fruitfulblanktextdomain' ) => '',
				esc_html__( 'Crop thumbnails', 'fruitfulblanktextdomain' )      => 'crop',
			),
			'group'      => esc_html__( 'Style', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail width', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'fruitfulblanktextdomain' ),
			'param_name'  => 'thumb_width',
			'value'       => '320',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail height', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'fruitfulblanktextdomain' ),
			'param_name'  => 'thumb_height',
			'value'       => '180',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'fruitfulblanktextdomain' ),
		),

	),
) );
