<?php
/**
 * Post model
**/
class fruitfulblankprefix_post_model extends fruitfulblankprefix_database {

	/**
	 * Get popular posts
	 **/
	function get_popular_posts( $post_type, $limit ) {
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'order' => 'DESC',
			'ignore_sticky_posts' => true,
			'orderby' => 'comment_count'
		);

		return new WP_Query( $args );
	}

	/**
	 * Get recent posts
	 **/
	function get_recent_posts( $post_type, $limit ) {
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'order' => 'DESC',
			'ignore_sticky_posts' => true
		);

		return new WP_Query( $args );
	}

	/**
	 * Get related posts
	 **/
	function get_related_posts( $primary_post_id, $limit, $taxonomy = 'category', $with_thumbnail_only = false ) {

		$terms = wp_get_post_terms( $primary_post_id, $taxonomy );

		$response = false;

		if( count( $terms ) > 0 ) {

			$post_type = get_post_type( $primary_post_id );
			$post_terms_ids = array();

			foreach( $terms as $term ) {
				$post_terms_ids[] = $term->term_id;
			}

			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'order' => 'DESC',
				'orderby' => 'rand',
				'ignore_sticky_posts' => true,
				'post__not_in' => array( $primary_post_id ),
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => $taxonomy,
						'field' => 'id',
						'terms' => $post_terms_ids
					)
				)
			);

			if( $with_thumbnail_only ) {
				$args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			$response = new WP_Query( $args );

		}

		return $response;
	}

	/**
	 * Get random posts
	 **/
	function get_random_posts( $post_type, $limit, $with_thumbnail_only = false ) {
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'ignore_sticky_posts' => true,
			'orderby' => 'rand'
		);

		if( $with_thumbnail_only ) {
			$args['meta_query'][] = array(
				'key' => '_thumbnail_id'
			);
		}

		return new WP_Query( $args );
	}

}
