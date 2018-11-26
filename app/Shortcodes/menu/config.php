<?php

$menus_raw = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
$menus = array();

foreach ( $menus_raw as $menu) {
	$menus[$menu->name] = $menu->slug;
}

return array(
	'name'        => esc_html__( 'Menu', 'starter-kit' ),
	'base'        => 'menu',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add a menu', 'starter-kit' ),
	'params'      => array(

		/**
		 *  Menu settings tab
		 **/

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Menu', 'starter-kit' ),
			'description' => esc_html__( 'Desired menu.', 'starter-kit' ),
			'param_name'  => 'menu',
			'value'       => $menus,
			'group'       => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu ID', 'starter-kit' ),
			'description' => esc_html__( 'The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.', 'starter-kit' ),
			'param_name' => 'menu_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Classes', 'starter-kit' ),
			'description' => esc_html__( 'CSS class to use for the ul element which forms the menu. Default \'menu\'.', 'starter-kit' ),
			'param_name' => 'menu_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container', 'starter-kit' ),
			'description' => esc_html__( 'Whether to wrap the ul, and what to wrap it with. Default \'div\'', 'starter-kit' ),
			'param_name' => 'container',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container Class', 'starter-kit' ),
			'description' => esc_html__( 'Class that is applied to the container. Default \'menu-{menu slug}-container\'', 'starter-kit' ),
			'param_name' => 'container_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container ID', 'starter-kit' ),
			'description' => esc_html__( 'The ID that is applied to the container', 'starter-kit' ),
			'param_name' => 'container_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Menu Depth', 'starter-kit' ),
			'description' => esc_html__( 'How many levels of the hierarchy are to be included. 0 means all. Default 0', 'starter-kit' ),
			'param_name' => 'depth',
			'value'      => array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
			'group'      => esc_html__( 'Menu Settings', 'starter-kit' ),
		),

		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Menu Settings', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		)

	)
);
