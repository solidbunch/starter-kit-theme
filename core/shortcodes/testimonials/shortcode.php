<?php

/**
  * Testimonials Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_fruitfulblankprefix_Testimonials extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			$id = 'shortcode-' . $atts['el_id'];

			$assets_path = get_template_directory_uri() . '/core/shortcodes/testimonials/assets';

			wp_enqueue_style( 'fruitfulblankprefix-testimonials', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

			wp_register_script( 'fruitfulblankprefix-testimonials', $assets_path . '/scripts.js', array( 'jquery', 'slick-carousel' ) );
			wp_enqueue_script( 'fruitfulblankprefix-testimonials' );


			$items = $this->get_testimonials($atts);
			
			/** Shortcode data to output **/
			$data = array(
				'items' => $items,
			);
			
			return apply_filters('theme_get_template', 'view', $data, dirname( __FILE__ ).'/view/');
      
		}
		
		protected function get_testimonials($atts){
			
			$q_array = array(
				'post_type' => 'dslc_testimonials',
				'post_status' => 'publish',
				'posts_per_page' => absint( $atts['posts_per_page'] ),
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
			);

			return new WP_Query( $q_array );
		}

	}
}