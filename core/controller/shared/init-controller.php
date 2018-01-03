<?php
/**
 * Theme init
 **/
class fruitfulblankprefix_init_controller extends fruitfulblankprefix_theme_controller {

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

		// add theme support
		add_action( 'init', array( $this, 'add_theme_support'));

		// register menus
		add_action( 'init', array( $this, 'register_menus'));

		// register sidebars
		add_action( 'widgets_init', array( $this, 'register_sidebars'));

		// Change image crop position
		add_filter( 'image_resize_dimensions', array( $this, 'change_thumbnails_crop_position' ), 10, 6 );

		// Register Custom Post Types and Taxonomies
		add_action( 'init', array( $this, 'register_custom_post_types'), 5);

	}

	/**
	 * Add theme support
	 **/
	function add_theme_support() {
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

	}

	/**
	 * Register theme menus
	 **/
	function register_menus() {
		register_nav_menus( array(
			'header_menu' => esc_html__( 'Header Menu', 'fruitfulblanktextdomain'),
		));
	}

	/**
	 * Register theme sidebars
	 **/
	function register_sidebars() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'fruitfulblanktextdomain' ),
			'id'            => 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Footer widget area #1', 'fruitfulblanktextdomain' ),
			'id'            => 'footer-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Footer widget area #2', 'fruitfulblanktextdomain' ),
			'id'            => 'footer-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Footer widget area #3', 'fruitfulblanktextdomain' ),
			'id'            => 'footer-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Footer widget area #4', 'fruitfulblanktextdomain' ),
			'id'            => 'footer-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));


	}


	/**
	 *	Change thumbnails crop position to top
	 **/
	function change_thumbnails_crop_position( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
		// Change this to a conditional that decides whether you
		// want to override the defaults for this image or not.
		if( false ) {
			return $payload;
		}

		if ( $crop ) {
			// crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
			$aspect_ratio = $orig_w / $orig_h;
			$new_w = min( $dest_w, $orig_w);
			$new_h = min( $dest_h, $orig_h);

			if ( !$new_w ) {
				$new_w = intval( $new_h * $aspect_ratio);
			}

			if ( !$new_h ) {
				$new_h = intval( $new_w / $aspect_ratio);
			}

			$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h);

			$crop_w = round( $new_w / $size_ratio);
			$crop_h = round( $new_h / $size_ratio);

			$s_x = floor( ( $orig_w - $crop_w) / 2 );
			$s_y = 0; // [[ formerly ]] ==> floor( ($orig_h - $crop_h) / 2 );
		} else {
			// don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
			$crop_w = $orig_w;
			$crop_h = $orig_h;

			$s_x = 0;
			$s_y = 0;

			list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
		}

		// if the resulting image would be the same size or larger we don't want to resize it
		if ( $new_w >= $orig_w && $new_h >= $orig_h ) {
			return false;
		}

		// the return array matches the parameters to imagecopyresampled()
		// int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
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

		register_post_type( 'coins',
			array(
				'label'							=> esc_html__( 'Coins', 'fruitfulblanktextdomain'),
				'description'				=> '',
				'public'						=> true,
				'show_ui'						=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' => true,
				'capability_type'		=> 'post',
				'hierarchical'			=> false,
				'supports'					=> array( 'title', 'editor', 'thumbnail' ),
				'rewrite'						=> true,
				'has_archive'				=> false,
				'query_var'					=> true,
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
					'name'								=> esc_html__( 'Coins', 'fruitfulblanktextdomain'),
					'singular_name'				=> esc_html__( 'Coin', 'fruitfulblanktextdomain'),
					'menu_name'						=> esc_html__( 'Coins', 'fruitfulblanktextdomain'),
					'add_new'							=> esc_html__( 'Add Coin', 'fruitfulblanktextdomain'),
					'add_new_item'				=> esc_html__( 'Add New Coin', 'fruitfulblanktextdomain'),
					'all_items'						=> esc_html__( 'All Coins', 'fruitfulblanktextdomain'),
					'edit_item'						=> esc_html__( 'Edit Coin', 'fruitfulblanktextdomain'),
					'new_item'						=> esc_html__( 'New Coin', 'fruitfulblanktextdomain'),
					'view_item'						=> esc_html__( 'View Coin', 'fruitfulblanktextdomain'),
					'search_items'				=> esc_html__( 'Search Coins', 'fruitfulblanktextdomain'),
					'not_found'						=> esc_html__( 'No Coins Found', 'fruitfulblanktextdomain'),
					'not_found_in_trash'	=> esc_html__( 'No Coins Found in Trash', 'fruitfulblanktextdomain'),
					'parent_item_colon'		=> esc_html__( 'Parent Coin:', 'fruitfulblanktextdomain') )
			)
		);

		register_post_type( 'brokers',
			array(
				'label'							=> esc_html__( 'Brokers', 'fruitfulblanktextdomain'),
				'description'				=> '',
				'public'						=> false,
				'show_ui'						=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' => true,
				'capability_type'		=> 'post',
				'hierarchical'			=> false,
				'supports'					=> array( 'title', 'thumbnail' ),
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
					'name'								=> esc_html__( 'Brokers', 'fruitfulblanktextdomain'),
					'singular_name'				=> esc_html__( 'Broker', 'fruitfulblanktextdomain'),
					'menu_name'						=> esc_html__( 'Brokers', 'fruitfulblanktextdomain'),
					'add_new'							=> esc_html__( 'Add Broker', 'fruitfulblanktextdomain'),
					'add_new_item'				=> esc_html__( 'Add New Team Broker', 'fruitfulblanktextdomain'),
					'all_items'						=> esc_html__( 'All Brokers', 'fruitfulblanktextdomain'),
					'edit_item'						=> esc_html__( 'Edit Broker', 'fruitfulblanktextdomain'),
					'new_item'						=> esc_html__( 'New Broker', 'fruitfulblanktextdomain'),
					'view_item'						=> esc_html__( 'View Broker', 'fruitfulblanktextdomain'),
					'search_items'				=> esc_html__( 'Search Brokers', 'fruitfulblanktextdomain'),
					'not_found'						=> esc_html__( 'No Brokers Found', 'fruitfulblanktextdomain'),
					'not_found_in_trash'	=> esc_html__( 'No Brokers found in Trash', 'fruitfulblanktextdomain'),
					'parent_item_colon'		=> esc_html__( 'Parent Broker:', 'fruitfulblanktextdomain') )
			)
		);

		/**
		 * Reviews
		**/
		register_post_type( 'reviews',
			array(
				'label'							=> esc_html__( 'Reviews', 'fruitfulblanktextdomain'),
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
					'name'								=> esc_html__( 'Reviews', 'fruitfulblanktextdomain'),
					'singular_name'				=> esc_html__( 'Review', 'fruitfulblanktextdomain'),
					'menu_name'						=> esc_html__( 'Reviews', 'fruitfulblanktextdomain'),
					'add_new'							=> esc_html__( 'Add Review', 'fruitfulblanktextdomain'),
					'add_new_item'				=> esc_html__( 'Add New Review', 'fruitfulblanktextdomain'),
					'all_items'						=> esc_html__( 'All Reviews', 'fruitfulblanktextdomain'),
					'edit_item'						=> esc_html__( 'Edit Review', 'fruitfulblanktextdomain'),
					'new_item'						=> esc_html__( 'New Review', 'fruitfulblanktextdomain'),
					'view_item'						=> esc_html__( 'View Review', 'fruitfulblanktextdomain'),
					'search_items'				=> esc_html__( 'Search Reviews', 'fruitfulblanktextdomain'),
					'not_found'						=> esc_html__( 'No Reviews Found', 'fruitfulblanktextdomain'),
					'not_found_in_trash'	=> esc_html__( 'No Reviews Found in Trash', 'fruitfulblanktextdomain'),
					'parent_item_colon'		=> esc_html__( 'Parent Review:', 'fruitfulblanktextdomain') )
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
