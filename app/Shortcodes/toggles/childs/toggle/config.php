<?php

use StarterKit\Helper\Utils;

return [
	'name'            => esc_html__( 'Toggle Section', 'starter-kit' ),
	'base'            => 'toggle',
	'icon'            => Utils::getConfigSetting( 'shortcodes_icon_uri' ) . 'toggle.svg',
	'content_element' => true,
	'as_child'        => [ 'only' => 'toggles' ],
	'params'          => [
		
		[
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		],
		[
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Text', 'starter-kit' ),
			'param_name' => 'content',
			'value'      => '',
		],
		[
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Open by defaults', 'starter-kit' ),
			'param_name' => 'open',
			'value'      => [ esc_html__( 'Yes', 'starter-kit' ) => 'yes' ],
		],
	
	]
];
