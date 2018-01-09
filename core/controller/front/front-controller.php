<?php

/**
 * Front side controller
 **/
class fruitfulblankprefix_front_controller extends fruitfulblankprefix_theme_controller {

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
		//add_action( 'wp_enqueue_scripts', array( $this, 'remove_assets' ), 99, 1 );
		
		// Header/Footer display hook
		add_filter( 'get_composer_layout', array( $this, 'get_composer_layout' ) );
		
		// Template connect hook
		add_filter( 'theme_get_template', array( $this, 'theme_get_template' ), 10, 3);

		// Change excerpt dots
		//add_filter( 'excerpt_more', array( $this, 'change_excerpt_more' ) );

		// remove empty paragraphs
		//add_filter('the_content', array( $this, 'remove_empty_p' ), 20, 1);

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
		wp_register_script( 'fruitfulblankprefix-front', get_template_directory_uri() . '/assets/js/front.js', array( 'jquery' ), _FBCONSTPREFIX_CACHE_TIME_, true );

		$js_vars = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'assetsPath' => get_template_directory_uri() . '/assets',
		);

		wp_enqueue_script( 'fruitfulblankprefix-front' );
		wp_localize_script( 'fruitfulblankprefix-front', 'bvcJsVars', $js_vars );

		// CSS styles
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/libs/bootstrap.css', false, _FBCONSTPREFIX_CACHE_TIME_ );
		wp_enqueue_style( 'fruitfulblankprefix-base-style', get_template_directory_uri() . '/assets/css/front-base.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

	}

	function remove_assets() {
		wp_dequeue_style( 'fw-ext-breadcrumbs-add-css' );
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
	 * Header || Footer output
	 */
	function get_composer_layout( $layout_type = 'header' ) {
		global $post;
		$default_layout = '';
		
		$postID = is_home() ? get_option( 'page_for_posts' ) : ( $post ? $post->ID : 0 );
		
		if ( $postID && (is_singular() || is_home()) && ( $this_layout_id = get_post_meta( $postID, '_this_' . $layout_type, true ) ) ) { // appointment: may be anyone
			if ( $this_layout_id === '_none_' ) { // layout disabled;
				return '';
			}
			$layout = get_post( $this_layout_id );
			if ( $layout && $layout->post_status === 'publish' ) {
				return do_shortcode( $layout->post_content );
			} else {
				
				$default_layout_query = $this->model->frontmodel->default_layout_query($layout_type);

				if ( $default_layout_query->posts && $default_layout_query->posts[0]->post_status === 'publish' ) {
					return do_shortcode( $default_layout_query->posts[0]->post_content );
				}
				
			}
			
		} else {
			
			$layouts = $this->model->frontmodel->layouts($layout_type);
			
			if ( $layouts->posts ) {
				foreach ( $layouts->posts as $layout ) {
					$_appointment = get_post_meta( $layout->ID, '_appointment', true );
					
					if ( ( $postID && ( $post_type = get_post_type( $postID ) ) && $_appointment === $post_type && is_singular() ) ||  // appointment: Any from Post Types (compatibility:post)
						 ( $_appointment === 'is-home' && is_home() ) ||  // appointment: is-home	
						 ( $_appointment === 'is-search' && is_search() ) ||  // appointment: is-search
						 ( $_appointment === 'is-archive' && is_archive() ) ||  // appointment: is-archive
						 ( $_appointment === 'is-404' && is_404() )             // appointment: is-404
					
					) {
						return do_shortcode( $layout->post_content );
					} elseif ( $_appointment === 'default' ) {  // appointment: default
						$default_layout = $layout;
					}
				}

				if ( $default_layout ) {
					return do_shortcode( $default_layout->post_content );
				}
				
			}
		}
		
		return '';
	}
	
	/*
	* Template connect function
	* Used in shortcodes and in global views
	*
	* @param mixed $template The path to template file without .php. Can be string or array of strings.
	* @param array $data Data that need to output in templeate file
	* @return string Output view data
	*/
	public function theme_get_template($template, $data = array(), $views_dir = _FBCONSTPREFIX_VIEW_DIR_) {

		if(!is_array($template)){
			ob_start();
			require( $views_dir . $template . '.php');
			$output = ob_get_clean();
		} else{
			foreach ($template as $name => $value){
				ob_start();
				require( $views_dir . $value . '.php');
				$output[$name] = ob_get_clean();
			}
		}

		return isset($output)?$output:'';
	}


}
