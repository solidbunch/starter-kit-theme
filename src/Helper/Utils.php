<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Utilities
 *
 * Helper functions
 *
 * @package    Starter Kit
 */
class Utils
{
    /**
     * Get Site Option
     *
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getOption(string $optionName, mixed $defaultValue = null): mixed
    {
        $prefix = Config::get('settingsPrefix');
        $prefix = "_{$prefix}";
        $value  = \get_option($prefix . $optionName, $defaultValue);

        return $value ?? $defaultValue;
    }


    /**
     * Get Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getOptionFw(string $optionName, mixed $defaultValue = null): mixed
    {
        $prefix = Config::get('settingsPrefix');
        $value  = \carbon_get_theme_option($prefix . $optionName);

        return $value ?? $defaultValue;
    }

    /**
     * Set Theme Option
     *
     * @param  string     $optionName
     * @param  mixed      $value
     * @param  bool|null  $autoload
     */
    public static function setOption(string $optionName, mixed $value, bool $autoload = null): void
    {
        $optionName = self::addPrefix($optionName);
        \update_option($optionName, $value, $autoload);
    }

    /**
     * Get Network Site Option
     *
     * @param  int     $siteId
     * @param  string  $optionName
     * @param  mixed   $defaultValue
     *
     * @return mixed
     */
    public static function getNetworkOption(int $siteId, string $optionName, mixed $defaultValue = null): mixed
    {
        $prefix = Config::get('settingsPrefix');
        $prefix = "_{$prefix}";
        $value  = \get_network_option($siteId, $prefix . $optionName, $defaultValue);

        return $value ?? $defaultValue;
    }


    /**
     * Get Network Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param  int         $siteId
     * @param  string      $optionName
     * @param  mixed|null  $defaultValue
     *
     * @return mixed
     */
    public static function getNetworkOptionFw(int $siteId, string $optionName, mixed $defaultValue = null): mixed
    {
        $prefix = Config::get('settingsPrefix');
        $value  = \carbon_get_network_option($siteId, $prefix . $optionName);

        return $value ?? $defaultValue;
    }


    /**
     * Get Post Meta with framework functionality
     *
     * @param  int         $postId
     * @param  string      $metaKey
     * @param  mixed|null  $default
     * @param  bool        $usePrefix
     *
     * @return mixed
     */
    public static function getPostMeta(
        int $postId,
        string $metaKey,
        mixed $default = null,
        bool $usePrefix = true
    ): mixed {
        $metaKey = $usePrefix ? self::addPrefix($metaKey) : $metaKey;
        $value   = \carbon_get_post_meta($postId, $metaKey);

        return in_array($value, [
            '',
            false,
            null,
            [],
        ], true) ? $default : $value;
    }


    /**
     * Get Term Meta
     *
     * @param  int     $termId
     * @param  string  $metaKey
     * @param  mixed   $default
     * @param  bool    $usePrefix
     *
     * @return mixed
     */
    public static function getTermMeta(
        int $termId,
        string $metaKey,
        mixed $default = null,
        bool $usePrefix = true
    ): mixed {
        $metaKey = $usePrefix ? self::addPrefix($metaKey) : $metaKey;
        $value   = \carbon_get_term_meta($termId, $metaKey);

        return in_array($value, [
            '',
            false,
            null,
            [],
        ], true) ? $default : $value;
    }


    /**
     * @param  string  $name
     *
     * @return string
     */
    public static function addPrefix(string $name): string
    {
        $prefix = Config::get('settingsPrefix');

        if (!$prefix) {
            return $name;
        }

        return self::isPrefixed($name, $prefix) ? $name : $prefix . $name;
    }


    /**
     * Check if string is prefixed
     *
     * @param  string  $name
     * @param  string  $prefix
     *
     * @return string
     */
    public static function isPrefixed(string $name, string $prefix): string
    {
        return str_starts_with($name, $prefix);
    }


    /**
     * Determines whether the current request is a WP_CLI request.
     *
     * @return bool True if it's a WP_CLI request, false otherwise.
     */
    public static function isDoingWPCLI(): bool
    {
        return defined('WP_CLI') && WP_CLI;
    }


    /**
     * Determines whether the current request is a WP Rest API request.
     *
     * @param  string|null $method Request method. Optinal. Default null - any method.
     *
     * @return bool True if it's a WP Rest API request, false otherwise.
     */
    public static function isRestApiRequest(?string $method = null): bool
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            // Probably a CLI request
            return false;
        }

        $rest_prefix         = trailingslashit(rest_get_url_prefix());
        $is_rest_api_request = str_contains($_SERVER['REQUEST_URI'], $rest_prefix);

        if ($method) {
            $is_rest_api_request = $is_rest_api_request && $_SERVER['REQUEST_METHOD'] === strtoupper($method);
        }

        return $is_rest_api_request;
    }
}
