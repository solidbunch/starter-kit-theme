<?php

namespace StarterKitBlocks\Row;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Assets;
use StarterKit\Helper\NotFoundException;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class BlockRenderer extends BlockAbstract
{
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

    /**
     * Register block assets for frontend and editor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockEditorAssets(): void
    {
        Assets::registerBlockScript(
            $this->blockName,
            'index.js',
            ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor']
        );
        Assets::registerBlockStyle($this->blockName, 'editor.css');
    }

    /**
     * Register block assets for frontend and editor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockAssets(): void
    {
    }
}
