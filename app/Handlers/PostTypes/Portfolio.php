<?php

namespace StarterKit\Handlers\PostTypes;

/**
 * Portfolio
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Portfolio {
	
	public static function register_post_type() {
		
		register_post_type( 'portfolio',
			[
				'label'             => esc_html__( 'Portfolio', 'starter-kit' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => [ 'title', 'editor', 'thumbnail' ],
				'rewrite'           => true,
				'has_archive'       => true,
				'query_var'         => true,
				'menu_position'     => 5,
				'capabilities'      => [
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				],
				'labels'            => [
					'name'               => esc_html__( 'Portfolio', 'starter-kit' ),
					'singular_name'      => esc_html__( 'Post', 'starter-kit' ),
					'menu_name'          => esc_html__( 'Portfolio', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add Post', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add New Post', 'starter-kit' ),
					'all_items'          => esc_html__( 'All Posts', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit Post', 'starter-kit' ),
					'new_item'           => esc_html__( 'New Post', 'starter-kit' ),
					'view_item'          => esc_html__( 'View Post', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search Posts', 'starter-kit' ),
					'not_found'          => esc_html__( 'No Posts Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No Posts Found in Trash', 'starter-kit' ),
					'parent_item_colon'  => esc_html__( 'Parent Post:', 'starter-kit' )
				]
			]
		);
		
	}
	
	
	public static function register_taxonomy() {
		
		register_taxonomy( 'portfolio_cat',
			'portfolio',
			[
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => true,
				'show_in_nav_menus' => true,
				'rewrite'           => true,
				'show_admin_column' => true,
				'labels'            => [
					'name'          => _x( 'Categories', 'taxonomy general name', 'starter-kit' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name', 'starter-kit' ),
					'search_items'  => esc_html__( 'Search in categories', 'starter-kit' ),
					'all_items'     => esc_html__( 'All Categories', 'starter-kit' ),
					'edit_item'     => esc_html__( 'Edit Category', 'starter-kit' ),
					'update_item'   => esc_html__( 'Update Category', 'starter-kit' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'starter-kit' ),
					'new_item_name' => esc_html__( 'New Category', 'starter-kit' ),
					'menu_name'     => esc_html__( 'Categories', 'starter-kit' )
				]
			]
		);
		
	}
}
