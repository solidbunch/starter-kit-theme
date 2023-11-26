<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

/**
 * Theme setup functionality
 *
 * @package    Starter Kit
 */
class SetupTheme
{
    /**
     * Add theme support
     **/
    public static function addThemeSupport(): void
    {
        //add_theme_support( 'disable-layout-styles' );
    }

    /**
     * Register theme menus
     **/
    public static function registerMenus(): void
    {
        register_nav_menus([
            'header_menu' => esc_html__('Header Menu', 'starter-kit'),
            'bottom_menu' => esc_html__('Bottom Menu', 'starter-kit'),
        ]);
    }
}
