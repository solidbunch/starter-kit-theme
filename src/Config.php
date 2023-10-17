<?php

namespace StarterKit;

defined('ABSPATH') || exit;

/**
 * Theme configuration handler
 *
 * @package    Starter Kit
 */
class Config
{
    /**
     * Application main configuration
     *
     * @return array
     */
    private static function main(): array
    {
        return [
            'settingsPrefix'   => 'skt_',
            'restApiNamespace' => 'skt/v1',
            'assetsUri'        => '/assets/',
            'blocksDir'        => get_template_directory() . '/blocks/',
            'blocksCategory'   => 'starter-kit',
            'blocksViewDir'    => 'view/',
        ];
    }

    /**
     * Post types configuration
     *
     * @return array
     */
    private static function postTypes(): array
    {
        return [
            'postTypeID'               => 'post_type',
            'postTypeSlug'             => 'post_types',
            'postTypeTaxonomyID'       => 'post_type-category',
            'postTypeTagID'            => 'post_type-tag',
        ];
    }

    /**
     * Security configuration
     *
     * @return array
     */
    private static function security(): array
    {
        return [
            // ToDo add key to .env
            //'restApiKey'     => defined('REST_API_KEY') ? REST_API_KEY,
        ];
    }

    /**
     * Optimization configuration
     *
     * @return array
     */
    private static function optimization(): array
    {
        return [
            'cleanWpHead'               => true,
            'removeBlocksDefaultStyles' => true,
            'cleanBodyClass'            => true,
            'removeAssetsAttributes'    => true,
            'disableComments'           => true,
            'addNoCacheHeaders'         => false,
        ];
    }

    /**
     * Get config value by key
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        $config = self::getConfig();

        return $config[$key] ?? '';
    }

    /**
     * Get all config
     *
     * @return array
     */
    public static function getConfig(): array
    {
        $config = array_merge(
            self::main(),
            self::postTypes(),
            self::security(),
            self::optimization(),
        );

        return apply_filters('starter_kit/config', $config);
    }

}
