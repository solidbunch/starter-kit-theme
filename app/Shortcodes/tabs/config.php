<?php

return [
	'name'                    => esc_html__( 'Tabs', 'starter-kit' ),
	'base'                    => 'tabs',
	'icon'                    => Starter_Kit()->config['shortcodes_icon_uri'] . 'tabs.svg',
	'category'                => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description'             => esc_html__( 'Add Tabs', 'starter-kit' ),
	'as_parent'               => [ 'only' => 'tab' ],
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => true,
	'params'                  => [
		[
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Position Tabs', 'starter-kit' ),
			'description' => esc_html__( 'Please select position', 'starter-kit' ),
			'param_name'  => 'position',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'Vertical', 'starter-kit' )   => 'vertical',
				esc_html__( 'Horizontal', 'starter-kit' ) => 'horizontal',
			),
			'group'       => esc_html__( 'Tabs', 'starter-kit' ),
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'classes',
			'value'      => 'starter-kit_tabs',
			'group'      => esc_html__( 'Header Attributes', 'starter-kit' ),
		],
		[
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Tabs', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		],
	],
	'js_view'                 => is_admin() ? 'VcColumnView' : ''
];