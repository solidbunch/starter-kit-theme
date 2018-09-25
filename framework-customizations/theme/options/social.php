<?php

$options = array(
	array(
		'social_options_tab' => array(
			'title' => esc_html__( 'Social', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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

			)
		)
	)
);