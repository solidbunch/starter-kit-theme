<?php

namespace ttt\controller;

/**
 * Theme init
 **/
class post_types {
	
	/**
	 * Constructor
	 **/
	function __construct() {
		
		// Register Custom Post Types and Taxonomies
		add_action( 'init', array( $this, 'register_custom_post_types' ), 5 );
		
	}
	
	/**
	 * Register custom post types
	 **/
	function register_custom_post_types() {
		
		register_post_type( 'composerlayout', array(
				'label'               => esc_html__( 'Header / Footer', 'tttextdomain' ),
				'description'         => '',
				'public'              => true,
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'_builtin'            => false,
				'show_in_menu'        => true,
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'hierarchical'        => false,
				'menu_position'       => null,
				'rewrite'             => false,
				'query_var'           => true,
				'supports'            => array( 'title', 'editor' ),
				'labels'              => array(
					'name'               => esc_html__( 'Header / Footer', 'tttextdomain' ),
					'singular_name'      => esc_html__( 'Header / Footer', 'tttextdomain' ),
					'menu_name'          => esc_html__( 'Header / Footer', 'tttextdomain' ),
					'add_new'            => esc_html__( 'Add New Header / Footer', 'tttextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Header / Footer', 'tttextdomain' ),
					'edit'               => esc_html__( 'Edit', 'tttextdomain' ),
					'edit_item'          => esc_html__( 'Edit Header / Footer', 'tttextdomain' ),
					'new_item'           => esc_html__( 'New Header / Footer', 'tttextdomain' ),
					'view'               => esc_html__( 'View Header / Footer', 'tttextdomain' ),
					'view_item'          => esc_html__( 'View Header / Footer', 'tttextdomain' ),
					'search_items'       => esc_html__( 'Search Header / Footer', 'tttextdomain' ),
					'not_found'          => esc_html__( 'No Header / Footer Found', 'tttextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Header / Footer Found in Trash', 'tttextdomain' ),
					'parent'             => esc_html__( 'Parent Header / Footer', 'tttextdomain' )
				)
			)
		);
		
		register_post_type( 'testimonials',
			array(
				'label'             => esc_html__( 'Testimonials', 'tttextdomain' ),
				'description'       => '',
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => false,
				'query_var'         => false,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Testimonials', 'tttextdomain' ),
					'singular_name'      => esc_html__( 'Testimonial', 'tttextdomain' ),
					'menu_name'          => esc_html__( 'Testimonials', 'tttextdomain' ),
					'add_new'            => esc_html__( 'Add Testimonial', 'tttextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Testimonial', 'tttextdomain' ),
					'all_items'          => esc_html__( 'All Testimonials', 'tttextdomain' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'tttextdomain' ),
					'new_item'           => esc_html__( 'New Testimonial', 'tttextdomain' ),
					'view_item'          => esc_html__( 'View Testimonial', 'tttextdomain' ),
					'search_items'       => esc_html__( 'Search Testimonials', 'tttextdomain' ),
					'not_found'          => esc_html__( 'No Testimonials Found', 'tttextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Testimonials Found in Trash', 'tttextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'tttextdomain' )
				)
			)
		);
		
		register_taxonomy( 'testimonial_cat',
			'testimonial',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Testimonials Categories', 'taxonomy general name', 'tttextdomain' ),
					'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name', 'tttextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'tttextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'tttextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'tttextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'tttextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'tttextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'tttextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'tttextdomain' )
				)
			)
		);
		
		register_post_type( 'team_members',
			array(
				'label'             => esc_html__( 'Team Members', 'tttextdomain' ),
				'description'       => '',
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => false,
				'query_var'         => false,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Team Members', 'tttextdomain' ),
					'singular_name'      => esc_html__( 'Team Member', 'tttextdomain' ),
					'menu_name'          => esc_html__( 'Team Members', 'tttextdomain' ),
					'add_new'            => esc_html__( 'Add Team Member', 'tttextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Team Member', 'tttextdomain' ),
					'all_items'          => esc_html__( 'All Team Members', 'tttextdomain' ),
					'edit_item'          => esc_html__( 'Edit Team Member', 'tttextdomain' ),
					'new_item'           => esc_html__( 'New Team Member', 'tttextdomain' ),
					'view_item'          => esc_html__( 'View Team Member', 'tttextdomain' ),
					'search_items'       => esc_html__( 'Search Team Members', 'tttextdomain' ),
					'not_found'          => esc_html__( 'No Team Members Found', 'tttextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Team Members Found in Trash', 'tttextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Team Member:', 'tttextdomain' )
				)
			)
		);
		
		register_taxonomy( 'team_members_cat',
			'team',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Team Members Categories', 'taxonomy general name', 'tttextdomain' ),
					'singular_name' => _x( 'Team Members Category', 'taxonomy singular name', 'tttextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'tttextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'tttextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'tttextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'tttextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'tttextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'tttextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'tttextdomain' )
				)
			)
		);
		
		register_post_type( 'portfolio',
			array(
				'label'             => esc_html__( 'Portfolio', 'tttextdomain' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => true,
				'has_archive'       => true,
				'query_var'         => true,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Portfolio', 'tttextdomain' ),
					'singular_name'      => esc_html__( 'Post', 'tttextdomain' ),
					'menu_name'          => esc_html__( 'Portfolio', 'tttextdomain' ),
					'add_new'            => esc_html__( 'Add Post', 'tttextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Post', 'tttextdomain' ),
					'all_items'          => esc_html__( 'All Posts', 'tttextdomain' ),
					'edit_item'          => esc_html__( 'Edit Post', 'tttextdomain' ),
					'new_item'           => esc_html__( 'New Post', 'tttextdomain' ),
					'view_item'          => esc_html__( 'View Post', 'tttextdomain' ),
					'search_items'       => esc_html__( 'Search Posts', 'tttextdomain' ),
					'not_found'          => esc_html__( 'No Posts Found', 'tttextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Posts Found in Trash', 'tttextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Post:', 'tttextdomain' )
				)
			)
		);
		
		register_taxonomy( 'portfolio_cat',
			'portfolio',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => true,
				'show_in_nav_menus' => true,
				'rewrite'           => true,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Categories', 'taxonomy general name', 'tttextdomain' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name', 'tttextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'tttextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'tttextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'tttextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'tttextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'tttextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'tttextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'tttextdomain' )
				)
			)
		);
		
		register_post_type( 'news',
			array(
				'label'             => esc_html__( 'News', 'tttextdomain' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => true,
				'query_var'         => false,
				'menu_position'     => 1,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'News', 'tttextdomain' ),
					'singular_name'      => esc_html__( 'News Item', 'tttextdomain' ),
					'menu_name'          => esc_html__( 'News', 'tttextdomain' ),
					'add_new'            => esc_html__( 'Add News', 'tttextdomain' ),
					'add_new_item'       => esc_html__( 'Add News', 'tttextdomain' ),
					'all_items'          => esc_html__( 'All News', 'tttextdomain' ),
					'edit_item'          => esc_html__( 'Edit News', 'tttextdomain' ),
					'new_item'           => esc_html__( 'New News', 'tttextdomain' ),
					'view_item'          => esc_html__( 'View News', 'tttextdomain' ),
					'search_items'       => esc_html__( 'Search News', 'tttextdomain' ),
					'not_found'          => esc_html__( 'No News Found', 'tttextdomain' ),
					'not_found_in_trash' => esc_html__( 'No News Found in Trash', 'tttextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent News:', 'tttextdomain' )
				)
			)
		);

	}
	
	
}
