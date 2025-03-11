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
     * Gets Site Option
     *
     * @param string     $optionName
     * @param mixed|null $defaultValue
     * @param bool       $usePrefix
     * @param false      $useLangSuffix
     *
     * @return mixed
     */
    public static function getOption(
        string $optionName,
        mixed $defaultValue = null,
        bool $usePrefix = true,
        bool $useLangSuffix = false
    ): mixed {
        $prefix     = _SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        $optionName = $useLangSuffix ? $optionName . Lang::getLangSuffix() : $optionName;
        $value      = \get_option($optionName, $defaultValue);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param string     $optionName
     * @param mixed|null $defaultValue
     * @param bool       $usePrefix
     * @param false      $useLangSuffix
     *
     * @return mixed
     */
    public static function getOptionFw(
        string $optionName,
        mixed $defaultValue = null,
        bool $usePrefix = true,
        bool $useLangSuffix = false
    ): mixed {
        $prefix     = SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        $optionName = $useLangSuffix ? $optionName . Lang::getLangSuffix() : $optionName;
        $value      = \carbon_get_theme_option($optionName);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Sets Site Option
     *
     * @param string    $optionName
     * @param mixed     $value
     * @param bool      $usePrefix
     * @param bool|null $autoload
     *
     * @return void
     */
    public static function setOption(
        string $optionName,
        mixed $value,
        bool $usePrefix = true,
        bool $autoload = null
    ): void {
        $prefix     = _SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        \update_option($optionName, $value, $autoload);
    }


    /**
     * Set Site Option with framework functionality
     *
     * @param string $optionName
     * @param mixed  $value
     * @param bool   $usePrefix
     */
    public static function setOptionFw(string $optionName, mixed $value, bool $usePrefix = true): void
    {
        $prefix     = SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        \carbon_set_theme_option($optionName, $value);
    }


    /**
     * Gets Network Site Option
     *
     * @param int    $siteId
     * @param string $optionName
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getNetworkOption(
        int $siteId,
        string $optionName,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix     = _SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        $value      = \get_network_option($siteId, $optionName, $defaultValue);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets Network Site Option with framework functionality
     * for specific cases, reduce performance
     *
     * @param int        $siteId
     * @param string     $optionName
     * @param mixed|null $defaultValue
     * @param bool       $usePrefix
     *
     * @return mixed
     */
    public static function getNetworkOptionFw(
        int $siteId,
        string $optionName,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix     = SK_PREFIX;
        $optionName = $usePrefix ? self::addPrefix($optionName, $prefix) : $optionName;
        $value      = \carbon_get_network_option($siteId, $optionName);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets Post Meta
     *
     * @param int    $postId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getPostMeta(
        int $postId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = _SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \get_post_meta($postId, $metaKey, true);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets Post Meta with framework functionality
     *
     * @param int        $postId
     * @param string     $metaKey
     * @param mixed|null $defaultValue
     * @param bool       $usePrefix
     *
     * @return mixed
     */
    public static function getPostMetaFw(
        int $postId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \carbon_get_post_meta($postId, $metaKey);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Sets Post Meta
     *
     * @param int    $postId
     * @param string $metaKey
     * @param mixed  $metaValue
     * @param bool   $usePrefix
     */
    public static function setPostMeta(
        int $postId,
        string $metaKey,
        mixed $metaValue,
        bool $usePrefix = true
    ): void {
        $prefix  = _SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        \update_post_meta($postId, $metaKey, $metaValue);
    }


    /**
     * Sets Post Meta with framework functionality
     *
     * @param int    $postId
     * @param string $metaKey
     * @param mixed  $metaValue
     * @param bool   $usePrefix
     */
    public static function setPostMetaFw(
        int $postId,
        string $metaKey,
        mixed $metaValue,
        bool $usePrefix = true
    ): void {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        \carbon_set_post_meta($postId, $metaKey, $metaValue);
    }


    /**
     * Gets Term Meta
     *
     * @param int    $termId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getTermMeta(
        int $termId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = _SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \get_term_meta($termId, $metaKey, true);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }

    /**
     * Gets Term Meta
     *
     * @param int    $termId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getTermMetaFw(
        int $termId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \carbon_get_term_meta($termId, $metaKey);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets User Meta
     *
     * @param int    $userId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getUserMeta(
        int $userId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = _SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \get_user_meta($userId, $metaKey, true);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Gets User Meta with framework functionality
     *
     * @param int    $userId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getUserMetaFw(
        int $userId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \carbon_get_user_meta($userId, $metaKey);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Sets User Meta with framework functionality
     *
     * @param int    $userId
     * @param string $metaKey
     * @param mixed  $metaValue
     * @param bool   $usePrefix
     */
    public static function setUserMetaFw(
        int $userId,
        string $metaKey,
        mixed $metaValue,
        bool $usePrefix = true
    ): void {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        \carbon_set_user_meta($userId, $metaKey, $metaValue);
    }


    /**
     * Gets Menu Meta Item with framework functionality
     *
     * @param int    $menuItemId
     * @param string $metaKey
     * @param mixed  $defaultValue
     * @param bool   $usePrefix
     *
     * @return mixed
     */
    public static function getMenuItemMetaFw(
        int $menuItemId,
        string $metaKey,
        mixed $defaultValue = null,
        bool $usePrefix = true
    ): mixed {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        $value   = \carbon_get_nav_menu_item_meta($menuItemId, $metaKey);

        return in_array($value, ['', false, null, []], true) ? $defaultValue : $value;
    }


    /**
     * Sets Menu Item Meta with framework functionality
     *
     * @param int    $menuItemId
     * @param string $metaKey
     * @param mixed  $metaValue
     * @param bool   $usePrefix
     */
    public static function setMenuItemMetaFw(
        int $menuItemId,
        string $metaKey,
        mixed $metaValue,
        bool $usePrefix = true
    ): void {
        $prefix  = SK_PREFIX;
        $metaKey = $usePrefix ? self::addPrefix($metaKey, $prefix) : $metaKey;
        \carbon_set_nav_menu_item_meta($menuItemId, $metaKey, $metaValue);
    }


    /**
     * Adds theme prefix
     *
     * @param string $name
     * @param string $prefix
     *
     * @return string
     */
    public static function addPrefix(string $name, string $prefix = SK_PREFIX): string
    {
        if (!$prefix) {
            return $name;
        }

        return self::isPrefixed($name, $prefix) ? $name : $prefix . $name;
    }


    /**
     * Checks if string is prefixed
     *
     * @param string $name
     * @param string $prefix
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
     * @param string|null $method Request method. Optinal. Default null - any method.
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

    /**
     * Converts a string from camel case (like "SomeString") to a kebab-case format (like "some-string").
     *
     * @param $input
     *
     * @return string
     */
    public static function camelToKebab($input): string
    {
        $output = preg_replace('/(?<!^)[A-Z]/', '-$0', $input);

        return strtolower($output);
    }
}
