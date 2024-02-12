<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Utils;

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
        add_theme_support('menus');

        register_nav_menus([
            'header_menu' => esc_html__('Header Menu', 'starter-kit'),
            'bottom_menu' => esc_html__('Bottom Menu', 'starter-kit'),
        ]);
    }


    /**
     * Filtering image sizes by theme settings.
     *
     * @param string[] $imageSizes An array of intermediate image size names.
     *                       Defaults are 'thumbnail', 'medium', 'medium_large', 'large'.
     *
     * @return string[] Filterted image sizes.
     **/
    public static function filterImageSizes(array $imageSizes): array
    {
        $sizesToDisable = Utils::getOptionFw('disable_img_sizes', []);

        foreach ($imageSizes as $index => $size) {
            if (in_array($size, $sizesToDisable, true)) {
                unset($imageSizes[$index]);
            }
        }

        return $imageSizes;
    }
}
