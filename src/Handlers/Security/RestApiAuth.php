<?php

namespace StarterKit\Handlers\Security;

use StarterKit\Helper\Config;

class RestApiAuth
{
    public static function generateToken(): string
    {
        $expirationHours = 1;

        $salt = 248;

        $expirationTimestampInHours = intval(time() / 3600) + $expirationHours;

        $saltToSign = $expirationTimestampInHours * $salt;

        // Use hash_hmac to generate a token using the shared secret
        return hash_hmac('sha256', $saltToSign, Config::get('restApiKey'));
    }

    public static function validateToken($receivedToken): bool
    {
        $expectedToken = self::generateToken();

        if ($receivedToken === $expectedToken) {
            // Token is valid
            return true;
        } else {
            // Token is not valid
            return false;
        }
    }
}
