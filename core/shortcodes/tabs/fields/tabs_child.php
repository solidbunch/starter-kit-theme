<?php
vc_map( array(
	'name'            => esc_html__( 'Tabs', 'fruitfulblanktextdomain' ),
	'base'            => 'tabs_child',
	'content_element' => true,
	'as_child'        => array( 'only' => 'tabs' ),
	'params'          => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'fruitfulblanktextdomain' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Text', 'fruitfulblanktextdomain' ),
			'param_name' => 'text',
			'value'      => '',
		),		
	)
) );

?>