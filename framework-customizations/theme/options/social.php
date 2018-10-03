<?php

$options = array(
	array(
		'social_options_tab' => array(
			'title'   => esc_html__( 'Social', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

				'oauth-settings-box' => array(
					'title'   => esc_html__( 'Social Login', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'facebook_app_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application ID', 'fruitfulblanktextdomain' ),
							'value' => ''
						),
						'facebook_app_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application Secret', 'fruitfulblanktextdomain' ),
							'value' => ''
						),

						'google_client_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client ID', 'fruitfulblanktextdomain' ),
							'value' => ''
						),
						'google_client_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client Secret', 'fruitfulblanktextdomain' ),
							'value' => ''
						),

						'twitter_consumer_key'    => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Key', 'fruitfulblanktextdomain' ),
							'value' => ''
						),
						'twitter_consumer_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Secret', 'fruitfulblanktextdomain' ),
							'value' => ''
						),

					)
				),

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
