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
    }
}
