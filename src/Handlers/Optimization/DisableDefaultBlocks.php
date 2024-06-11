<?php

namespace StarterKit\Handlers\Optimization;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;
use WP_Block_Type_Registry;

/**
 * Optimization Handlers
 *
 * removes unnecessary tags etc.
 *
 * @package    Starter Kit
 */
class DisableDefaultBlocks
{
    public static function init(): void
    {
        if (!empty(Config::get('optimization/disableDefaultBlocks'))) {
            add_filter('allowed_block_types_all', [self::class, 'allowedBlockTypes'], 10, 2);
        }

        if (!empty(Config::get('optimization/disableDefaultBlocksStyles'))) {
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
    public static function allowedBlockTypes(bool|array $allowedBlockTypes, $blockEditorContext): bool|array
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
}
