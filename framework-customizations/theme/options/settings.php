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
		
		'img_lazy_load_box' => array(
			'title'   => esc_html__( 'Extra', 'fruitfulblanktextdomain' ),
			'type'    => 'box',
			'attr'    => array(
				'class' => 'prevent-auto-close'
			),
			'options' => array(
				
				'img_lazy_load'	=> array(
					'type'  => 'switch',
					'label' => __('Lazy Load Images', 'fruitfulblanktextdomain'),
					'right-choice' => array(
						'value' => '1',
						'label' => __('Yes', 'fruitfulblanktextdomain')
					),
					'left-choice' => array(
						'value' => '0',
						'color' => '#ccc',
						'label' => __('No', 'fruitfulblanktextdomain')
					),
					'desc'  => __('Lazy Load Images on site', 'fruitfulblanktextdomain'),
				
				),
			
			)
		),
		
		
	
	
	)
);
