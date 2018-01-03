<?php
	/**
	 * Utils helper
	 **/
	class fruitfulblankprefix_utils {

		/**
		 * Get post categories list
		 **/
		public static function get_categories( $separator = ', ' ) {

			$post_type = get_post_type();

			switch( $post_type ) {
				default:
				case 'post':
					return self::get_valid_category_list( $separator );
				break;
			}

		}

		/**
		 * Get valid categories list
		 **/
		public static function get_valid_category_list( $separator = ', ' ) {
			$s = str_replace( ' rel="category"', '', get_the_category_list( $separator ) );
			$s = str_replace( ' rel="category tag"', '', $s );
			return $s;
		}

		/**
		 * Get valid tags list
		 **/
		public static function get_valid_tags_list( $separator = ', ' ) {
			$s = str_replace( ' rel="tag"', '', get_the_tag_list( '', $separator, '' ) );
			return $s;
		}

		/**
		 * Make sure that Visual Composer is active
		 **/
		public static function is_vc() {
			return in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

	}
