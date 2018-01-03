<?php
	/**
	 * Front helper
	 **/
	class fruitfulblankprefix_front {

		/**
		 * Get post / page content classes
		 **/
		public static function get_grid_class() {

			$classes_string = '';

			// If Unyson Framework plugin is active
			if( function_exists('fw_ext_sidebars_get_current_position') ) {

				$current_sidebar_position = fw_ext_sidebars_get_current_position();
				$current_sidebar_position = $current_sidebar_position == '' ? 'full' : $current_sidebar_position;
				$sidebar_size = 4;

				$content_size = 12 - $sidebar_size;

				if( $current_sidebar_position == 'full' ) {
					$classes_string = 'col-md-12';
				} elseif( $current_sidebar_position == 'left' ) {
					$classes_string = 'col-md-' . $content_size;
				} else {
					$classes_string = 'col-md-' . $content_size;
				}

			} else {
				$classes_string = 'col-md-8';
			}

			return $classes_string;

		}

	}
