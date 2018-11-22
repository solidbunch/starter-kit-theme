<?php

return array(
	'name'            => esc_html__( 'Toggle Section', 'starter-kit' ),
	'base'            => 'toggle',
	'icon'            => Starter_Kit()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'content_element' => true,
	'as_child'        => array( 'only' => 'toggles' ),
	'params'          => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Text', 'starter-kit' ),
			'param_name' => 'content',
			'value'      => '',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Open by defaults', 'starter-kit' ),
			'param_name' => 'open',
			'value'      => array( esc_html__( 'Yes', 'starter-kit' ) => 'yes' ),
		),

	)
);
