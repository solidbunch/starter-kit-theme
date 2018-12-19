<?php

/**
 * Send a message using AJAX
 **/

add_action( 'wp_ajax_contact_form', 'shortcode_ajax_contact_form' );
add_action( 'wp_ajax_nopriv_contact_form', 'shortcode_ajax_contact_form' );

function shortcode_ajax_contact_form(){

	$answer = array(
		'result' => 'fail'
	);

	if ( !wp_verify_nonce( $_POST['security'], 'contact-form' ) ) {
		$answer['error'] = esc_html__( 'Wrong form verification. Please try again.', 'starter-kit' );
		die( json_encode( $answer ) );
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

				$enddate   = new DateTime( $form_values[$field_id], new DateTimeZone('Europe/Kiev') );
				$enddate   = $enddate->format( 'c' );

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
        $file_type     = $file_exploded[count( $file_exploded ) - 1];

        return in_array( $file_type, $allowed_types );

    }

	$files = '';
    $allowed_types = array( 'pdf', 'png', 'jpg', 'jpeg', 'bmp' );

	if( $_FILES ){
        foreach ( $_FILES as $file ) {
            if ( $file['name'] ) {
                if ( validate_file_type( $file['name'], $allowed_types ) ){
                    $file_path = wp_upload_dir()['basedir'].'/'.$file['name'];
                    if ( copy( $file['name'], $file_path ) ){
                        $files[] = $file_path;
                    }
                }
            }
	    }
    }

	// Send email
	if ( is_email( $form_data['email_to'] ) ) {
		wp_mail( $form_data['email_to'], wp_kses_post( $form_data['subject_message'] ), wp_kses_post( $content ), '', $files );
		$answer['result'] = 'ok';
		@unlink( $files ); //delete file after send mail
	}
	
	die( json_encode( $answer ) );
}