<?php

namespace StarterKit\View;

/**
 * View Class
 *
 * Anything to do with templates
 * and outputting client code
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class View {
	
	/**
	 * Load view. Used on back-end side
	 *
	 * @param string $path
	 * @param array $data
	 * @param bool $return
	 * @param null $base
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	function load( $path = '', array $data = array(), $return = false, $base = null ) {
		
		if ( $base === null ) {
			$base = get_stylesheet_directory();
		}
		
		if ( is_child_theme() ) {
			$full_path = $base . $path;
			if ( ! file_exists( $full_path ) ) {
				$base      = get_template_directory();
				$full_path = $base . $path . '.php';
			}
		} else {
			$full_path = $base . $path . '.php';
		}
		
		if ( $return ) {
			ob_start();
		}
		
		if ( file_exists( $full_path ) ) {
			
			require $full_path;
			
		} else {
			throw new \Exception( 'The view path ' . $full_path . ' can not be found.' );
		}
		
		if ( $return ) {
			return ob_get_clean();
		}
		
	}
	
	/**
	 * Load layout for header / footer built through Visual Composer
	 *
	 * @param string $layout_type
	 *
	 * @return string
	 */
	public function load_composer_layout( $layout_type = 'header' ) {
		global $post;
		$default_layout = '';
		
		$post_id = is_home() ? get_option( 'page_for_posts' ) : ( $post ? $post->ID : 0 );
		
		if ( $post_id
		     && ( is_singular() || is_home() )
		     && ( $this_layout_id = get_post_meta( $post_id, '_this_' . $layout_type, true ) )
		) { // appointment: may be anyone
			if ( $this_layout_id === '_none_' ) { // layout disabled;
				return '';
			}
			$layout = get_post( $this_layout_id );
			if ( $layout && $layout->post_status === 'publish' ) {
				return do_shortcode( apply_filters( 'the_content', $layout->post_content ) );
			} else {
				
				$default_layout_query = Starter_Kit()->Model->Layout->get_default_layout( $layout_type );
				
				if ( $default_layout_query->posts && $default_layout_query->posts[0]->post_status === 'publish' ) {
					return do_shortcode( apply_filters( 'the_content',
						$default_layout_query->posts[0]->post_content ) );
				}
				
			}
			
		} else {
			
			$layouts = Starter_Kit()->Model->Layout->get_layouts( $layout_type );
			
			if ( $layouts->posts ) {
				foreach ( $layouts->posts as $layout ) {
					$_appointment = get_post_meta( $layout->ID, '_appointment', true );
					
					if ( ( $post_id && ( $post_type = get_post_type( $post_id ) ) && $_appointment === $post_type && is_singular() ) ||  // appointment: Any from Post Types (compatibility:post)
					     ( $_appointment === 'is-home' && is_home() ) ||  // appointment: is-home
					     ( $_appointment === 'is-search' && is_search() ) ||  // appointment: is-search
					     ( $_appointment === 'is-archive' && is_archive() ) ||  // appointment: is-archive
					     ( $_appointment === 'is-404' && is_404() )             // appointment: is-404
					
					) {
						return do_shortcode( apply_filters( 'the_content', $layout->post_content ) );
					} elseif ( $_appointment === 'default' ) {  // appointment: default
						$default_layout = $layout;
					}
				}
				
				if ( $default_layout ) {
					return do_shortcode( apply_filters( 'the_content', $default_layout->post_content ) );
				}
				
			}
		}
		
		return '';
	}
	
	/**
	 * Remove wpautop
	 *
	 * @see  wp_js_remove_wpautop()
	 *
	 * @param $content
	 * @param bool $autop
	 *
	 * @return string
	 */
	function js_remove_wpautop( $content, $autop = false ) {
		
		if ( $autop ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}
		
		return do_shortcode( shortcode_unautop( $content ) );
	}
	
}
