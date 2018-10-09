<?php
/**
 * Post Types
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hello@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace ffblank\controller;

/**
 * Post Types
 *
 * Register custom post types
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hello@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class post_types {

	/**
	 * Constructor
	 **/
	public function __construct() {

		// Register Custom Post Types and Taxonomies
		add_action( 'init', array( $this, 'register_custom_post_types' ), 5 );

	}

	/**
	 * Register custom post types
	 **/
	public function register_custom_post_types() {

		register_post_type( 'composerlayout', array(
				'label'               => esc_html__( 'Header / Footer', 'fruitfulblanktextdomain' ),
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
					'name'               => esc_html__( 'Header / Footer', 'fruitfulblanktextdomain' ),
					'singular_name'      => esc_html__( 'Header / Footer', 'fruitfulblanktextdomain' ),
					'menu_name'          => esc_html__( 'Header / Footer', 'fruitfulblanktextdomain' ),
					'add_new'            => esc_html__( 'Add New Header / Footer', 'fruitfulblanktextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Header / Footer', 'fruitfulblanktextdomain' ),
					'edit'               => esc_html__( 'Edit', 'fruitfulblanktextdomain' ),
					'edit_item'          => esc_html__( 'Edit Header / Footer', 'fruitfulblanktextdomain' ),
					'new_item'           => esc_html__( 'New Header / Footer', 'fruitfulblanktextdomain' ),
					'view'               => esc_html__( 'View Header / Footer', 'fruitfulblanktextdomain' ),
					'view_item'          => esc_html__( 'View Header / Footer', 'fruitfulblanktextdomain' ),
					'search_items'       => esc_html__( 'Search Header / Footer', 'fruitfulblanktextdomain' ),
					'not_found'          => esc_html__( 'No Header / Footer Found', 'fruitfulblanktextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Header / Footer Found in Trash',
						'fruitfulblanktextdomain' ),
					'parent'             => esc_html__( 'Parent Header / Footer', 'fruitfulblanktextdomain' )
				)
			)
		);

		register_post_type( 'testimonials',
			array(
				'label'             => esc_html__( 'Testimonials', 'fruitfulblanktextdomain' ),
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
					'name'               => esc_html__( 'Testimonials', 'fruitfulblanktextdomain' ),
					'singular_name'      => esc_html__( 'Testimonial', 'fruitfulblanktextdomain' ),
					'menu_name'          => esc_html__( 'Testimonials', 'fruitfulblanktextdomain' ),
					'add_new'            => esc_html__( 'Add Testimonial', 'fruitfulblanktextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Testimonial', 'fruitfulblanktextdomain' ),
					'all_items'          => esc_html__( 'All Testimonials', 'fruitfulblanktextdomain' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'fruitfulblanktextdomain' ),
					'new_item'           => esc_html__( 'New Testimonial', 'fruitfulblanktextdomain' ),
					'view_item'          => esc_html__( 'View Testimonial', 'fruitfulblanktextdomain' ),
					'search_items'       => esc_html__( 'Search Testimonials', 'fruitfulblanktextdomain' ),
					'not_found'          => esc_html__( 'No Testimonials Found', 'fruitfulblanktextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Testimonials Found in Trash', 'fruitfulblanktextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'fruitfulblanktextdomain' )
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
					'name'          => _x( 'Testimonials Categories', 'taxonomy general name',
						'fruitfulblanktextdomain' ),
					'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name',
						'fruitfulblanktextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'fruitfulblanktextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'fruitfulblanktextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'fruitfulblanktextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'fruitfulblanktextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'fruitfulblanktextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'fruitfulblanktextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'fruitfulblanktextdomain' )
				)
			)
		);

		register_post_type( 'team_members',
			array(
				'label'             => esc_html__( 'Team Members', 'fruitfulblanktextdomain' ),
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
					'name'               => esc_html__( 'Team Members', 'fruitfulblanktextdomain' ),
					'singular_name'      => esc_html__( 'Team Member', 'fruitfulblanktextdomain' ),
					'menu_name'          => esc_html__( 'Team Members', 'fruitfulblanktextdomain' ),
					'add_new'            => esc_html__( 'Add Team Member', 'fruitfulblanktextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Team Member', 'fruitfulblanktextdomain' ),
					'all_items'          => esc_html__( 'All Team Members', 'fruitfulblanktextdomain' ),
					'edit_item'          => esc_html__( 'Edit Team Member', 'fruitfulblanktextdomain' ),
					'new_item'           => esc_html__( 'New Team Member', 'fruitfulblanktextdomain' ),
					'view_item'          => esc_html__( 'View Team Member', 'fruitfulblanktextdomain' ),
					'search_items'       => esc_html__( 'Search Team Members', 'fruitfulblanktextdomain' ),
					'not_found'          => esc_html__( 'No Team Members Found', 'fruitfulblanktextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Team Members Found in Trash', 'fruitfulblanktextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Team Member:', 'fruitfulblanktextdomain' )
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
					'name'          => _x( 'Team Members Categories', 'taxonomy general name',
						'fruitfulblanktextdomain' ),
					'singular_name' => _x( 'Team Members Category', 'taxonomy singular name',
						'fruitfulblanktextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'fruitfulblanktextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'fruitfulblanktextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'fruitfulblanktextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'fruitfulblanktextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'fruitfulblanktextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'fruitfulblanktextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'fruitfulblanktextdomain' )
				)
			)
		);

		register_post_type( 'portfolio',
			array(
				'label'             => esc_html__( 'Portfolio', 'fruitfulblanktextdomain' ),
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
					'name'               => esc_html__( 'Portfolio', 'fruitfulblanktextdomain' ),
					'singular_name'      => esc_html__( 'Post', 'fruitfulblanktextdomain' ),
					'menu_name'          => esc_html__( 'Portfolio', 'fruitfulblanktextdomain' ),
					'add_new'            => esc_html__( 'Add Post', 'fruitfulblanktextdomain' ),
					'add_new_item'       => esc_html__( 'Add New Post', 'fruitfulblanktextdomain' ),
					'all_items'          => esc_html__( 'All Posts', 'fruitfulblanktextdomain' ),
					'edit_item'          => esc_html__( 'Edit Post', 'fruitfulblanktextdomain' ),
					'new_item'           => esc_html__( 'New Post', 'fruitfulblanktextdomain' ),
					'view_item'          => esc_html__( 'View Post', 'fruitfulblanktextdomain' ),
					'search_items'       => esc_html__( 'Search Posts', 'fruitfulblanktextdomain' ),
					'not_found'          => esc_html__( 'No Posts Found', 'fruitfulblanktextdomain' ),
					'not_found_in_trash' => esc_html__( 'No Posts Found in Trash', 'fruitfulblanktextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent Post:', 'fruitfulblanktextdomain' )
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
					'name'          => _x( 'Categories', 'taxonomy general name', 'fruitfulblanktextdomain' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name', 'fruitfulblanktextdomain' ),
					'search_items'  => esc_html__( 'Search in categories', 'fruitfulblanktextdomain' ),
					'all_items'     => esc_html__( 'All Categories', 'fruitfulblanktextdomain' ),
					'edit_item'     => esc_html__( 'Edit Category', 'fruitfulblanktextdomain' ),
					'update_item'   => esc_html__( 'Update Category', 'fruitfulblanktextdomain' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'fruitfulblanktextdomain' ),
					'new_item_name' => esc_html__( 'New Category', 'fruitfulblanktextdomain' ),
					'menu_name'     => esc_html__( 'Categories', 'fruitfulblanktextdomain' )
				)
			)
		);

		register_post_type( 'news',
			array(
				'label'             => esc_html__( 'News', 'fruitfulblanktextdomain' ),
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
					'name'               => esc_html__( 'News', 'fruitfulblanktextdomain' ),
					'singular_name'      => esc_html__( 'News Item', 'fruitfulblanktextdomain' ),
					'menu_name'          => esc_html__( 'News', 'fruitfulblanktextdomain' ),
					'add_new'            => esc_html__( 'Add News', 'fruitfulblanktextdomain' ),
					'add_new_item'       => esc_html__( 'Add News', 'fruitfulblanktextdomain' ),
					'all_items'          => esc_html__( 'All News', 'fruitfulblanktextdomain' ),
					'edit_item'          => esc_html__( 'Edit News', 'fruitfulblanktextdomain' ),
					'new_item'           => esc_html__( 'New News', 'fruitfulblanktextdomain' ),
					'view_item'          => esc_html__( 'View News', 'fruitfulblanktextdomain' ),
					'search_items'       => esc_html__( 'Search News', 'fruitfulblanktextdomain' ),
					'not_found'          => esc_html__( 'No News Found', 'fruitfulblanktextdomain' ),
					'not_found_in_trash' => esc_html__( 'No News Found in Trash', 'fruitfulblanktextdomain' ),
					'parent_item_colon'  => esc_html__( 'Parent News:', 'fruitfulblanktextdomain' )
				)
			)
		);

	}


}
