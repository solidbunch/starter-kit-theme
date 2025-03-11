<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;


/**
 * Helper functions for multi-language support
 */
class Lang
{
    /**
     * Checks WPML plugin is active
     *
     * @return bool
     */
    public static function isWpmlActive(): bool
    {
        return class_exists(\SitePress::class);
    }


    /**
     * Gets WPML default language
     *
     * @return string
     */
    public static function getDefaultLanguage(): string
    {
        return (string)apply_filters('wpml_default_language', '');
    }


    /**
     * Gets WPML current language
     *
     * @return string
     */
    public static function getCurrentLanguage(): string
    {
        return (string)apply_filters('wpml_current_language', '');
    }


    /**
     * Checks if WPML current language is default
     *
     * @return bool
     */
    public static function isCurrentLanguageDefault(): bool
    {
        return self::getCurrentLanguage() === self::getDefaultLanguage();
    }


    /**
     * Gets a list of the WPML active languages
     *
     * @param array $args Optional. An array of arguments to filter the language output.
     *
     * @return array
     * @see https://wpml.org/wpml-hook/wpml_active_languages/
     */
    public static function getActiveLanguages(array $args = []): array
    {
        $default_args = ['skip_missing' => 0];

        $args = wp_parse_args($args, $default_args);

        return apply_filters('wpml_active_languages', null, $args);
    }


    /**
     * Gets a list of the WPML active languages
     *
     * @param array $args Optional. An array of arguments to filter the language output.
     *
     * @return array
     */
    public static function getActiveLanguagesCodes(array $args = []): array
    {
        $languages = self::getActiveLanguages($args);
        $result    = [];
        foreach ($languages as $language) {
            $result[] = $language['language_code'];
        }

        return $result;
    }


    /**
     * Gets the object id in the specific language
     *
     * @param int         $obj_id Use term_id for taxonomies, post_id for posts.
     * @param string      $type Use post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag, etc.
     *                          You can also pass 'any', to let WPML guess the type, but this will only work for posts.
     * @param bool        $origin_if_missing Optional, default is FALSE. If set to true it will always return a value
     *                              (the original value, if translation is missing).
     * @param string|null $lang Optional, default is NULL. If missing, it will use the current language.
     *                       If set to a language code, it will return a translation for that language code or
     *                       the original if the translation is missing and $original_if_missing is set to TRUE.
     *
     * @return int|null
     */
    public static function getTranslatedId(
        int $obj_id,
        string $type,
        bool $origin_if_missing = false,
        string $lang = null
    ): ?int {
        return apply_filters('wpml_object_id', $obj_id, $type, $origin_if_missing, $lang);
    }


    /**
     *  Gets the object id in the all languages
     *
     * @param int    $obj_id Use term_id for taxonomies, post_id for posts.
     * @param string $type Use post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag, etc.
     *                     You can also pass 'any', to let WPML guess the type, but this will only work for posts.
     * @param bool   $origin_if_missing Optional, default is FALSE. If set to true it will always return a value
     *                          (the original value, if translation is missing).
     *
     * @return array
     */
    public static function getAllTranslatedIds(
        int $obj_id,
        string $type,
        bool $origin_if_missing = false
    ): array {
        $ids = [];

        $languages = self::getActiveLanguagesCodes();
        foreach ($languages as $lang_code) {
            $ids[] = self::getTranslatedId($obj_id, $type, $origin_if_missing, $lang_code);
        }

        return array_filter($ids);
    }


    /**
     * Gets the suffix with current language code
     *
     * @param string $delimiter
     *
     * @return string
     */
    public static function getLangSuffix($delimiter = '_'): string
    {
        $current_lang = static::getCurrentLanguage();

        return $current_lang ? $delimiter . $current_lang : '';
    }
}
