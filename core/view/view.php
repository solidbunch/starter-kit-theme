<?php

	/**
	 * Anything to do with templates
	 * and outputting client code
	**/
	class fruitfulblankprefix_core_view extends fruitfulblankprefix_theme_controller {

		function __construct() {

			parent::__construct();
			$this->run();

		}

		function run() {

			// Load shortcode template
			add_filter( 'load_shortcode_tpl', array( $this, 'load_shortcode_tpl' ), 10, 3 );

			// Header/Footer display hook
			add_filter( 'get_composer_layout', array( $this, 'get_composer_layout' ) );

		}

		/*
		* Template connect function
		* Used in shortcodes and in global views
		*
		* @param mixed $template The path to template file without .php. Can be string or array of strings.
		* @param array $data Data that need to output in templeate file
		* @return string Output view data
		*/
		public function load_shortcode_tpl( $template, $data = array(), $views_dir = _FBCONSTPREFIX_SHORTCODES_DIR_ ) {

			if( !is_array( $template) ){

				ob_start();
				require( $views_dir . $template . '.php' );
				$output = ob_get_clean();

			} else{

				foreach( $template as $name => $value ){
					ob_start();
					require( $views_dir . $value . '.php' );
					$output[$name] = ob_get_clean();
				}

			}

			return isset( $output) ? $output : '';
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

					$default_layout_query = $this->model->layout->default_layout_query($layout_type);

					if ( $default_layout_query->posts && $default_layout_query->posts[0]->post_status === 'publish' ) {
						return do_shortcode( $default_layout_query->posts[0]->post_content );
					}

				}

			} else {

				$layouts = $this->model->layout->layouts($layout_type);

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

		/**
		 * Load view. Used on back-end side
		**/
		function load( $path = '', $data = array() ) {

 			$base = get_stylesheet_directory();

			if( is_child_theme() ) {
				$full_path = $base . $path;
				if( ! file_exists( $full_path ) ) {
					$base = get_template_directory();
					$full_path = $base . $path;
				}
			} else {
				$full_path = $base . $path;
			}

			if( ! file_exists( $full_path ) ) {
				$full_path = get_template_directory() . '/core/view/' . $path . '.php';
			}

			if ( file_exists( $full_path ) ) {
				require $full_path;
			} else {
				throw new Exception( 'The view path ' . $full_path . ' can not be found.' );
			}

		}

	}
