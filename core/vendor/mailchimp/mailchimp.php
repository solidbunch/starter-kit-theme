<?php 

class MailChimp{
	
	public function syncMailchimp($data = array()){
		if (empty($data['api_key']) || empty($data['list_id'])) {
			return false;
		}
		
		$memberId = md5(strtolower($data['email']));
		$dataCenter = substr($data['api_key'],strpos($data['api_key'],'-')+1);
		$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $data['list_id'] . '/members';
		$auth = base64_encode( 'user:'.$data['api_key'] );
		
		//https://usX.api.mailchimp.com/3.0/lists/57afe96172/members

		$json_data = json_encode([
			'email_address' => $data['email'],
			'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
			'merge_fields'  => [
				'FNAME'     => $data['first_name'],
				'LNAME'     => $data['last_name'],
			]
		]);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'Authorization: Basic '.$auth));
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

		$result = curl_exec($ch);
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $httpCode;
	}
	
}