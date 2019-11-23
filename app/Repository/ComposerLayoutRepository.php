<?php

namespace StarterKit\Repository;

use StarterKit\Helper\Utils;

/**
 * ComposerLayout Repository
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class ComposerLayoutRepository {
	
	/**
	 * Get default composer layout
	 *
	 * @param string $layout_type
	 *
	 * @return \WP_Query
	 */
	public static function get_default_layout( $layout_type = 'header' ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		
		$args                 = [
			'post_type'      => 'composerlayout',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'   => $prefix . '_layouttype',
					'value' => $layout_type,
				],
				[
					'key'   => $prefix . '_appointment',
					'value' => 'default',
				],
			
			],
		];
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
	public static function get_layouts( $layout_type = 'header' ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		
		$args    = [
			'post_type'      => 'composerlayout',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_query'     => [
				'composerlayout_layouttype' => [
					'key'   => $prefix . '_layouttype',
					'value' => $layout_type,
				],
			],
			'order'          => 'ASC',
		];
		$layouts = new \WP_Query( $args );
		wp_reset_query();
		
		return $layouts;
	}
}
