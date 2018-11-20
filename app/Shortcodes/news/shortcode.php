<?php

if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_News extends WPBakeryShortCode {

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

			// query news
			$posts_query = Starter_Kit()->Model->news->get_news( $atts );

			// collect data for shortcode view
			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
				'query'   => $posts_query
			);

			// enqueue shortcode scripts, here we use AJAX pagination
			wp_register_script( 'shortcode-news', $shortcode_uri . '/assets/scripts.js', array( 'jquery' ),
				Starter_Kit()->config['cache_time'], true );
			wp_register_style( 'shortcode-news-style', $shortcode_uri . '/assets/styles.css' );
			wp_localize_script( 'shortcode-news', 'shortcodeNewsJsParams', array(
				'query_vars'     => json_encode( $posts_query->query_vars ),
				'paged'          => 1,
				'max_num_pages'  => $posts_query->max_num_pages,
				'shortcode_atts' => json_encode( $atts )
			) );
			wp_enqueue_script( 'shortcode-news' );
			wp_enqueue_style( 'shortcode-news-style' );

			// display shortcode template
			return Starter_Kit()->View->load( '/view/view', $data, true, $shortcode_dir );

		}

	}
}
