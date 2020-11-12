<?php
/**
 * News Shortcode
 *
 **/

use StarterKit\Base\Shortcode;
use StarterKit\Helper\Assets;
use StarterKit\Helper\View;
use StarterKit\Repository\NewsRepository;

if ( ! class_exists( 'StarterKitShortcode_News' ) ) {
	class StarterKitShortcode_News extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			/** Form data **/
			$atts = shortcode_atts( [
				'el_id'         => '',
				'title'         => '',
				'orderby'       => '',
				'order'         => '',
				'display_thumb' => '',
				'display_title' => ''
			], $this->atts( $atts ), $this->shortcode );
			
			// Query news
			
			$posts_query = NewsRepository::get_news( [
				'order'   => $atts['order'],
				'orderby' => $atts['orderby'],
			] );
			
			// Add styles and scripts
			\StarterKit\Helper\Assets::enqueue_style_dist( 'shortcode-' . $this->shortcode . '-style', 'shortcode-' . $this->shortcode . '.css' );
			Assets::enqueue_script( $this->shortcode . '-script', $this->shortcode_uri . '/assets/scripts.js' );
			Assets::localize_script( $this->shortcode . '-script', 'shortcodeNewsJsParams', [
				'query_vars'     => json_encode( $posts_query->query_vars ),
				'paged'          => 1,
				'max_num_pages'  => $posts_query->max_num_pages,
				'shortcode_atts' => json_encode( $atts )
			] );
			
			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
				'query'   => $posts_query
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}
