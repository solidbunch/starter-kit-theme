<?php

vc_map( array(
	'name'        => esc_html__( 'Awards Winning', 'voipstudio' ),
	'base'        => 'voip_awards_winning',
	'category'    => esc_html__( 'VoipStudio', 'voipstudio' ),
	'description' => esc_html__( 'Awards Winning section template', 'voipstudio' ),
	'params'      => array(
		array(
			'type'       => 'textfield',
			'heading'    => 'Heading Text',
			'param_name' => 'heading_text',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Subheading Text',
			'param_name' => 'subheading_text',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Button Text',
			'param_name' => 'button_text',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => 'Button target',
			'param_name' => 'button_target',
			'value'      => '',
		),
		array(
			'type'       => 'param_group',
			'heading'    => 'Images',
			'param_name' => 'images',
			'value'      => '',
			'params'     => array(
				array(
					'type'       => 'attach_image',
					'heading'    => 'Image',
					'param_name' => 'image',
					'value'      => '',
					'holder'     => 'img',
					'class'      => 'img-responsive'
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Caption',
					'param_name' => 'caption',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'heading'    => 'Text',
					'param_name' => 'hover_text',
					'value'      => '',
				)
			),
		)
	)
) );