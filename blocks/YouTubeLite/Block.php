<?php

namespace StarterKitBlocks\YouTubeLite;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;

/**
 * YouTube Lite block
 *
 * @package Starter Kit
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
                'file'         => 'index.js',
                'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
            ],
            'editor_style'  => [
                'file'         => 'editor.css',
                'dependencies' => [],
            ],
            'style'         => [
                'file'         => 'style.css',
                'dependencies' => [],
            ],
            'view_script'   => [
                'file'         => 'view.js',
                'dependencies' => [],
            ],
        ];

    public function registerBlockArgs(): void
    {
        // Static save in JS; no server-side render required.
    }

    /**
     * Register REST API endpoints for the block.
     * YouTubeLite block does not expose any endpoints, so this is intentionally empty.
     *
     * @return void
     */
    public function blockRestApiEndpoints(): void
    {
    }
}
