<?php

class Hubspot
{
    /**
     * Adds contact to hubspot crm.
     *
     * @param string $email
     * @param string $telephone
     */
	public function addContact($api_url = null, $api_key = null, $source = null, $name = null, $telephone = null, $email = null, $order_value = null)
    {
        // Ensure name and telephone are not null
        if ($api_url === null || $api_key === null || $source === null || $name === null || $telephone === null) {
            return false;
        }

        $marketing_source = 'default';
        if(isset($_COOKIE['marketing_source']) && $_COOKIE['marketing_source'] !== ''){
            $marketing_source = $_COOKIE['marketing_source'];
        }

        // Create contact array
        $contact = [
            'properties' => [
                [
                    'property' => 'firstname',
                    'value' => $name,
                ],
                [
                    'property' => 'phone',
                    'value' => $this->formatPhoneNumber($telephone),
                ],
                [
                    'property' => 'hs_lead_status',
                    'value' => 'NEW',
                ],
                [
                    'property' => 'source',
                    'value' => $source,
                ],
                [
                    'property' => 'marketing_source',
                    'value' => $marketing_source
                ],
            ],
        ];

        // Email?
        if ($email !== null) {
            array_push($contact['properties'], [
                'property' => 'email',
                'value' => $email,
            ]);
        }

        // Order Value?
        if ($order_value !== null) {
            array_push($contact['properties'], [
                'property' => 'order_value',
                'value' => $order_value,
            ]);
        }

        $contact = json_encode($contact);

        // Send request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . $api_key);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $contact);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($contact),
            )
        );
        $result = curl_exec($ch);

        // Check for curl error
        if (curl_errno($ch)) {
            return false;
        }

        // Check response code
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus != 200) {
            return false;
        }

        return true;
    }

    /**
     * Converts number to twillio format
     *
     * @param string $phone
     * @return return string
     */
    private function formatPhoneNumber($phone)
    {
        if ($phone[0] === '+') {
            if ($phone[3] == '0') {
                $phone = substr($phone, 0, 3) . substr($phone, 4);
            }
        } else {
            // Strip out all characters apart from numbers
            $phone = preg_replace('/[^0-9]+/', '', $phone);
        }

        // Remove the 2 digit international code (00) if exist
        if (substr($phone, 0, 2) == '00') {
            $phone = substr($phone, 2);
        }

        return $phone;
    }
}
