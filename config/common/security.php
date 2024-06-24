<?php

return [
    'config' => [
        'security' => [
            'restrictRestApiToWhitelistOnly' => true,
            'RestApiNamespaceWhitelist' => [
                '/contact-form-7/v1',
            ]
            // ToDo add key to .env
            //'restApiKey'     => defined('REST_API_KEY') ? REST_API_KEY,
        ],
    ],
];
