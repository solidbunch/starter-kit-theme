<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'fruitfulblanktextdomain' ),
			'type'    => 'tab',
			'options' => array(

				'antispam_box' => array(
					'title'   => esc_html__( 'Antispam', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'forms_antispam'	=> array(
							'type'  => 'switch',
							'label' => __('Antispam', 'fruitfulblanktextdomain'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'fruitfulblanktextdomain')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'fruitfulblanktextdomain')
							),
							'desc'  => __('Antispam for all Email Forms', 'fruitfulblanktextdomain'),

						),

					)
				),

				'pingbacks' => array(
					'title'   => esc_html__( 'Ping Backs', 'fruitfulblanktextdomain' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'disable_pingbacks'	=> array(
							'type'  => 'switch',
							'label' => __('Trackbacks/Pingbacks', 'fruitfulblanktextdomain'),
							'right-choice' => array(
								'value' => '1',
								'label' => __('Yes', 'fruitfulblanktextdomain')
							),
							'left-choice' => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __('No', 'fruitfulblanktextdomain')
							),
							'desc'  => __('Disables trackbacks/pingbacks', 'fruitfulblanktextdomain'),

						),

					)
				),
				
				'general' => array(
					'title' => esc_html__('General', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'coins_course_api_url' => array(
							'type'  => 'text',
							'label' => esc_html__('Enter link to currency API', 'fruitfulblanktextdomain'),
							'value' => 'https://min-api.cryptocompare.com/data/pricemulti?fsyms={FROM}&tsyms={TO}'
						),

						'coins_margin' => array(
							'type'  => 'short-text',
							'label' => esc_html__('Enter default margin to exchange rate in %', 'fruitfulblanktextdomain'),
							'desc'  => esc_html__('This value is used if no value is specified for a particular coin', 'fruitfulblanktextdomain'),
							'value' => '10'
						),

					)
				),

				'api' => array(
					'title' => esc_html__('Google Calendar API', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'google_client_id' => array(
							'type'  => 'text',
							'label' => esc_html__('Google Calendar Client ID', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'google_service_account_name' => array(
							'type'  => 'text',
							'label' => esc_html__('Google Calendar Service Account Name', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'google_calendar_email' => array(
							'type'  => 'text',
							'label' => esc_html__('Google Calendar Email', 'fruitfulblanktextdomain'),
							'value' => '',
						),

					)
				),

				'hubspot_api' => array(
					'title' => esc_html__('Hubspot API', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'hubspot_api_enable' => array(
							'type'  => 'select',
							'label' => esc_html__('Enable Hubspot API in all forms', 'fruitfulblanktextdomain'),
							'choices' => array(
								'yes' => esc_html__('Yes', 'fruitfulblanktextdomain'),
								'no' => esc_html__('No', 'fruitfulblanktextdomain'),
							)
						),
						'hubspot_api_url' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot API URL', 'fruitfulblanktextdomain'),
							'value' => 'https://api.hubapi.com/contacts/v1/contact/?hapikey=',
						),
						'hubspot_api_key' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot API key', 'fruitfulblanktextdomain'),
							'value' => '91f987dd-05a2-48f7-9ca9-d971356d54b2',
						),
						'hubspot_api_source' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot Source', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'hubspot_api_first_name' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot First Name field', 'fruitfulblanktextdomain'),
							'value' => 'field_first_name',
						),
						'hubspot_api_last_name' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot Last Name field', 'fruitfulblanktextdomain'),
							'value' => 'field_last_name',
						),
						'hubspot_api_email' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot Email field', 'fruitfulblanktextdomain'),
							'value' => 'field_email',
						),
						'hubspot_api_phone' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot Phone field', 'fruitfulblanktextdomain'),
							'value' => 'field_phone',
						),
						'hubspot_api_order_value' => array(
							'type'  => 'text',
							'label' => esc_html__('Hubspot Order Value field', 'fruitfulblanktextdomain'),
							'value' => 'field_coin',
						),
					)
				),

				'mailchimp_api' => array(
					'title' => esc_html__('MailChimp API', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'mailchimp_api_enable' => array(
							'type'  => 'select',
							'label' => esc_html__('Enable MailChimp API in all forms', 'fruitfulblanktextdomain'),
							'choices' => array(
								'yes' => esc_html__('Yes', 'fruitfulblanktextdomain'),
								'no' => esc_html__('No', 'fruitfulblanktextdomain'),
							)
						),
						'mailchimp_api_key' => array(
							'type'  => 'text',
							'label' => esc_html__('MailChimp API key', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'mailchimp_api_list' => array(
							'type'  => 'text',
							'label' => esc_html__('MailChimp API list', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'mailchimp_api_first_name' => array(
							'type'  => 'text',
							'label' => esc_html__('MailChimp First Name field', 'fruitfulblanktextdomain'),
							'value' => 'field_first_name',
						),
						'mailchimp_api_last_name' => array(
							'type'  => 'text',
							'label' => esc_html__('MailChimp Last Name field', 'fruitfulblanktextdomain'),
							'value' => 'field_last_name',
						),
						'mailchimp_api_email' => array(
							'type'  => 'text',
							'label' => esc_html__('MailChimp Email field', 'fruitfulblanktextdomain'),
							'value' => 'field_email',
						),
					)
				),
			)
		)
	),			
);
