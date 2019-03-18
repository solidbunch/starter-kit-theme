<?php

use StarterKit\Helper\Utils;

// If Unyson Framework plugin is active

if ( Utils::is_unyson() && function_exists( 'fw_ext_sidebars_get_current_position' ) ) {

	// Get sidebar preset from Admin Settings
	$side_classes     = [];
	$current_position = fw_ext_sidebars_get_current_position();
	$side_preset      = fw_ext_sidebars_get_current_preset();
	$side_classes[] 	= $current_position === 'right' ? 'order-2' : 'order-1';
	$side_classes[] 	= 'col-lg-4';

	if ( is_null( $current_position ) ) {
		$current_position = 'right';
	}

	/**
	 * Full means no sidebar, so if page has a sidebar ...
	 **/
	if ( $current_position !== 'full' ) {

		echo '<aside id="sidebar" class="aside ' . implode( ' ', $side_classes ) . '">';

		// if we don't have any settings for this page, run defaults
		if ( is_null( $side_preset ) || ! $side_preset ) {

			if ( Utils::is_woocommerce() && is_woocommerce() ) {

				if (is_active_sidebar( 'sidebar-shop' )) {
					dynamic_sidebar( 'sidebar-shop' );
				}

			} else {

				if ( $current_position === 'left' ) {
					dynamic_sidebar( 'sidebar-left' );
				} else {
					dynamic_sidebar( 'sidebar-right' );
				}

			}

		} else {
			// run sidebar preset from options
			dynamic_sidebar( $side_preset['sidebars']['blue'] );
		}

		echo '</aside>';

	}

// If Unyson Framework is not active, just show a right sidebar
} else {

	if( is_active_sidebar( 'sidebar-right' )) {
		?>
		<aside id="sidebar" class="col-md-3">
			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		</aside>
		<?php
	}

}

?>
