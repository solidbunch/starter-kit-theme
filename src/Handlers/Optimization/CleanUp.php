<?php

namespace StarterKit\Handlers\Optimization;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Optimization Handlers
 *
 * removes unnecessary tags etc.
 *
 * @package    Starter Kit
 */
class CleanUp
{
    /**
     * Clean up wp_head()
     *
     * Remove unnecessary <link>'s
     * Remove inline CSS and JS from WP emoji support
     * Remove inline CSS used by Recent Comments widget
     * Remove inline CSS used by posts with galleries
     * And other useful stuff
     * How long can you keep this shit
     */
    public static function headCleanup(): void
    {
        if (empty(Config::get('optimization/cleanWpHead'))) {
            return;
        }

        /************************************
         *            Disable feed
         ************************************/
        // <link rel="alternate" type="application/rss+xml" title="WP Site Feed" href="https://example.com/feed/"/>
        remove_action('wp_head', 'feed_links', 2);
        // <link rel="alternate" type="application/rss+xml" title="Comments" href="https://example.com/comments/feed/"/>
        remove_action('wp_head', 'feed_links_extra', 3);
        add_filter('feed_links_show_comments_feed', '__return_false');
        add_filter('the_generator', '__return_false');
        // Feed links should return 404
        add_filter('rewrite_rules_array', [self::class, 'removeFeedFromRewrites']);

        /************************************
         *       Remove all Generators
         ************************************/
        // <meta name="generator" content="WordPress x.x" /> and <meta name="generator" content="WooCommerce x.x.x" />
        remove_action('wp_head', 'wp_generator');
        add_action('wp_head', 'ob_start', 0, 0);
        add_action('wp_head', [self::class, 'cleanAndObAndClean',], PHP_INT_MAX, 0);

        /************************************
         *    Remove Windows Live Writer
         ************************************/
        // <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml"/>
        remove_action('wp_head', 'wlwmanifest_link');

        /************************************
         *       PREV and NEXT links
         ************************************/
        // <link rel='prev' title='The Post Before This One' href='https://example.com/?p=4' />
        remove_action('wp_head', 'adjacent_posts_rel_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

        /************************************
         *  Remove page/post's short links
         ************************************/
        // <link rel='shortlink' href='https://example.com/?p=5' />
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);

        /************************************
         *            Remove emoji
         ************************************/
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('emoji_svg_url', '__return_false');

        /************************************
         *      Remove embed and oembed
         ************************************/
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('rewrite_rules_array', [self::class, 'removeEmbedFromRewrites']);
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        add_filter('embed_oembed_discover', '__return_false');
        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
        add_action('init', [self::class, 'disableEmbedQuery'], 9999);

        /*************************************
         *      Remove REST API link tag
         ************************************/
        // <link rel='https://api.w.org/' href='https://example.com/wp-json/' />
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11);
        remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');

        /************************************
         *  Remove default styles
         ************************************/
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('show_recent_comments_widget_style', '__return_false');
        add_action( 'wp_enqueue_scripts', function() {
            wp_dequeue_style( 'classic-theme-styles' );
        }, 20 );

        /*************************************
         *  SVG filters and Duotone support
         ************************************/
        // https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1048923664
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        remove_filter('render_block', 'wp_render_duotone_support', 10);
    }

    /**
     * Clean up wp_head()
     *
     * Remove all 'generator' tags
     *
     */
    public static function cleanAndObAndClean(): void
    {
        echo preg_replace('/<meta name(.*)=(.*)"generator"(.*)>/i', '', ob_get_clean());
    }

    /**
     * Kill feed rewrite rule, this will make feed links return 404
     *
     * @param array $rules
     *
     * @return array
     */
    public static function removeFeedFromRewrites(array $rules): array
    {
        foreach ($rules as $rule => $rewrite) {
            if (str_contains($rewrite, '?feed=') || str_contains($rewrite, '&feed=')) {
                unset($rules[$rule]);
            }
        }

        return $rules;
    }

    /**
     * Kill embed rewrite rule, this will make embed links return 404
     *
     * @param array $rules
     *
     * @return array
     */
    public static function removeEmbedFromRewrites(array $rules): array
    {
        foreach ($rules as $rule => $rewrite) {
            if (str_contains($rewrite, '?embed=true') || str_contains($rewrite, '&embed=true')) {
                unset($rules[$rule]);
            }
        }


        return $rules;
    }

    /**
     * Remove the embed query var
     */
    public static function disableEmbedQuery(): void
    {
        global $wp;
        $wp->public_query_vars = array_diff($wp->public_query_vars, array(
            'embed',
        ));
    }
}
