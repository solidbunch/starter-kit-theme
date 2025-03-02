<?php

namespace StarterKitBlocks\StarterBlock;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\NotFoundException;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class Block extends BlockAbstract
{
    /**
     * Block assets for editor and frontend
     *
     * @var array
     */
    protected array $blockAssets = [
        'editor_script' => [  // A JavaScript file for use only in the Block Editor
            'file'         => 'index.js',
            'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
        ],
        'editor_style'  => [  // A CSS file for use only in the Block Editor
            'file'         => 'editor.css',
            'dependencies' => [],
        ],
        'script'        => [ // A JavaScript file loaded in both the Block Editor and the front end
            'file'         => 'script.js',
            'dependencies' => [],
        ],
        'style'         => [ // A CSS file applied in both the Block Editor and the front end
            'file'         => 'style.css',
            'dependencies' => [],
        ],
        'view_script'   => [  // A JavaScript file for use only for the front end
            'file'         => 'view.js',
            'dependencies' => [],
        ],
        'view_style'    => [  // A CSS file for use only for the front end
            'file'         => 'view.css',
            'dependencies' => [],
        ],
    ];

    /**
     * Register block additional arguments including server side render callback
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
    }

    /**
     * Register rest api endpoints
     * Runs by abstract constructor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockRestApiEndpoints(): void
    {
    }
}
