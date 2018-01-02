<?php

/**
 * Front side controller
 **/
class bvc_front_controller extends bvc_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run front-end actions
	**/
	function run() {

		// add site icon
		add_action( 'wp_head', array( $this, 'add_site_icon' ) );

		// load assets
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'remove_assets' ), 99, 1 );

		// Add webste title
		add_filter( 'wp_title',  array( $this, 'wp_title' ), 10, 2 );

		// Change excerpt dots
		add_filter( 'excerpt_more', array( $this, 'change_excerpt_more' ) );

		// remove empty paragraphs
		add_filter('the_content', array( $this, 'remove_empty_p' ), 20, 1);

		// Custom search form
		add_filter( 'get_search_form', array( $this, 'custom_search_template' ) );

		//Add hotspot tracking
		add_action( 'init', array( $this, 'add_hotspot_tracking_cookie' ) );

		// Add Google Tag Manager
				//Add hotspot tracking
		add_action( 'wp_head', array( $this, 'add_google_tag_manager' ) );

	}

	/**
	 * Add site icon from customizer
	**/
	function add_site_icon() {

		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			wp_site_icon();
		}

	}

	/**
	 * Load JavaScript and CSS files in a front-end
	**/
	function load_assets() {

		// JS scripts
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'slick-carousel', get_template_directory_uri() . '/assets/libs/slick/slick.min.js', array( 'jquery' ), _BVC_CACHE_TIME_, true );
		wp_register_script( 'star-rating-svg', get_template_directory_uri() . '/assets/libs/star-rating-svg/jquery.star-rating-svg.min.js', array( 'jquery' ), _BVC_CACHE_TIME_, true );
		wp_register_script( 'particles', get_template_directory_uri() . '/assets/libs/particles.min.js', array( 'jquery' ), _BVC_CACHE_TIME_, true );
		wp_register_script( 'uiforms', get_template_directory_uri() . '/assets/libs/jquery.uiforms.js', array( 'jquery' ), _BVC_CACHE_TIME_, true );
		wp_register_script( 'animate-number', get_template_directory_uri() . '/assets/libs/jquery.animateNumber.min.js', array( 'jquery' ), _BVC_CACHE_TIME_, true );
		wp_register_script( 'bvc-front', get_template_directory_uri() . '/assets/js/front.js', array( 'jquery', 'uiforms' ), _BVC_CACHE_TIME_, true );

		$js_vars = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'assetsPath' => get_template_directory_uri() . '/assets',
		);

		wp_enqueue_script( 'slick-carousel' );
		wp_enqueue_script( 'particles' );
		wp_enqueue_script( 'uiforms' );
		wp_enqueue_script( 'bvc-front' );
		wp_localize_script( 'bvc-front', 'bvcJsVars', $js_vars );

		// CSS styles
		wp_register_style( 'star-rating-svg', get_template_directory_uri() . '/assets/libs/star-rating-svg/star-rating-svg.css', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:300,400,500,700,800', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'slick-carousel', get_template_directory_uri() . '/assets/libs/slick/slick.css', array(), _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'slick-carousel-theme', get_template_directory_uri() . '/assets/libs/slick/slick-theme.css', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/libs/bootstrap.css', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'bvc-base-style', get_template_directory_uri() . '/assets/css/front-base.css', false, _BVC_CACHE_TIME_ );
		wp_enqueue_style( 'vc_customizations', get_template_directory_uri() . '/assets/css/vc_customizations.css', false, _BVC_CACHE_TIME_ );

	}

	function remove_assets() {
		wp_dequeue_style( 'fw-ext-breadcrumbs-add-css' );
	}

	/**
	 * Add website title
	 **/
	function wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		if( is_home() || is_front_page() ) {
			return $title;
		}

		return $title . ' ' . $sep . ' ' . get_bloginfo( 'description' );

	}

	/**
	 * Change excerpt More text
	 **/
	function change_excerpt_more( $more ) {
		return '…';
	}

	/**
	 * Remove empty paragraphs from post content
	 **/
	function remove_empty_p( $content ) {
		$content = str_replace( '<p></p>', '', $content );
		$content = str_replace( '<p>&nbsp;</p>', '', $content );
		return $content;
	}

	/**
	 * Custom search template
	 **/
	function custom_search_template() {
		ob_start();
		get_template_part( '/template-parts/search-form' );
		return ob_get_clean();
	}

	/**
	 * Add hotspot tracking
	 **/
	function add_hotspot_tracking_cookie() {

		if(isset($_GET['source']) && $_GET['source'] != ''){
		   setcookie('marketing_source', $_GET['source'], time() + (86400 * 30), '/');
		}
	}

	/**
	 * Add Google Tag Manager to Header
	**/
	function add_google_tag_manager() {
		?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PCNFWHZ');</script>
		<!-- End Google Tag Manager -->
		<?php
	}

}
