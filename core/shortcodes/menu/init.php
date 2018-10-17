<?php

$menu_locations = get_nav_menu_locations();

foreach ($menu_locations as $slug => $id) {
	// Beautify menu slugs
	$menu_locations[ucwords(str_replace("_", " ", $slug))] = $slug;
	unset($menu_locations[$slug]);
}

$menus_raw = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
$menus = array();

foreach ( $menus_raw as $menu) {
	$menus[$menu->name] = $menu->slug;
}

vc_map( array(
	'name'        => esc_html__( 'Menu', 'fruitfulblanktextdomain' ),
	'base'        => 'menu',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add a menu', 'fruitfulblanktextdomain' ),
	'params'      => array(

		/**
		 *  Menu settings tab
		 **/
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Menu Location', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Theme location to be used.', 'fruitfulblanktextdomain' ),
			'param_name'  => 'menu_location',
			'value'       => $menu_locations,
			'group'       => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Menu', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Desired menu.', 'fruitfulblanktextdomain' ),
			'param_name'  => 'menu',
			'value'       => $menus,
			'group'       => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu ID', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.', 'fruitfulblanktextdomain' ),
			'param_name' => 'menu_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Classes', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'CSS class to use for the ul element which forms the menu. Default \'menu\'.', 'fruitfulblanktextdomain' ),
			'param_name' => 'menu_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Whether to wrap the ul, and what to wrap it with. Default \'div\'', 'fruitfulblanktextdomain' ),
			'param_name' => 'container',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container Class', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Class that is applied to the container. Default \'menu-{menu slug}-container\'', 'fruitfulblanktextdomain' ),
			'param_name' => 'container_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container ID', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'The ID that is applied to the container', 'fruitfulblanktextdomain' ),
			'param_name' => 'container_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Menu Depth', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'How many levels of the hierarchy are to be included. 0 means all. Default 0', 'fruitfulblanktextdomain' ),
			'param_name' => 'depth',
			'value'      => array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
			'group'      => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
		),

		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),

			'group'       => esc_html__( 'Menu Settings', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Unique identifier of this element', 'fruitfulblanktextdomain' ),
		)

	)
) );
