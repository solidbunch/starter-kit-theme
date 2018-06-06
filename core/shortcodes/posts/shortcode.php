<?php

if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_Posts extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if ( !empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			/** Shortcode data to output **/

			$posts_query = FFBLANK()->model->post->get_posts( $atts );

			$data = array(
				'id' => $id,
				'atts' => $atts,
				'content' => $content,
				'query' => $posts_query
			);

			wp_register_script( 'shortcode-posts', $shortcode_uri . '/assets/scripts.js', array('jquery'), FFBLANK()->config['cache_time'], true );
			wp_localize_script( 'shortcode-posts', 'shortcodePostsJsParams', array(
				'query_vars' => json_encode( $posts_query->query_vars ),
				'paged' => 1,
				'max_num_pages' => $posts_query->max_num_pages,
				'shortcode_atts' => json_encode( $atts )
			) );
			wp_enqueue_script( 'shortcode-posts' );

			return FFBLANK()->view->load( '/view/view', $data, true, $shortcode_dir );

		}

	}
}
