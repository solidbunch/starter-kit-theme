<?php

/**
 * Send a message using AJAX
 **/

add_action( 'wp_ajax_shortcode_contact_form', 'shortcode_ajax_contact_form' );
add_action( 'wp_ajax_nopriv_shortcode_contact_form', 'shortcode_ajax_contact_form' );

function shortcode_ajax_contact_form(){

	$answer = array(
		'result' => 'fail'
	);

	/*
	* Hubspot api integration start
	*/
	$hubspot_api_enable = fw_get_db_settings_option( 'hubspot_api_enable');

	if ((!empty($hubspot_api_enable)) and ($hubspot_api_enable == 'yes') and ($_SERVER['REQUEST_METHOD'] == 'POST')) {

		require_once get_template_directory() . '/core/vendor/hubspot/hubspot.php';

		$hubspot_api_url         = fw_get_db_settings_option( 'hubspot_api_url');
		$hubspot_api_key         = fw_get_db_settings_option( 'hubspot_api_key');
		$hubspot_api_source      = fw_get_db_settings_option( 'hubspot_api_source');
		$hubspot_api_first_name  = fw_get_db_settings_option( 'hubspot_api_first_name');
		$hubspot_api_last_name   = fw_get_db_settings_option( 'hubspot_api_last_name');
		$hubspot_api_email       = fw_get_db_settings_option( 'hubspot_api_email');
		$hubspot_api_phone       = fw_get_db_settings_option( 'hubspot_api_phone');
		$hubspot_api_order_value = fw_get_db_settings_option( 'hubspot_api_order_value');

		$first_name  = $_POST[$hubspot_api_first_name];
		$last_name   = $_POST[$hubspot_api_last_name];
		$email       = $_POST[$hubspot_api_email];
		$phone       = $_POST[$hubspot_api_phone];
		$order_value = $_POST[$hubspot_api_order_value]; 

		$name    = $first_name . ' ' . $last_name;				
		$hubspot = new Hubspot();

		$hubspot->addContact( $hubspot_api_url, $hubspot_api_key, $hubspot_api_source, $name, $phone, $email, $order_value );

	}

	/*
	* Hubspot api integration stop
	*/

	/*
	* MailChimp api integration start
	*/
	$mailchimp_api_enable = fw_get_db_settings_option( 'mailchimp_api_enable' );

	if ( (!empty($mailchimp_api_enable) ) and ( $mailchimp_api_enable == 'yes' ) and ( $_SERVER['REQUEST_METHOD'] == 'POST') ) {

		require_once get_template_directory() . '/core/vendor/mailchimp/mailchimp.php';

		$mailchimp_api_key        = fw_get_db_settings_option( 'mailchimp_api_key');
		$mailchimp_api_list       = fw_get_db_settings_option( 'mailchimp_api_list');
		$mailchimp_api_first_name = fw_get_db_settings_option( 'mailchimp_api_first_name');
		$mailchimp_api_last_name  = fw_get_db_settings_option( 'mailchimp_api_last_name');
		$mailchimp_api_email      = fw_get_db_settings_option( 'mailchimp_api_email');

		$first_name = $_POST[$mailchimp_api_first_name];
		$last_name  = $_POST[$mailchimp_api_last_name];
		$email      = $_POST[$mailchimp_api_email];

		$data = [
			'api_key'    => $mailchimp_api_key,
			'list_id'    => $mailchimp_api_list,
			'email'      => $email,
			'status'     => 'subscribed',
			'first_name' => $first_name,
			'last_name'  => $last_name,
		];

		if ( !empty( $data['email'] ) ) {
			$MailChimp = new MailChimp();
			$MailChimp->syncMailchimp($data);
		}
	}

	/*
	* MailChimp api integration stop
	*/
	if ( !wp_verify_nonce( $_POST['security'], 'shordcode-contact-form' ) ) {
		$answer['error'] = esc_html__( 'Wrong form verification. Please try again.', 'fruitfulblanktextdomain' );
		die( json_encode( $answer ) );
	}
	if ( !empty( $_POST['y_name'] ) ) {
		die(); //antispam
	}

	$form_values = array();
	parse_str( $_POST['form_values'], $form_values );
	$form_data = unserialize( base64_decode( $_POST['form_data'] ) );
	$content   = '';

	if ( isset( $answer['error'] ) ) {
		die( json_encode( $answer ) );
	}

	$callbacks = array();

	// Generate message content
	if ( is_array( $form_values ) && count( $form_values ) ) {

		foreach ( $form_values as $k => $v ) {

			if ( $k == 'operation' ) {
				continue;
			}

			if ( strpos( $k, '_f_label' ) !== false ) {
				$field_id = str_replace( '_f_label', '', $k );
				$content .= "$v: ";

				if ( isset( $form_values[$field_id] ) && is_array( $form_values[$field_id] ) ) {
					$content .= implode( ', ', $form_values[$field_id] );
				} else {
					$content .= $form_values[$field_id];
				}

				$content .= "\r\n";

			}

			// field callbacks
			else if( strpos( $k, '_f_callback' ) !== false ) {

				$startdate = new DateTime( $form_values[$field_id], new DateTimeZone('Europe/Kiev') );
				$startdate = $startdate->format( 'c' );

				$enddate = new DateTime( $form_values[$field_id], new DateTimeZone('Europe/Kiev') );
				$enddate = $enddate->format( 'c' );

				$callbacks['google_calendar'][] = array(
					'start_date' => $startdate,
					'end_date'   => $enddate,
				);

			}

		}

	}

    /**
     * validate file type
     *
     * @param $file
     * @param array $allowed_types
     * @return bool
     */
    function validate_file_type( $file, $allowed_types ){
        $file_exploded = explode( '.', $file );
        $file_type = $file_exploded[count( $file_exploded ) - 1];
        return in_array( $file_type, $allowed_types );
    }

	$files = '';
    $allowed_types = array( 'pdf', 'png', 'jpg', 'jpeg', 'bmp' );
	if( $_FILES ){
        foreach ( $_FILES as $file ) {
            if ( $file['tmp_name'] ) {
                if ( validate_file_type( $file['name'], $allowed_types ) ){
                    $file_path = wp_upload_dir()['basedir'].'/'.$file['name'];
                    if ( copy( $file['tmp_name'], $file_path ) ){
                        $files[] = $file_path;
                    }
                }
            }
	    }
    }


	// Send email
	if ( is_email( $form_data['email_to'] ) ) {

		if( !empty( $callbacks ) ) {

			global $shortcodetheme;

			foreach( $callbacks as $callback_type => $callback_data ) {
				if( $callback_type == 'google_calendar' && !empty( $callback_data ) ) {
					foreach( $callback_data as $c_key => $c_data ) {
						$shortcodetheme->controller->calendar->create_event( 'Appointment booked', $content, $c_data['start_date'], $c_data['end_date'] );
					}
				}
			}
		}

		wp_mail( $form_data['email_to'], wp_kses_post( $form_data['subject_message'] ), wp_kses_post($content), '', $files ); 
		$answer['result'] = 'ok';
		@unlink( $files ); //delete file after send mail

	}
	
	die( json_encode( $answer ) );
}