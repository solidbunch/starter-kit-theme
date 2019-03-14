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
	 * Model constructor
	 */
	public function __construct() {

		add_action( 'init', function() {
			$this->register_post_type();
		}, 5 );

	}

	/**
	 * Register custom post type
	 */
	public function register_post_type() {

		register_post_type( 'news',
			array(
				'label'             => esc_html__( 'News', 'starter-kit' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => true,
				'query_var'         => false,
				'menu_position'     => 1,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'News', 'starter-kit' ),
					'singular_name'      => esc_html__( 'News Item', 'starter-kit' ),
					'menu_name'          => esc_html__( 'News', 'starter-kit' ),
					'add_new'            => esc_html__( 'Add News', 'starter-kit' ),
					'add_new_item'       => esc_html__( 'Add News', 'starter-kit' ),
					'all_items'          => esc_html__( 'All News', 'starter-kit' ),
					'edit_item'          => esc_html__( 'Edit News', 'starter-kit' ),
					'new_item'           => esc_html__( 'New News', 'starter-kit' ),
					'view_item'          => esc_html__( 'View News', 'starter-kit' ),
					'search_items'       => esc_html__( 'Search News', 'starter-kit' ),
					'not_found'          => esc_html__( 'No News Found', 'starter-kit' ),
					'not_found_in_trash' => esc_html__( 'No News Found in Trash', 'starter-kit' ),
					'parent_item_colon'  => esc_html__( 'Parent News:', 'starter-kit' )
				)
			)
		);

	}

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
