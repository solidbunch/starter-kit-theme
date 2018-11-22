<?php

return array(
	'name'                    => esc_html__( 'Toggles', 'starter-kit' ),
	'base'                    => 'toggles',
	'icon'                    => Starter_Kit()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'category'                => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description'             => esc_html__( 'Add accordion / toggles', 'starter-kit' ),
	'as_parent'               => [ 'only' => 'toggle' ],
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => false,
	'params'                  => [
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'starter-kit' ),
			'param_name' => 'classes',
			'value'      => 'accordion',
			'group'      => esc_html__( 'Header Attributes', 'starter-kit' ),
		],
		[
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => [
				'auto_generate' => true,
			],
			'group'       => esc_html__( 'Header Attributes', 'starter-kit' ),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		],
	],
	'js_view'                 => 'VcColumnView'
);