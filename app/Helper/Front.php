<?php

namespace StarterKit\Helper;

/**
 * Front Helper
 *
 * Helper functions for templates and front handler
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Front {
	
	/**
	 * Get post / page content classes
	 *
	 * @param int $sidebar_size
	 *
	 * @return string
	 */
	public static function get_grid_class( $sidebar_size = 4 ) {
		
		$classes_string = '';
		
		// If Carbon_Fields Framework is active
		if ( Utils::is_carbon_fields() ) {
			
			$current_sidebar_position = Utils::get_post_meta( get_the_ID(), 'webpage_layout', 'full' );
			
			$content_size = 12 - $sidebar_size;
			
			if ( $current_sidebar_position === 'full' ) {
				$classes_string = 'col-lg-12';
			} elseif ( $current_sidebar_position === 'left' ) {
				$classes_string = 'order-2 col-lg-' . $content_size;
			} else {
				$classes_string = 'order-1 col-lg-' . $content_size;
			}
			
		} else {
			$classes_string = 'col-lg-' . ( 12 - $sidebar_size );
		}
		
		return $classes_string;
	}
	
	
	/**
	 * Get post categories list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_categories( $separator = ', ' ) {
		
		$post_type = \get_post_type();
		
		switch ( $post_type ) {
			default:
			case 'post':
				return self::get_valid_category_list( $separator );
				break;
		}
		
	}
	
	/**
	 * Get valid categories list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_valid_category_list( $separator = ', ' ) {
		$s = str_replace( ' rel="category"', '', \get_the_category_list( $separator ) );
		$s = str_replace( ' rel="category tag"', '', $s );
		
		return $s;
	}
	
	/**
	 * Get valid tags list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_valid_tags_list( $separator = ', ' ) {
		$s = str_replace( ' rel="tag"', '', \get_the_tag_list( '', $separator, '' ) );
		
		return $s;
	}

	/**
	 * Make dynamic year in copyright
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public static function text_copyright_year( $text ) {
		$text = str_replace( '{year}', date('Y'), $text );

		return $text;
	}
	
}
