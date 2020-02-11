<?php

namespace StarterKit\Handlers\PostTypes;

/**
 * Testimonials
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Testimonials {
	
	public static function register_post_type() {
		
		register_post_type( 'testimonials',
			[
				'label'             => esc_html__( 'Testimonials', 'starter-kit' ),
				'description'       => '',
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => [ 'title', 'editor', 'thumbnail' ],
				'rewrite'           => false,
				'has_archive'       => false,
				'query_var'         => false,
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
					'name'               => esc_html__( 'Testimonials', 'starter-kit' ),
					'singular_name'      => esc_html__( 'Testimonial', 'starter-kit' ),
					'menu_name'          => esc_html__( 'Testimonials', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add Testimonial', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add New Testimonial', 'starter-kit' ),
					'all_items'          => esc_html__( 'All Testimonials', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'starter-kit' ),
					'new_item'           => esc_html__( 'New Testimonial', 'starter-kit' ),
					'view_item'          => esc_html__( 'View Testimonial', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search Testimonials', 'starter-kit' ),
					'not_found'          => esc_html__( 'No Testimonials Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No Testimonials Found in Trash', 'starter-kit' ),
					'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'starter-kit' ),
				],
			]
		);
	}
	
	
	public static function register_taxonomy() {
		
		register_taxonomy( 'testimonial_cat',
			'testimonials',
			[
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => [
					'name'          => _x( 'Testimonials Categories', 'taxonomy general name', 'starter-kit' ),
					'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name', 'starter-kit' ),
					'search_items'  => esc_html__( 'Search in categories', 'starter-kit' ),
					'all_items'     => esc_html__( 'All Categories', 'starter-kit' ),
					'edit_item'     => esc_html__( 'Edit Category', 'starter-kit' ),
					'update_item'   => esc_html__( 'Update Category', 'starter-kit' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'starter-kit' ),
					'new_item_name' => esc_html__( 'New Category', 'starter-kit' ),
					'menu_name'     => esc_html__( 'Categories', 'starter-kit' ),
				],
			]
		);
	}
}
