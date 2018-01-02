<?php

	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}

	$options = array(
		'options' => array(
			'title' => esc_html__('Options', 'fruitfulblanktextdomain'),
			'type' => 'tab',
			'options' => array(

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

				'header' => array(
					'title' => esc_html__('Header', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'top_bar_call_us_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Call Us text', 'fruitfulblanktextdomain'),
							'value' => '',
						),

						'top_bar_phone_number' => array(
							'type'  => 'text',
							'label' => esc_html__('Phone Number', 'fruitfulblanktextdomain'),
							'value' => '',
						),

					)
				),

				'footer' => array(
					'title' => esc_html__('Footer', 'fruitfulblanktextdomain'),
					'type' => 'box',
					'attr' => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'footer_particles_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Text on particles section', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'footer_particles_button_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Button title on a footer particles section', 'fruitfulblanktextdomain'),
							'value' => '',
						),
						'footer_particles_button_link' => array(
							'type'  => 'multi-select',
							'label' => esc_html__('Choose Get Started page for a footer particles section', 'fruitfulblanktextdomain'),
							'population' => 'posts',
							'source' => array('page'),
							'prepopulate' => 10,
							'limit' => 1,
							'choices' => array(
								'default' => esc_html__('- Choose a page -', 'fruitfulblanktextdomain'),
							)
						),
						'bottom_bar_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Bottom Bar text', 'fruitfulblanktextdomain'),
							'value' => '',
						),


					)
				),

			)
		)
	);