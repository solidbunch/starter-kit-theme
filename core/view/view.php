<?php

	/**
	 * Anything to do with templates
	 * and outputting client code
	**/
	class fruitfulblankprefix_core_view extends fruitfulblankprefix_theme_controller {

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