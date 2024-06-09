<?php

namespace StarterKitBlocks\PricingTable;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Config;

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
     * @param $attributes
     * @param $content
     * @param $block
     *
     * @return string
     */
    public static function blockServerSideCallback($attributes, $content, $block): string
    {

        $templateData = [];

        return self::loadBlockView('layout', $templateData);
    }

}
