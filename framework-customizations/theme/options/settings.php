<?php

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	array(
		
		'social_profiles-settings-box' => array(
			'title'   => esc_html__( 'Social Profiles', 'fruitfulblanktextdomain' ),
			'type'    => 'box',
			'attr'    => array(
				'class' => 'prevent-auto-close'
			),
			'options' => array(
				
				\ffblank\helper\utils::get_social_cfg_usyon()
			
			)
		),
		
		'bottom_bar-settings-box' => array(
			'title'   => esc_html__( 'Bottom Bar', 'fruitfulblanktextdomain' ),
			'type'    => 'box',
			'attr'    => array(
				'class' => 'prevent-auto-close'
			),
			'options' => array(
				
				'bottom_bar_text' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Bottom bar text', 'fruitfulblanktextdomain' ),
					'value' => ''
				),
			
			)
		),
	
	)
);
