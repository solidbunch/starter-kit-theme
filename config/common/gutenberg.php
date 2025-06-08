<?php

return [
    'config' => [
        'gutenberg' => [
            'disableRedundantBlocks'     => [
                'core/image',
                'core/heading',
                'core/code',
                'core/media-text',
                'core/columns',
                'core/group',
                'core/row',
                'core/stack',
            ],
            'disableAllDefaultBlocks'           => false,
            'disableDefaultBlocksStyles'        => false,
        ],
    ],
];
