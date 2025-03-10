<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;

/**
 * Assets
 *
 * Helper functions
 *
 * @package    Starter Kit
 */
class Assets
{
    /**
     * Register theme script from /assets folder
     * Autogenerate handle with name '<filename>-script' if not provided
     *
     * @param string $relativePath Relative path to the file
     * @param array  $deps         Dependencies
     * @param string $handle       Name of the script
     * @param array  $args         An array of additional script loading strategies.
     *
     * @return void
     */
    public static function registerThemeScript(
        string $relativePath,
        array $deps = [],
        string $handle = '',
        array $args = []
    ): void {
        if (empty($args)) {
            $args = [
                'strategy'  => 'defer',
                'in_footer' => true,
            ];
        }

        wp_register_script(
            $handle ?: basename($relativePath, '.js') . '-script',
            SK_ASSETS_URI . $relativePath,
            $deps,
            filemtime(SK_ASSETS_DIR . $relativePath),
            $args
        );
    }

    /**
     * Register theme style from /assets folder
     * * Autogenerate handle with name '<filename>-style' if not provided
     *
     * @param string $relativePath Relative path to the file
     * @param array  $deps         Dependencies
     * @param string $handle       Name of the style
     * @param string $media        Media type
     *
     * @return void
     */
    public static function registerThemeStyle(
        string $relativePath,
        array $deps = [],
        string $handle = '',
        string $media = 'all'
    ): void {
        wp_register_style(
            $handle ?: basename($relativePath, '.css') . '-style',
            SK_ASSETS_URI . $relativePath,
            $deps,
            filemtime(SK_ASSETS_DIR . $relativePath),
            $media
        );
    }
}
