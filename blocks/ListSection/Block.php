<?php

namespace StarterKitBlocks\ListSection;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;

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
    protected array $blockAssets
        = [
            'editor_script' => [
                'file' => 'index.js',
                'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
            ]
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
     */
    public function blockRestApiEndpoints(): void
    {
    }
}
