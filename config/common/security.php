<?php

return [
    'config' => [
        'security' => [
            'restrictRestApiToWhitelistOnly' => true,
            'RestApiNamespaceWhitelist' => [
                '/contact-form-7/',
                '/carbon-fields/', // TODO Checks how can disable on front
            ]
            // ToDo add key to .env
            //'restApiKey'     => defined('REST_API_KEY') ? REST_API_KEY,
        ],
    ],
];
