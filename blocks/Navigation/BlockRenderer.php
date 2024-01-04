<?php

namespace StarterKitBlocks\Navigation;

defined('ABSPATH') || exit;

use StarterKit\Base\Config;
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

        $templateData['menuItems'] = wp_get_nav_menu_items($attributes['menuId']);

        if (!empty($templateData['menuItems'])) {
            $data = self::loadBlockView('nav-layout', $templateData);
        } else {
            $data = self::loadBlockView('no-data', $templateData);
        }

        return $data;
    }

    /**
     * Register rest api endpoints
     * Runs by Blocks Register Handler
     *
     * @return void
     */
    public static function blockRestApiEndpoints(): void
    {
        register_rest_route(Config::get('restApiNamespace'), '/get-menus', [
            'methods'             => 'GET',
            'callback'            => [self::class, 'getMenus'],
            'permission_callback' => [self::class, 'getMenusPermissionCheck'],
        ]);
    }

    /**
     * Get all menus from database
     *
     * @return array
     */
    public static function getMenus(): array
    {
        $menus = [];

        $menusObjects = wp_get_nav_menus(
            [
                'taxonomy'   => 'nav_menu',
                'hide_empty' => false,
                'orderby'    => 'name',
            ]
        );

        foreach ($menusObjects as $menuObject) {
            $menus[] = [
                'id'   => $menuObject->term_id,
                'name' => $menuObject->name,
            ];
        }

        return $menus;
    }

    /**
     * Allow only backend users to get menus data
     *
     * @return bool
     */
    public static function getMenusPermissionCheck(): bool
    {
        return current_user_can('edit_posts');
    }
}
