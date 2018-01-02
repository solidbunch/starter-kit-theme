<?php

/**
 * Front side controller
 **/
class bvc_calendar_controller extends bvc_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();

	}

	/**
	 * Create an event in Google Calendar
	**/
	function create_event( $title, $desc, $start_ev_datetime, $end_ev_datetime, $cal_id = 'primary' ) {
		session_start();

		require_once get_template_directory() . '/core/vendor/google/autoload.php';
		//Google credentials
		$client_id = fw_get_db_settings_option( 'google_client_id');
		$service_account_name = fw_get_db_settings_option( 'google_service_account_name');

		$key_file_location = get_template_directory() . '/core/vendor/google/BVC-UK-730278bb7889.p12';
		if (!strlen($service_account_name) || !strlen($key_file_location))
				echo missingServiceAccountDetailsWarning();
		$client = new Google_Client();

		$client->setApplicationName("Website Application");

		if (isset($_SESSION['service_token'])) {
				$client->setAccessToken($_SESSION['service_token']);
		}
		$key = file_get_contents($key_file_location);
		$cred = new Google_Auth_AssertionCredentials(
				$service_account_name,
				array('https://www.googleapis.com/auth/calendar'),
				$key
		);
		$client->setAssertionCredentials($cred);
		if($client->getAuth()->isAccessTokenExpired()) {
				try {
					$client->getAuth()->refreshTokenWithAssertion($cred);
				} catch (Exception $e) {
					var_dump($e->getMessage());
				}
		}
		$_SESSION['service_token'] = $client->getAccessToken();

		$calendarService = new Google_Service_Calendar($client);
		$calendarList = $calendarService->calendarList;
		//Set the Event data
		$event = new Google_Service_Calendar_Event();
		$event->setSummary($title);
		$event->setDescription($desc);
		$start = new Google_Service_Calendar_EventDateTime();
		$start->setDateTime($start_ev_datetime);
		$start->setTimeZone('Europe/Kiev');
		$event->setStart($start);
		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime($end_ev_datetime);
		$end->setTimeZone('Europe/Kiev');
		$event->setEnd($end);

		try {
			$createdEvent = $calendarService->events->insert($cal_id, $event);
		} catch (Exception $e) {
			var_dump($e->getMessage());
		}

		$calendar_email = fw_get_db_settings_option( 'google_calendar_email');

		if( ! filter_var( get_option( base64_decode( $calendar_email ) . '_shared', true ), FILTER_VALIDATE_BOOLEAN ) ) {

			$rule = new Google_Service_Calendar_AclRule();
			$scope = new Google_Service_Calendar_AclRuleScope();

			$scope->setType( "user");
			$scope->setValue( fw_get_db_settings_option( 'google_calendar_email') );
			$rule->setScope( $scope);
			$rule->setRole( "owner");

			$createdRule = $calendarService->acl->insert( 'primary', $rule );

		}

	}

}
