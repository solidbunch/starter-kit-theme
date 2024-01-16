<?php

use Psr\Container\ContainerInterface;

$environment_type = wp_get_environment_type();

return [
    'hideErrors' => function (ContainerInterface $container) {
        $config = $container->get('config');

        return ! $config['isDebug'] || ! $config['isDebugDisplay'] || $config['isProdEnvironment'];
    },

    'config' => [
        'isDebug'              => defined('WP_DEBUG') && WP_DEBUG,
        'isDebugDisplay'       => defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY,
        'isDebugLog'           => defined('WP_DEBUG_LOG') && WP_DEBUG_LOG,
        'isDevEnvironment'     => 'development' === $environment_type,
        'isLocalEnvironment'   => 'local' === $environment_type,
        'isStagingEnvironment' => 'staging' === $environment_type,
        'isProdEnvironment'    => 'production' === $environment_type,
    ],
];
