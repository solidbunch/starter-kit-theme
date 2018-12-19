<?php

return array(
	'name'        => esc_html__( 'Map', 'starter-kit' ),
	'base'        => 'google_map',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'map-location.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add Google Map', 'starter-kit' ),
	'params'      => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Google API Key', 'starter-kit' ),
			'description' => esc_html__( 'Insert here your Google API Key to avoid request limitations and JavaScript errors.',
				'starter-kit' ),
			'param_name'  => 'api_key',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Address', 'starter-kit' ),
			'param_name' => 'address',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Map Height', 'starter-kit' ),
			'param_name' => 'height',
			'value'      => '650',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Map zoom', 'starter-kit' ),
			'param_name'  => 'zoom',
			'save_always' => true,
			'value'       => array(
				'16' => '16',
				'15' => '15',
				'14' => '14',
				'13' => '13',
				'12' => '12',
				'11' => '11',
				'10' => '10',
				'9'  => '9',
				'8'  => '8',
				'7'  => '7',
				'6'  => '6',
				'5'  => '5',
				'4'  => '4',
				'3'  => '3',
				'2'  => '2',
				'1'  => '1',
			),
		),

		array(
			'type'       => 'attach_image',
			'heading'    => esc_html__( 'Pin Icon', 'starter-kit' ),
			'param_name' => 'pin_icon',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pin offset X', 'starter-kit' ),
			'param_name' => 'pin_offset_x',
			'value'      => 0,
			'default'    => 0,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pin offset Y', 'starter-kit' ),
			'param_name' => 'pin_offset_y',
			'value'      => 0,
			'default'    => 0,
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Unique identifier of this element', 'starter-kit' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Hue', 'starter-kit' ),
			'param_name' => 'hue',
			'value'      => '#e5e5e5',
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Saturation', 'starter-kit' ),
			'param_name' => 'saturation',
			'value'      => '-100',
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Lightness', 'starter-kit' ),
			'param_name' => 'lightness',
			'value'      => '50',
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Gamma', 'starter-kit' ),
			'param_name' => 'gamma',
			'value'      => '1',
			'group'      => esc_html__( 'Styling', 'starter-kit' ),
		),

	)
);
