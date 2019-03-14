<?php

$options = array(
	array(
		'social_options_tab' => array(
			'title'   => esc_html__( 'Social', 'starter-kit' ),
			'type'    => 'tab',
			'options' => array(

				//startoauthsettings

				'oauth-settings-box' => array(
					'title'   => esc_html__( 'Social Login', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'facebook_app_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application ID', 'starter-kit' ),
							'value' => ''
						),
						'facebook_app_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application Secret', 'starter-kit' ),
							'value' => ''
						),

						'google_client_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client ID', 'starter-kit' ),
							'value' => ''
						),
						'google_client_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client Secret', 'starter-kit' ),
							'value' => ''
						),

						'twitter_consumer_key'    => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Key', 'starter-kit' ),
							'value' => ''
						),
						'twitter_consumer_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Secret', 'starter-kit' ),
							'value' => ''
						),

					)
				),

				//endoauthsettings

				'social_profiles-settings-box' => array(
					'title'   => esc_html__( 'Social Profiles', 'starter-kit' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						\StarterKit\Helper\Utils::get_social_cfg_usyon()

					)
				),

			)
		)
	)
);
