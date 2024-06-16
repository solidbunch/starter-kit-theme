<?php

namespace StarterKitBlocks\StarterBlock;

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
     * Block constructor.
     *
     * @param $blockName
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct($blockName)
    {

        // Todo vvv how we can correctly connect the callback function to the block
        // Use it in constructor or add separate function with interface?
        //$this->blockArgs = ['render_callback' => [$this, 'blockServerSideCallback']];

        parent::__construct($blockName);
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
        Assets::registerBlockScript($this->blockName, 'view.js', ['dropdown-script', 'offcanvas-script']);
        Assets::registerBlockStyle($this->blockName, 'view.css');
    }
}
