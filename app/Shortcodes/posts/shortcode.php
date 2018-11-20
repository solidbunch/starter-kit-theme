<?php

if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_Posts extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			// define path vars
			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \StarterKit\Helper\Utils::get_shortcodes_uri( $shortcode );

			// get shortcode attributes
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			// query posts
			$posts_query = Starter_Kit()->Model->post->get_posts( $atts );

			// collect data for shortcode view
			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
				'query'   => $posts_query
			);

			// enqueue shortcode scripts, here we use AJAX pagination
			wp_register_script( 'shortcode-posts', $shortcode_uri . '/assets/scripts.js', array( 'jquery' ),
				Starter_Kit()->config['cache_time'], true );
			wp_localize_script( 'shortcode-posts', 'shortcodePostsJsParams', array(
				'query_vars'     => json_encode( $posts_query->query_vars ),
				'paged'          => 1,
				'max_num_pages'  => $posts_query->max_num_pages,
				'shortcode_atts' => json_encode( $atts )
			) );
			wp_enqueue_script( 'shortcode-posts' );

			// display shortcode template
			return Starter_Kit()->View->load( '/view/view', $data, true, $shortcode_dir );

		}

	}
}
