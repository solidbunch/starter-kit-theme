<?php
/**
 * News Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Posts' ) ) {
	class StarterKitShortcode_Posts extends Shortcode {

		public function content( $atts, $content = null ) {

			/** Form data **/
			$atts = shortcode_atts( [
				'el_id'             => '',
				'post_type'         => '',
				'posts_per_page'    => '',
				'orderby'           => '',
				'order'             => '',
				'tax_query_type'    => '',
				'taxonomy_slug'     => '',
				'taxonomy_terms'    => '',

				'pagination'        => '',
				'ajax_load_more_button_text' => '',

				'display_thumb'     => '',
				'display_title'     => '',
				'display_excerpt'   => '',
				'excerpt_length'    => '',
				'thumbs_dimensions' => '',
				'thumb_width'       => '',
				'thumb_height'      => ''
			], $this->atts($atts), $this->shortcode );

			// Query news
			$posts_query = Starter_Kit()->Model->Post->get_posts( $atts );


			// Add styles and scripts
			$this->enqueue_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/scripts.js' );
			$this->localize_script( $this->shortcode.'-script', 'shortcodePostsJsParams', array(
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