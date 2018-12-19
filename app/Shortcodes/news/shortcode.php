<?php
/**
 * News Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_News' ) ) {
	class StarterKitShortcode_News extends Shortcode {

		public function content( $atts, $content = null ) {

			/** Form data **/
			$atts = shortcode_atts( [
				'el_id'           => '',
				'title'           => '',
				'orderby'         => '',
				'order'           => '',
				'display_thumb'   => '',
				'display_title'   => ''
			], $this->atts($atts), $this->shortcode );

			// Query news

			$posts_query = Starter_Kit()->Model->News->get_news( [
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
			]);

			// Add styles and scripts
			$this->enqueue_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/scripts.js' );
			$this->enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );
			$this->localize_script( $this->shortcode.'-script', 'shortcodeNewsJsParams', array(
				'query_vars'     => json_encode( $posts_query->query_vars ),
				'paged'          => 1,
				'max_num_pages'  => $posts_query->max_num_pages,
				'shortcode_atts' => json_encode( $atts )
			) );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content,
				'query'   => $posts_query
			]);

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}