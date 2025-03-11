<?php

namespace StarterKit\Base;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Main constants for the theme.
 *
 * @package Starter Kit
 */
class Constants
{
    /**
     * Defines main constants for the theme.
     *
     * @throws \StarterKit\Exception\ConfigEntryNotFoundException
     */
    public static function define(): void
    {
        define('SK_PREFIX', Config::get('settingsPrefix'));
        define('_SK_PREFIX', '_' . SK_PREFIX);
        define('SK_HOOKS_PREFIX', Config::get('hooksPrefix'));
        define('SK_REST_API_NS', Config::get('restApiNamespace'));
        define('SK_ASSETS_DIR', Config::get('assetsDir'));
        define('SK_ASSETS_URI', Config::get('assetsUri'));
        define('SK_BLOCKS_DIR', Config::get('blocksDir'));
        define('SK_BLOCKS_URI', Config::get('blocksUri'));
        define('SK_BLOCKS_VIEW_DIR', Config::get('blocksViewDir'));
    }
}
