<?php

$options = [
	[
		'social_options_tab' => [
			'title'   => esc_html__( 'Social', 'starter-kit' ),
			'type'    => 'tab',
			'options' => [
				
				//startoauthsettings
				
				'oauth-settings-box' => [
					'title'   => esc_html__( 'Social Login', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						
						'facebook_app_id'     => [
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application ID', 'starter-kit' ),
							'value' => ''
						],
						'facebook_app_secret' => [
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application Secret', 'starter-kit' ),
							'value' => ''
						],
						
						'google_client_id'     => [
							'type'  => 'text',
							'label' => esc_html__( 'Google Client ID', 'starter-kit' ),
							'value' => ''
						],
						'google_client_secret' => [
							'type'  => 'text',
							'label' => esc_html__( 'Google Client Secret', 'starter-kit' ),
							'value' => ''
						],
						
						'twitter_consumer_key'    => [
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Key', 'starter-kit' ),
							'value' => ''
						],
						'twitter_consumer_secret' => [
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Secret', 'starter-kit' ),
							'value' => ''
						],
					
					]
				],
				
				//endoauthsettings
				
				'social_profiles-settings-box' => [
					'title'   => esc_html__( 'Social Profiles', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => [
						'class' => 'prevent-auto-close'
					],
					'options' => [
						
						\StarterKit\Helper\Utils::get_social_cfg_usyon()
					
					]
				],
			
			]
		]
	]
];
