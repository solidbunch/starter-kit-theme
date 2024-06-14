<?php

return [
    'config' => [
        'themeName'           => 'Starter Kit Theme',
        'package'             => 'Starter Kit',
        'themeSlug'           => 'starter-kit',
        'themeNamespace'      => 'StarterKit',
        'hooksPrefix'         => 'starter_kit',
        'settingsPrefix'      => 'skt_',
        'restApiNamespace'    => 'skt/v1',
        'assetsDir'           => get_stylesheet_directory() . '/assets/',
        'assetsUri'           => get_stylesheet_directory_uri() . '/assets/',
        'blocksDir'           => get_stylesheet_directory() . '/blocks/',
        'blocksUri'           => get_stylesheet_directory_uri() . '/blocks/',
        'blocksIcons'         => '',
        'blocksCategorySlug'  => 'starter-kit',
        'blocksCategoryTitle' => 'StarterKit Blocks',
        'blocksViewDir'       => 'view/',
    ],
];
