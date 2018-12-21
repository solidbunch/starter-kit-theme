<?php
namespace StarterKit\Model;

/**
 * Layout model
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Layout {

	/**
	 * Get default composer layout
	 *
	 * @param string $layout_type
	 *
	 * @return \WP_Query
	 */
	public function get_default_layout( $layout_type = 'header' ) {
		$args                 = array(
			'post_type'      => 'composerlayout',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => '_layouttype',
					'value' => $layout_type,
				),
				array(
					'key'   => '_appointment',
					'value' => 'default',
				),

			)
		);
		$default_layout_query = new \WP_Query( $args );
		wp_reset_query();

		return $default_layout_query;
	}

	/**
	 * Get all composer layouts
	 *
	 * @param string $layout_type
	 *
	 * @return \WP_Query
	 */
	public function get_layouts( $layout_type = 'header' ) {

		$args    = array(
			'post_type'      => 'composerlayout',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_query'     => array(
				'composerlayout_layouttype' => array(
					'key'   => '_layouttype',
					'value' => $layout_type,
				),
			),
			'order'          => 'ASC',
		);
		$layouts = new \WP_Query( $args );
		wp_reset_query();

		return $layouts;
	}
}
