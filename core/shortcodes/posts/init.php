<?php

vc_map( array(
	'name'        => esc_html__( 'Posts', 'tttextdomain' ),
	'base'        => 'posts',
	'category'    => esc_html__( 'Theme Elements', 'tttextdomain' ),
	'description' => esc_html__( 'Any post type with pagination', 'tttextdomain' ),
	'params'      => array(
		
		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Post type', 'tttextdomain' ),
			'param_name' => 'post_type',
			'value'      => array(
				esc_html__( 'Blog post', 'tttextdomain' )            => 'post',
				esc_html__( 'Portfolio', 'tttextdomain' )            => 'portfolio',
				esc_html__( 'Testimonials', 'tttextdomain' )         => 'testimonials',
				esc_html__( 'Team Members', 'tttextdomain' )         => 'team_members',
				esc_html__( 'WooCommerce Products', 'tttextdomain' ) => 'product',
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Posts per page', 'tttextdomain' ),
			'param_name' => 'posts_per_page',
			'value'      => '9',
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts ordering method', 'tttextdomain' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'tttextdomain' )          => 'date',
				esc_html__( 'ID', 'tttextdomain' )            => 'ID',
				esc_html__( 'Modified date', 'tttextdomain' ) => 'modified',
				esc_html__( 'Title', 'tttextdomain' )         => 'title',
				esc_html__( 'Random', 'tttextdomain' )        => 'rand',
				esc_html__( 'Menu', 'tttextdomain' )          => 'menu',
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts sorting method', 'tttextdomain' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'tttextdomain' ) => 'DESC',
				esc_html__( 'Ascending', 'tttextdomain' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Query from category', 'tttextdomain' ),
			'param_name'  => 'tax_query_type',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'All', 'tttextdomain' )    => '',
				esc_html__( 'Only', 'tttextdomain' )   => 'only',
				esc_html__( 'Except', 'tttextdomain' ) => 'except',
			),
			'group'       => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Taxonomy slug', 'tttextdomain' ),
			'param_name' => 'taxonomy_slug',
			'value'      => 'category',
			'dependency' => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'      => esc_html__( 'General', 'tttextdomain' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Categories', 'tttextdomain' ),
			'description' => esc_html__( 'Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma', 'tttextdomain' ),
			'param_name'  => 'taxonomy_terms',
			'admin_label' => true,
			'value'       => '',
			'dependency'  => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'       => esc_html__( 'General', 'tttextdomain' ),
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
		 *  Pagination tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display pagination', 'tttextdomain' ),
			'param_name' => 'pagination',
			'value'      => array( esc_html__( 'Yes', 'tttextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Pagination', 'tttextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pagination button text', 'tttextdomain' ),
			'param_name' => 'ajax_load_more_button_text',
			'dependency' => array(
				'element'   => 'pagination',
				'not_empty' => true,
			),
			'value'      => esc_html__( 'Load more', 'tttextdomain' ),
			'group'      => esc_html__( 'Pagination', 'tttextdomain' ),
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
			'heading'    => esc_html__( 'Display post title', 'tttextdomain' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'tttextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'tttextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display post excerpt', 'tttextdomain' ),
			'param_name' => 'display_excerpt',
			'value'      => array( esc_html__( 'Yes', 'tttextdomain' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'tttextdomain' ),
			'std'        => 'yes'
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Excerpt lenght', 'tttextdomain' ),
			'description' => esc_html__( 'how many words should we display?', 'tttextdomain' ),
			'param_name'  => 'excerpt_length',
			'value'       => '13',
			'dependency'  => array(
				'element'   => 'display_excerpt',
				'not_empty' => true,
			),
			'group'       => esc_html__( 'Appearance', 'tttextdomain' ),
		),
		
		/**
		 *  Style tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Thumbnails dimensions', 'tttextdomain' ),
			'param_name' => 'thumbs_dimensions',
			'value'      => array(
				esc_html__( 'Original size (full)', 'tttextdomain' ) => '',
				esc_html__( 'Crop thumbnails', 'tttextdomain' )      => 'crop',
			),
			'group'      => esc_html__( 'Style', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail width', 'tttextdomain' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'tttextdomain' ),
			'param_name'  => 'thumb_width',
			'value'       => '320',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'tttextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail height', 'tttextdomain' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'tttextdomain' ),
			'param_name'  => 'thumb_height',
			'value'       => '180',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'tttextdomain' ),
		),
	
	),
) );
