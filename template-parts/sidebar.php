<?php

use StarterKit\Helper\Utils;

// If Carbon_Fields Framework 

if ( Utils::is_carbon_fields() ) {
	
	// Get sidebar preset from Admin Settings
	$side_classes     = [];
	$current_position = Utils::get_post_meta( get_the_ID(), 'webpage_layout', 'full' );

	$side_preset = null;
	if ( in_array( $current_position, [ 'right', 'left' ], true ) ) {
		$side_preset = Utils::get_post_meta( get_the_ID(), 'webpage_sidebar', null );
	}
	$side_classes[] = $current_position === 'right' ? 'order-2' : 'order-1';
	$side_classes[] = 'col-lg-4';
	
	/**
	 * Full means no sidebar, so if page has a sidebar ...
	 **/
	if ( $current_position !== 'full' ) {
		
		echo '<aside id="sidebar" class="aside ' . implode( ' ', $side_classes ) . '">';
		
		// if we don't have any settings for this page, run defaults
		if ( ! $side_preset ) {
			
			if ( Utils::is_woocommerce() && is_woocommerce() ) {
				
				if ( is_active_sidebar( 'sidebar-shop' ) ) {
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
			dynamic_sidebar( $side_preset );
		}
		
		echo '</aside>';
		
	}

// If No Carbon_Fields Framework, just show a right sidebar
} else {
	
	if ( is_active_sidebar( 'sidebar-right' ) ) {
		?>
		<aside id="sidebar" class="col-lg-4">
			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		</aside>
		<?php
	}
}
?>
