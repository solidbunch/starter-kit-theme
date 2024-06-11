<?php

namespace StarterKitBlocks\PricingTable;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
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
class BlockRenderer extends BlockAbstract
{
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
    public static function blockServerSideCallback(array $attributes, string $content, object $block): string
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
            return self::loadBlockView('no-data', ['message' => __('No pricing found', 'starter-kit')]);
        }

        $templateData['pricingPackages'] = $pricingPackages;

        return self::loadBlockView('layout', $templateData);
    }
}
