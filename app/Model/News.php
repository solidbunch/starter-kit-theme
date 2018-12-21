<?php
namespace StarterKit\Model;

/**
 * News model
 *
 * Works with news post type
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class News extends Database {

	/**
	 * Get news by params
	 *
	 * @param $args
	 *
	 * @return \WP_Query
	 */
	public function get_news( $args ) {

		$defaults = array(
			'post_type'      => 'news',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'order'          => 'DESC',
			'orderby'        => 'date'
		);

		$args = wp_parse_args( $args, $defaults );

		if ( isset( $args['tax_query_type'] ) ) {

			$_taxonomy_slug  = $args['taxonomy_slug'];
			$_taxonomy_terms = explode( ',', $args['taxonomy_terms'] );

			if ( $args['tax_query_type'] === 'only' ) {

				$args['tax_query'] = array(
					array(
						'taxonomy' => $_taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $_taxonomy_terms,
					)
				);

			} elseif ( $args['tax_query_type'] === 'except' ) {

				$args['tax_query'] = array(
					array(
						'taxonomy' => $_taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $_taxonomy_terms,
						'operator' => 'NOT IN',
					)
				);

			}

		}

		return new \WP_Query( $args );
	}

	/**
	 * Get popular news
	 *
	 * @param $limit
	 *
	 * @return \WP_Query
	 */
	public function get_popular_news( $limit ) {
		$args = array(
			'post_type'           => 'news',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
			'orderby'             => 'comment_count'
		);

		return new \WP_Query( $args );
	}

	/**
	 * Get recent news
	 *
	 * @param $limit
	 *
	 * @return \WP_Query
	 */
	public function get_recent_news( $limit ) {
		$args = array(
			'post_type'           => 'news',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'order'               => 'DESC',
			'ignore_sticky_posts' => true
		);

		return new \WP_Query( $args );
	}

	/**
	 * Get related news
	 *
	 * @param $primary_news_id
	 * @param $limit
	 * @param string $taxonomy
	 * @param bool $with_thumbnail_only
	 *
	 * @return bool|\WP_Query
	 */
	public function get_related_news( $primary_news_id, $limit, $taxonomy = 'category', $with_thumbnail_only = false ) {

		$terms = wp_get_post_terms( $primary_news_id, $taxonomy );

		$response = false;

		if ( count( $terms ) > 0 ) {

			$post_type      = get_post_type( $primary_news_id );
			$post_terms_ids = array();

			foreach ( $terms as $term ) {
				$post_terms_ids[] = $term->term_id;
			}

			$args = array(
				'post_type'           => $post_type,
				'post_status'         => 'publish',
				'posts_per_page'      => $limit,
				'order'               => 'DESC',
				'orderby'             => 'rand',
				'ignore_sticky_posts' => true,
				'post__not_in'        => array( $primary_news_id ),
				'tax_query'           => array(
					'relation' => 'OR',
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'id',
						'terms'    => $post_terms_ids
					)
				)
			);

			if ( $with_thumbnail_only ) {
				$args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			$response = new \WP_Query( $args );

		}

		return $response;
	}

	/**
	 * Get random news
	 *
	 * @param $limit
	 * @param bool $with_thumbnail_only
	 *
	 * @return \WP_Query
	 */
	public function get_random_news( $limit, $with_thumbnail_only = false ) {
		$args = array(
			'post_type'           => 'news',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
			'orderby'             => 'rand'
		);

		if ( $with_thumbnail_only ) {
			$args['meta_query'][] = array(
				'key' => '_thumbnail_id'
			);
		}

		return new \WP_Query( $args );
	}

}
