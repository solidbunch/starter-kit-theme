<?php

namespace StarterKitBlocks\PricingTable;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Assets;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKit\Helper\Utils;
use StarterKit\Repository\PricingRepository;
use Throwable;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class Block extends BlockAbstract
{
    /**
     * BlockRenderer constructor.
     *
     * @param $blockName
     */
    public function __construct($blockName)
    {
        $this->blockArgs = ['render_callback' => [$this, 'blockServerSideCallback']];

        parent::__construct($blockName);
    }

    /**
     * Block server side render callback
     * Used in register block type from metadata
     *
     * @param array  $attributes
     * @param string $content
     * @param object $block
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function blockServerSideCallback(array $attributes, string $content, object $block): string
    {

        $args = [
            'posts_per_page' => 10,
            'orderby'        => [
                'menu_order' => 'ASC',
            ],
        ];

        $pricingPackages = PricingRepository::getAllWithData($args);

        // Check if Pricing packages present
        if (empty($pricingPackages)) {
            return $this->loadBlockView('no-data', ['message' => __('No pricing found', 'starter-kit')]);
        }

        $templateData['pricingPackages'] = $pricingPackages;

        return $this->loadBlockView('layout', $templateData);
    }

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
        Assets::registerBlockStyle($this->blockName, 'view.css');
    }
}
