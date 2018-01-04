<?php
/**
 * Theme init
 **/
class fruitfulblankprefix_posttypes_controller extends fruitfulblankprefix_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run init actions
	**/
	function run() {

		// Register Custom Post Types and Taxonomies
		add_action( 'init', array( $this, 'register_custom_post_types'), 5);

	}

	/**
	 * Register custom post types
	**/
	function register_custom_post_types() {

		/**
		 * Content of testimonials was copied from live website,
		 * so we leave "dslc_testimonials" post type name as is
		**/
		register_post_type( 'dslc_testimonials',
			array(
				'label'							=> esc_html__( 'Testimonials', 'fruitfulblanktextdomain'),
				'description'				=> '',
				'public'						=> false,
				'show_ui'						=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' => true,
				'capability_type'		=> 'post',
				'hierarchical'			=> false,
				'supports'					=> array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'						=> false,
				'has_archive'				=> false,
				'query_var'					=> false,
				'menu_position'			=> 5,
				'capabilities' => array(
					'publish_posts'				=> 'edit_pages',
					'edit_posts'					=> 'edit_pages',
					'edit_others_posts'		=> 'edit_pages',
					'delete_posts'				=> 'edit_pages',
					'delete_others_posts'	=> 'edit_pages',
					'read_private_posts'	=> 'edit_pages',
					'edit_post'						=> 'edit_pages',
					'delete_post'					=> 'edit_pages',
					'read_post'						=> 'edit_pages',
				),
				'labels' => array(
					'name'								=> esc_html__( 'Testimonials', 'fruitfulblanktextdomain'),
					'singular_name'				=> esc_html__( 'Testimonial', 'fruitfulblanktextdomain'),
					'menu_name'						=> esc_html__( 'Testimonials', 'fruitfulblanktextdomain'),
					'add_new'							=> esc_html__( 'Add Testimonial', 'fruitfulblanktextdomain'),
					'add_new_item'				=> esc_html__( 'Add New Testimonial', 'fruitfulblanktextdomain'),
					'all_items'						=> esc_html__( 'All Testimonials', 'fruitfulblanktextdomain'),
					'edit_item'						=> esc_html__( 'Edit Testimonial', 'fruitfulblanktextdomain'),
					'new_item'						=> esc_html__( 'New Testimonial', 'fruitfulblanktextdomain'),
					'view_item'						=> esc_html__( 'View Testimonial', 'fruitfulblanktextdomain'),
					'search_items'				=> esc_html__( 'Search Testimonials', 'fruitfulblanktextdomain'),
					'not_found'						=> esc_html__( 'No Testimonials Found', 'fruitfulblanktextdomain'),
					'not_found_in_trash'	=> esc_html__( 'No Testimonials Found in Trash', 'fruitfulblanktextdomain'),
					'parent_item_colon'		=> esc_html__( 'Parent Testimonial:', 'fruitfulblanktextdomain') )
			)
		);

		register_taxonomy( 'dslc_testimonials_cats',
			'dslc_testimonials',
			array(
				'hierarchical'				=> true,
				'show_ui'							=> true,
				'query_var'						=> false,
				'show_in_nav_menus'		=> false,
				'rewrite' 						=> false,
				'show_admin_column'		=> true,
				'labels'							=> array(
					'name'								=> _x( 'Benefits Categories', 'taxonomy general name', 'fruitfulblanktextdomain' ),
					'singular_name'				=> _x( 'Benefits Category', 'taxonomy singular name', 'fruitfulblanktextdomain' ),
					'search_items'				=> esc_html__( 'Search in categories', 'fruitfulblanktextdomain' ),
					'all_items'						=> esc_html__( 'All Categories', 'fruitfulblanktextdomain' ),
					'edit_item'						=> esc_html__( 'Edit Category', 'fruitfulblanktextdomain' ),
					'update_item'					=> esc_html__( 'Update Category', 'fruitfulblanktextdomain' ),
					'add_new_item'				=> esc_html__( 'Add New Category', 'fruitfulblanktextdomain' ),
					'new_item_name'				=> esc_html__( 'New Category', 'fruitfulblanktextdomain' ),
					'menu_name'						=> esc_html__( 'Categories', 'fruitfulblanktextdomain' )
				)
			)
		);

		/**
		 * Forms
		**/
		register_post_type( 'forms',
			array(
				'label'							=> esc_html__( 'Forms', 'fruitfulblanktextdomain'),
				'description'				=> '',
				'public'						=> true,
				'show_ui'						=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' => true,
				'capability_type'		=> 'post',
				'hierarchical'			=> false,
				'supports'					=> array( 'title', 'editor'),
				'rewrite'						=> false,
				'has_archive'				=> false,
				'query_var'					=> false,
				'menu_position'			=> 5,
				'capabilities' => array(
					'publish_posts'				=> 'edit_pages',
					'edit_posts'					=> 'edit_pages',
					'edit_others_posts'		=> 'edit_pages',
					'delete_posts'				=> 'edit_pages',
					'delete_others_posts'	=> 'edit_pages',
					'read_private_posts'	=> 'edit_pages',
					'edit_post'						=> 'edit_pages',
					'delete_post'					=> 'edit_pages',
					'read_post'						=> 'edit_pages',
				),
				'labels' => array(
					'name'								=> esc_html__( 'Forms', 'fruitfulblanktextdomain'),
					'singular_name'				=> esc_html__( 'Form', 'fruitfulblanktextdomain'),
					'menu_name'						=> esc_html__( 'Forms', 'fruitfulblanktextdomain'),
					'add_new'							=> esc_html__( 'Add Form', 'fruitfulblanktextdomain'),
					'add_new_item'				=> esc_html__( 'Add New Form', 'fruitfulblanktextdomain'),
					'all_items'						=> esc_html__( 'All Forms', 'fruitfulblanktextdomain'),
					'edit_item'						=> esc_html__( 'Edit Form', 'fruitfulblanktextdomain'),
					'new_item'						=> esc_html__( 'New Form', 'fruitfulblanktextdomain'),
					'view_item'						=> esc_html__( 'View Form', 'fruitfulblanktextdomain'),
					'search_items'				=> esc_html__( 'Search Forms', 'fruitfulblanktextdomain'),
					'not_found'						=> esc_html__( 'No Forms Found', 'fruitfulblanktextdomain'),
					'not_found_in_trash'	=> esc_html__( 'No Forms Found in Trash', 'fruitfulblanktextdomain'),
					'parent_item_colon'		=> esc_html__( 'Parent Form:', 'fruitfulblanktextdomain') )
			)
		);

	}


}
