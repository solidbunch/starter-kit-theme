<?php

namespace StarterKit\Handlers\PostTypes;

/**
 * ComposerLayout
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class ComposerLayout {
	
	public static function register_post_type() {
		
		register_post_type( 'composerlayout', [
			'label'               => esc_html__( 'Header / Footer', 'starter-kit' ),
			'description'         => '',
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'_builtin'            => false,
			'show_in_menu'        => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'rewrite'             => false,
			'query_var'           => true,
			'supports'            => [ 'title', 'editor' ],
			'labels'              => [
				'name'               => esc_html__( 'Header / Footer', 'starter-kit' ),
				'singular_name'      => esc_html__( 'Header / Footer', 'starter-kit' ),
				'menu_name'          => esc_html__( 'Header / Footer', 'starter-kit' ),
				'add_new'            => esc_html__( 'Add New Header / Footer', 'starter-kit' ),
				'add_new_item'       => esc_html__( 'Add New Header / Footer', 'starter-kit' ),
				'edit'               => esc_html__( 'Edit', 'starter-kit' ),
				'edit_item'          => esc_html__( 'Edit Header / Footer', 'starter-kit' ),
				'new_item'           => esc_html__( 'New Header / Footer', 'starter-kit' ),
				'view'               => esc_html__( 'View Header / Footer', 'starter-kit' ),
				'view_item'          => esc_html__( 'View Header / Footer', 'starter-kit' ),
				'search_items'       => esc_html__( 'Search Header / Footer', 'starter-kit' ),
				'not_found'          => esc_html__( 'No Header / Footer Found', 'starter-kit' ),
				'not_found_in_trash' => esc_html__( 'No Header / Footer Found in Trash', 'starter-kit' ),
				'parent'             => esc_html__( 'Parent Header / Footer', 'starter-kit' ),
			],
		] );
	}
}
