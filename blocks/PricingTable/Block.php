<?php

namespace StarterKitBlocks\PricingTable;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Exception\ConfigEntryNotFoundException;
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
     * Block assets for editor and frontend
     *
     * @var array
     */
    protected array $blockAssets
        = [
            'editor_script' => [
                'file' => 'index.js',
                'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
            ],
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ],
            'style' => [
                'file' => 'style.css',
                'dependencies' => [],
            ]
        ];

    /**
     * Register block additional arguments including server side render callback
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
        $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
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
     * @throws ConfigEntryNotFoundException
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

        $templateData['blockClass'] = $this->generateBlockClasses($attributes);

        return $this->loadBlockView('layout', $templateData);
    }

    public function blockRestApiEndpoints(): void
    {
    }
}
