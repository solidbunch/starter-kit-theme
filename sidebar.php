<?php
	/**
	 * Sidebar template
	 **/

	// If Unyson Framework plugin is active
	if( function_exists('fw_ext_sidebars_get_current_position') ) {

		// Get sidebar preset from Admin Settings
		$side_classes = array();
		$current_position = fw_ext_sidebars_get_current_position();
		$current_position = $current_position == '' ? 'full' : $current_position;
		$side_preset = fw_ext_sidebars_get_current_preset();

		$sidebar_size = fw_get_db_customizer_option( 'sidebar_size' );
		$sidebar_size = 4;

		$side_classes[] = 'sidebar-pos-' . $current_position;
		$side_classes[] = 'col-md-' . $sidebar_size;

		/**
		 * Full means no sidebar, so if page has a sidebar ...
		 **/
		if ( $current_position !== 'full' ) {

			echo '<aside id="sidebar" class="aside ' . implode( ' ', $side_classes) . '">';

			// if we don't have any settings for this page, run defaults
			if( is_null( $side_preset ) || ! $side_preset ) {

				if( $current_position === 'left' ) {
					dynamic_sidebar( 'sidebar' );
				} else {
					dynamic_sidebar( 'sidebar' );
				}

			} else {
				// run sidebar preset from options
				dynamic_sidebar( $side_preset['sidebars']['blue'] );
			}
			echo '</aside>';

		}

	// If Unyson Framework is not active, just show a right sidebar
	} else {

		?>
		<aside id="sidebar" class="col-md-3">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</aside>
		<?php

	}
