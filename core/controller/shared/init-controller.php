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

	}

	/**
	 * Add theme support
	 **/
	function add_theme_support() {
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'menus' );
		add_theme_support( 'woocommerce' );
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
			'name'          => esc_html__( 'Left Sidebar', 'fruitfulblanktextdomain' ),
			'id'            => 'sidebar-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'fruitfulblanktextdomain' ),
			'id'            => 'sidebar-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'fruitfulblanktextdomain' ),
			'id'            => 'sidebar-shop',
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


}
