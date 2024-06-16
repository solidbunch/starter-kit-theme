<?php

namespace StarterKitBlocks\Button;

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
class Block extends BlockAbstract
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
     * Register block editor assets
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
