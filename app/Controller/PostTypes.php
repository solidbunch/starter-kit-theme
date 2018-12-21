<?php
namespace StarterKit\Controller;

/**
 * Post Types
 *
 * Register custom post types
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class PostTypes {

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
				'label'               => esc_html__( 'Header / Footer', 'starter-kit' ),
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
					'name'               => esc_html__( 'Header / Footer', 'starter-kit' ),
					'singular_name'      => esc_html__( 'Header / Footer', 'starter-kit' ),
					'menu_name'          => esc_html__( 'Header / Footer', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add New Header / Footer', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add New Header / Footer', 'starter-kit' ),
					'edit'               => esc_html__( 'Edit', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit Header / Footer', 'starter-kit' ),
					'new_item'           => esc_html__( 'New Header / Footer', 'starter-kit' ),
					'view'               => esc_html__( 'View Header / Footer', 'starter-kit' ),
					'view_item'          => esc_html__( 'View Header / Footer', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search Header / Footer', 'starter-kit' ),
					'not_found'          => esc_html__( 'No Header / Footer Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No Header / Footer Found in Trash',
						'starter-kit' ),
					'parent'             => esc_html__( 'Parent Header / Footer', 'starter-kit' )
				)
			)
		);

		register_post_type( 'testimonials',
			array(
				'label'             => esc_html__( 'Testimonials', 'starter-kit' ),
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
					'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'starter-kit' )
				)
			)
		);

		register_taxonomy( 'testimonial_cat',
			'testimonials',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Testimonials Categories', 'taxonomy general name',
						'starter-kit' ),
					'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name',
						'starter-kit' ),
					'search_items'  => esc_html__( 'Search in categories', 'starter-kit' ),
					'all_items'     => esc_html__( 'All Categories', 'starter-kit' ),
					'edit_item'     => esc_html__( 'Edit Category', 'starter-kit' ),
					'update_item'   => esc_html__( 'Update Category', 'starter-kit' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'starter-kit' ),
					'new_item_name' => esc_html__( 'New Category', 'starter-kit' ),
					'menu_name'     => esc_html__( 'Categories', 'starter-kit' )
				)
			)
		);

		register_post_type( 'team_members',
			array(
				'label'             => esc_html__( 'Team Members', 'starter-kit' ),
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
					'name'               => esc_html__( 'Team Members', 'starter-kit' ),
					'singular_name'      => esc_html__( 'Team Member', 'starter-kit' ),
					'menu_name'          => esc_html__( 'Team Members', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add Team Member', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add New Team Member', 'starter-kit' ),
					'all_items'          => esc_html__( 'All Team Members', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit Team Member', 'starter-kit' ),
					'new_item'           => esc_html__( 'New Team Member', 'starter-kit' ),
					'view_item'          => esc_html__( 'View Team Member', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search Team Members', 'starter-kit' ),
					'not_found'          => esc_html__( 'No Team Members Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No Team Members Found in Trash', 'starter-kit' ),
					'parent_item_colon'  => esc_html__( 'Parent Team Member:', 'starter-kit' )
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
						'starter-kit' ),
					'singular_name' => _x( 'Team Members Category', 'taxonomy singular name',
						'starter-kit' ),
					'search_items'  => esc_html__( 'Search in categories', 'starter-kit' ),
					'all_items'     => esc_html__( 'All Categories', 'starter-kit' ),
					'edit_item'     => esc_html__( 'Edit Category', 'starter-kit' ),
					'update_item'   => esc_html__( 'Update Category', 'starter-kit' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'starter-kit' ),
					'new_item_name' => esc_html__( 'New Category', 'starter-kit' ),
					'menu_name'     => esc_html__( 'Categories', 'starter-kit' )
				)
			)
		);

		register_post_type( 'portfolio',
			array(
				'label'             => esc_html__( 'Portfolio', 'starter-kit' ),
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
					'name'          => _x( 'Categories', 'taxonomy general name', 'starter-kit' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name', 'starter-kit' ),
					'search_items'  => esc_html__( 'Search in categories', 'starter-kit' ),
					'all_items'     => esc_html__( 'All Categories', 'starter-kit' ),
					'edit_item'     => esc_html__( 'Edit Category', 'starter-kit' ),
					'update_item'   => esc_html__( 'Update Category', 'starter-kit' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'starter-kit' ),
					'new_item_name' => esc_html__( 'New Category', 'starter-kit' ),
					'menu_name'     => esc_html__( 'Categories', 'starter-kit' )
				)
			)
		);

		register_post_type( 'news',
			array(
				'label'             => esc_html__( 'News', 'starter-kit' ),
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
					'name'               => esc_html__( 'News', 'starter-kit' ),
					'singular_name'      => esc_html__( 'News Item', 'starter-kit' ),
					'menu_name'          => esc_html__( 'News', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add News', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add News', 'starter-kit' ),
					'all_items'          => esc_html__( 'All News', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit News', 'starter-kit' ),
					'new_item'           => esc_html__( 'New News', 'starter-kit' ),
					'view_item'          => esc_html__( 'View News', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search News', 'starter-kit' ),
					'not_found'          => esc_html__( 'No News Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No News Found in Trash', 'starter-kit' ),
					'parent_item_colon'  => esc_html__( 'Parent News:', 'starter-kit' )
				)
			)
		);

	}


}
