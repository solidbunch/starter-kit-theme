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
            'settingsPrefix'      => 'skt_',
            'restApiNamespace'    => 'skt/v1',
            'assetsUri'           => '/assets/',
            'blocksDir'           => get_template_directory() . '/blocks/',
            'blocksIcons'         => '',
            'blocksCategorySlug'  => 'starter-kit',
            'blocksCategoryTitle' => 'StarterKit Blocks',
            'blocksViewDir'       => 'view/',
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
            'postTypeNewsID'          => 'news',
            'postTypeNewsSlug'        => 'news',
            'postTypeNewsTaxonomyID'  => 'news-category',
            'postTypeNewsTagID'       => 'news-tag',
            'postTypePortfolioID'     => 'portfolio',
            'postTypePortfolioSlug'   => 'portfolio',
            'postTypeTeamMembersID'   => 'team_members',
            'postTypeTeamMembersSlug' => 'team-members',
            'postTypeServicesID'      => 'services',
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
            'allowOnlyThemeRestNamespace' => true,
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
            'removeDefaultBlocksStyles' => true,
            'removeDefaultBlocks'       => true,
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
