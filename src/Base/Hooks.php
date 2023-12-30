<?php

namespace StarterKit\Base;

defined('ABSPATH') || exit;

use StarterKit\Handlers;
use StarterKitBlocks;

/**
 * Hooks functionality for the theme.
 *
 * Run hook handlers
 *
 * @package    Starter Kit
 */
class Hooks
{
    public static function initHooks(): void
    {
        /************************************
         *           Setup Theme
         ************************************/
        add_action('after_setup_theme', [Handlers\SetupTheme::class, 'addThemeSupport']);
        add_action('after_setup_theme', [Handlers\SetupTheme::class, 'registerMenus']);

        /************************************
         *          Theme Settings
         ************************************/
        add_action('after_setup_theme', [Handlers\Settings\ThemeSettings::class, 'boot']);
        add_action('carbon_fields_register_fields', [Handlers\Settings\ThemeSettings::class, 'make']);
        add_action(
            'carbon_fields_theme_options_container_saved',
            [Handlers\Settings\ThemeSettings::class, 'updateFaviconFromThemeOptions']
        );

        /************************************
         *         Gutenberg blocks
         ************************************/
        add_action('block_categories_all', [Handlers\Blocks\Register::class, 'registerBlocksCategories']);
        add_action('init', [Handlers\Blocks\Register::class, 'registerBlocks']);
        // ToDo deactivate default blocks if Config optimization/removeDefaultBlocks

        /************************************
         *     PostTypes with Taxonomies
         ************************************/
        add_action('init', [Handlers\PostTypes\News::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\News::class, 'registerCategoryTaxonomy'], 5);
        add_action('init', [Handlers\PostTypes\News::class, 'registerTagTaxonomy'], 5);
        add_action('carbon_fields_register_fields', [Handlers\Settings\NewsSettings::class, 'make']);
        add_action('init', [Handlers\PostTypes\Portfolio::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\TeamMembers::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\Services::class, 'registerPostType'], 5);

        /************************************
         *         Taxonomies admin
         ************************************/
        add_action('restrict_manage_posts', [Handlers\AdminColumns::class, 'addNewsCategoryFilter'], 10, 2);

        /************************************
         *            Post Meta Fields
         ************************************/
        add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\News::class, 'make']);
        add_action('carbon_fields_register_fields', [Handlers\Meta\TaxonomyMeta\NewsCategory::class, 'make']);
        add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\Page::class, 'make']);
        add_filter('manage_posts_columns', [Handlers\AdminColumns::class, 'addImgColumn']);
        add_filter('manage_posts_custom_column', [Handlers\AdminColumns::class, 'manageImgColumn'], 10, 2);

        /************************************
         *            Front
         ************************************/
        add_action('enqueue_block_assets', [Handlers\Front::class, 'enqueueCriticalAssets'], 2);
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'enqueueThemeAssets']);
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'loadFrontendJsData']);
        add_action('enqueue_block_editor_assets', [Handlers\Front::class, 'enqueueBlockEditorAssets']);
        add_action('style_loader_src', [Handlers\Front::class, 'addFileTimeVerToStyles'], 20, 2);
        add_action('send_headers', [Handlers\Front::class, 'addNoCacheHeaders']);
        // Change excerpt dots
        add_filter('excerpt_more', [Handlers\Front::class, 'changeExcerptMore']);
        // GTM
        add_action('wp_head', [Handlers\Front::class, 'addGTMHead']);
        add_action('wp_footer', [Handlers\Front::class, 'addGTMBody']);
        // add Google Analytics code to head
        add_action('wp_head', [Handlers\Front::class, 'addAnalyticsHead']);

        /************************************
         *       Security and CleanUp
         ************************************/
        add_action('init', [Handlers\Security\Xmlrpc::class, 'disableXmlrpcTrackbacks']);
        add_action('init', [Handlers\Security\CleanUp::class, 'headCleanup'], 999);
        add_action('init', [Handlers\Security\Optimization::class, 'init']);
        add_action('init', [Handlers\Security\Comments::class, 'disableComments']);
        add_action('rest_api_init', [Handlers\Security\RestApiFilter::class, 'allowOnlyThemeNamespace']);
    }
}
