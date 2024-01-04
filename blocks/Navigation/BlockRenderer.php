<?php

namespace StarterKitBlocks\Navigation;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;

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

        //$templateData['menuItems'] = wp_get_nav_menu_items($attributes['menuId']);

        return self::loadBlockView('nav-layout', $templateData);
    }
}
