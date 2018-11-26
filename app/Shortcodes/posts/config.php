<?php

return array(
	'name'        => esc_html__( 'Posts', 'starter-kit' ),
	'base'        => 'posts',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'post-it.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Any post type with pagination', 'starter-kit' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Post type', 'starter-kit' ),
			'param_name' => 'post_type',
			'value'      => array(
				esc_html__( 'Blog post', 'starter-kit' )            => 'post',
				esc_html__( 'Portfolio', 'starter-kit' )            => 'portfolio',
				esc_html__( 'Testimonials', 'starter-kit' )         => 'testimonials',
				esc_html__( 'Team Members', 'starter-kit' )         => 'team_members',
				esc_html__( 'WooCommerce Products', 'starter-kit' ) => 'product',
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Posts per page', 'starter-kit' ),
			'param_name' => 'posts_per_page',
			'value'      => '9',
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts ordering method', 'starter-kit' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'starter-kit' )          => 'date',
				esc_html__( 'ID', 'starter-kit' )            => 'ID',
				esc_html__( 'Modified date', 'starter-kit' ) => 'modified',
				esc_html__( 'Title', 'starter-kit' )         => 'title',
				esc_html__( 'Random', 'starter-kit' )        => 'rand',
				esc_html__( 'Menu', 'starter-kit' )          => 'menu',
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts sorting method', 'starter-kit' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'starter-kit' ) => 'DESC',
				esc_html__( 'Ascending', 'starter-kit' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Query from category', 'starter-kit' ),
			'param_name'  => 'tax_query_type',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'All', 'starter-kit' )    => '',
				esc_html__( 'Only', 'starter-kit' )   => 'only',
				esc_html__( 'Except', 'starter-kit' ) => 'except',
			),
			'group'       => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Taxonomy slug', 'starter-kit' ),
			'param_name' => 'taxonomy_slug',
			'value'      => 'category',
			'dependency' => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'      => esc_html__( 'General', 'starter-kit' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Categories', 'starter-kit' ),
			'description' => esc_html__( 'Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma',
				'starter-kit' ),
			'param_name'  => 'taxonomy_terms',
			'admin_label' => true,
			'value'       => '',
			'dependency'  => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'       => esc_html__( 'General', 'starter-kit' ),
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
		 *  Pagination tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display pagination', 'starter-kit' ),
			'param_name' => 'pagination',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
			'group'      => esc_html__( 'Pagination', 'starter-kit' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pagination button text', 'starter-kit' ),
			'param_name' => 'ajax_load_more_button_text',
			'dependency' => array(
				'element'   => 'pagination',
				'not_empty' => true,
			),
			'value'      => esc_html__( 'Load more', 'starter-kit' ),
			'group'      => esc_html__( 'Pagination', 'starter-kit' ),
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
			'heading'    => esc_html__( 'Display post title', 'starter-kit' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'starter-kit' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display post excerpt', 'starter-kit' ),
			'param_name' => 'display_excerpt',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'starter-kit' ),
			'std'        => 'yes'
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Excerpt lenght', 'starter-kit' ),
			'description' => esc_html__( 'how many words should we display?', 'starter-kit' ),
			'param_name'  => 'excerpt_length',
			'value'       => '13',
			'dependency'  => array(
				'element'   => 'display_excerpt',
				'not_empty' => true,
			),
			'group'       => esc_html__( 'Appearance', 'starter-kit' ),
		),

		/**
		 *  Style tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Thumbnails dimensions', 'starter-kit' ),
			'param_name' => 'thumbs_dimensions',
			'value'      => array(
				esc_html__( 'Original size (full)', 'starter-kit' ) => '',
				esc_html__( 'Crop thumbnails', 'starter-kit' )      => 'crop',
			),
			'group'      => esc_html__( 'Style', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail width', 'starter-kit' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'starter-kit' ),
			'param_name'  => 'thumb_width',
			'value'       => '320',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'starter-kit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail height', 'starter-kit' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'starter-kit' ),
			'param_name'  => 'thumb_height',
			'value'       => '180',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'starter-kit' ),
		),

	),
);
