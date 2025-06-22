<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;
use WP_Block_Type_Registry;

/**
 * Disable default blocks
 *
 * removes unnecessary tags etc.
 *
 * @package    Starter Kit
 */
class DisableDefaultBlocks
{
    public static function init(): void
    {
        if (!empty(Config::get('gutenberg/disableAllDefaultBlocks'))) {
            add_filter('allowed_block_types_all', [self::class, 'disableAllDefaultBlocks'], 10, 2);
        } elseif (!empty(Config::get('gutenberg/disableRedundantBlocks'))) {
            add_filter('allowed_block_types_all', [self::class, 'disableRedundantBlocks'], 10, 2);
        }

        if (!empty(Config::get('gutenberg/disableDefaultBlocksStyles'))) {
            add_action('wp_enqueue_scripts', [self::class, 'removeDefaultBlocksStyles'], 100);
        }
    }

    /**
     * Remove default blocks styles
     *
     * @return void
     */
    public static function removeDefaultBlocksStyles(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }

    /**
     * Filter and allow only defined blocks
     *
     * @param bool|array $allowedBlockTypes
     * @param            $blockEditorContext
     *
     * @return bool|array
     */
    public static function disableAllDefaultBlocks(bool|array $allowedBlockTypes, $blockEditorContext): bool|array
    {
        $allowedBlockTypes = [
            'core/shortcode',
            'core/html',
        ];

        $registeredBlocks = WP_Block_Type_Registry::get_instance()
            ->get_all_registered();

        foreach ($registeredBlocks as $blockName => $block) {
            if (!str_starts_with($blockName, 'core/')) {
                $allowedBlockTypes[] = $blockName;
            }
        }

        return $allowedBlockTypes;
    }

    public static function disableRedundantBlocks(bool|array $allowedBlockTypes, $blockEditorContext): bool|array
    {
        $disabledBlocks = Config::get('gutenberg/disableRedundantBlocks');
        $disabledBlocks = is_array($disabledBlocks) ? $disabledBlocks : [];

        $registeredBlocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

        $allowedBlocks = [];

        foreach ($registeredBlocks as $blockName => $block) {
            if (!in_array($blockName, $disabledBlocks, true)) {
                $allowedBlocks[] = $blockName;
            }
        }

        return $allowedBlocks;
    }
}
