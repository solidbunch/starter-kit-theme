<?php

namespace StarterKitBlocks\Navigation;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
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
            'view_script' => [
                'file' => 'view.js',
                'dependencies' => ['dropdown-script', 'offcanvas-script'],
            ],
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ],
            'style' => [
                'file' => 'style.css',
                'dependencies' => [],
            ],
            'view_style' => [],
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
     * @throws Throwable
     */
    public function blockServerSideCallback(array $attributes, string $content, object $block): string
    {
        // Get all locations
        $locations = get_nav_menu_locations();

        // Get object id by location
        // Or get menuId if menuId attribute present
        $menuIdByLocation = $locations[$attributes['menuLocation']] ?? '';
        $menuId = !empty($attributes['menuId']) ? $attributes['menuId'] : $menuIdByLocation;

        // Check for no menus in location
        if (!empty($attributes['menuLocation']) && empty($menuId)) {
            return $this->loadBlockView('no-data', ['message' => __('No menu in selected location', 'starter-kit')]);
        }

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

        // Prepare template data
        $templateData = [
            'attributes' => $attributes,
            'menuId' => $menuId,
            'menuTemplate' => $this->loadBlockView('nav-menu', [
                'menuTree' => $this->buildMenuTree($menuItems),
            ]),
            'blockClass' => $this->generateBlockClasses($attributes),
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

            if (self::isAnchor($item->url)) {
                $item->classes = array_filter(
                    $item->classes,
                    fn($class) => !preg_match('#^current[-_]#', $class)
                );
                $item->current = false; // Reset current state for anchors
            }

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
     */
    public function blockRestApiEndpoints(): void
    {
        register_rest_route(SK_REST_API_NS, '/get-menu-locations', [
            'methods' => 'GET',
            'callback' => [$this, 'getMenuLocations'],
            'permission_callback' => [$this, 'getMenusPermissionCheck'],
        ]);

        register_rest_route(SK_REST_API_NS, '/get-menus', [
            'methods' => 'GET',
            'callback' => [$this, 'getMenus'],
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
                'taxonomy' => 'nav_menu',
                'hide_empty' => false,
                'orderby' => 'name',
            ]
        );

        foreach ($menusObjects as $menuObject) {
            $menus[] = [
                'id' => $menuObject->term_id,
                'name' => $menuObject->name,
            ];
        }

        return $menus;
    }

    public static function isAnchor($url): bool
    {
        $parsed = wp_parse_url($url);
        return isset($parsed['fragment']) &&
            (!isset($parsed['path']) || in_array($parsed['path'], ['', '/'], true)) &&
            (!isset($parsed['host']) || $parsed['host'] === $_SERVER['HTTP_HOST']);
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
}
