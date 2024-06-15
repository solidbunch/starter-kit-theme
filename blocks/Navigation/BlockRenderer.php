<?php

namespace StarterKitBlocks\Navigation;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Assets;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use Throwable;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class BlockRenderer extends BlockAbstract
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
        // Get all the locations
        $locations = get_nav_menu_locations();

        // Get object id by location
        $menuId = $locations[$attributes['menuLocation']] ?? '';

        // Check for no menus in location
        if (!empty($attributes['menuLocation']) && empty($menuId)) {
            return $this->loadBlockView('no-data', ['message' => __('No menu in selected location', 'starter-kit')]);
        }

        // Or get menuId if menuId attribute present
        $menuId = !empty($attributes['menuId']) ? $attributes['menuId'] : $menuId;

        // Check for menuId and handle the 'no menu selected' case
        if (empty($menuId)) {
            return $this->loadBlockView('no-data', ['message' => __('No location or menu selected', 'starter-kit')]);
        }

        // Get menu items and handle the 'no menu items found' case
        $menuItems = wp_get_nav_menu_items($menuId);
        if (empty($menuItems)) {
            return $this->loadBlockView('no-data', ['message' => __('No menu items found', 'starter-kit')]);
        }

        // Add 'current' property and classes to menu item objects
        _wp_menu_item_classes_by_context($menuItems);

        //wlog($menuItems);
        // Prepare template data
        $templateData = [
            'attributes'   => $attributes,
            'menuTemplate' => $this->loadBlockView('nav-menu', [
                'menuTree' => $this->buildMenuTree($menuItems),
            ]),
        ];

        // Render the main navigation layout
        return $this->loadBlockView('nav-layout', $templateData);
    }

    private function buildMenuTree($menuItems): array
    {
        $menuTree = [];
        foreach ($menuItems as $item) {
            // Remove empty classes
            $item->classes = array_filter($item->classes);

            // Update item classes
            if (!empty($item->current)) {
                $item->classes[] = 'active';
            }

            // Add child items
            if (empty($item->menu_item_parent)) {
                $item->children = [];
                array_unshift($item->classes, 'nav-link');

                $menuTree[$item->ID] = $item;
            } else {
                // Add dropdown-item class to child items
                array_unshift($item->classes, 'dropdown-item');

                $menuTree[$item->menu_item_parent]->children[$item->ID] = $item;

                // Add class to item if it has children
                $menuTree[$item->menu_item_parent]->classes[] = 'dropdown-toggle';
            }
        }

        return $menuTree;
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
        register_rest_route(Config::get('restApiNamespace'), '/get-menu-locations', [
            'methods'             => 'GET',
            'callback'            => [$this, 'getMenuLocations'],
            'permission_callback' => [$this, 'getMenusPermissionCheck'],
        ]);

        register_rest_route(Config::get('restApiNamespace'), '/get-menus', [
            'methods'             => 'GET',
            'callback'            => [$this, 'getMenus'],
            'permission_callback' => [$this, 'getMenusPermissionCheck'],
        ]);
    }

    /**
     * Get all menu locations from database
     *
     * @return array
     */
    public function getMenuLocations(): array
    {
        $locations = [];

        $menuLocations = get_registered_nav_menus();

        foreach ($menuLocations as $locationSlug => $locationName) {
            $locations[] = [
                'slug' => $locationSlug,
                'name' => $locationName,
            ];
        }

        return $locations;
    }

    /**
     * Get all menus from database
     *
     * @return array
     */
    public function getMenus(): array
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
    public function getMenusPermissionCheck(): bool
    {
        return current_user_can('edit_posts');
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
