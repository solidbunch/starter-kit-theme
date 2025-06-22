<?php

namespace StarterKit\Handlers\Optimization;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Completely remove comments support
 * if defined in Config
 *
 * @package    Starter Kit
 */
class Comments
{
    public static function disableComments(): void
    {
        if (empty(Config::get('optimization/disableComments'))) {
            return;
        }

        add_action('admin_init', [self::class, 'removeCommentsSupport']);

        // Close comments on the front-end
        add_filter('comments_open', '__return_false', 20, 2);
        add_filter('pings_open', '__return_false', 20, 2);

        // Hide existing comments
        add_filter('comments_array', '__return_empty_array', 10, 2);

        // Remove comments page in menu
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        // Remove comments links from admin bar
        add_action('init', [self::class, 'removeFromAdminBar']);

        add_filter('rewrite_rules_array', [self::class, 'removeCommentsFromRewrites']);
    }

    public static function removeCommentsSupport(): void
    {
        // Redirect any user trying to access comments page
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_safe_redirect(admin_url());
            exit;
        }

        // Remove comments metabox from dashboard
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

        // Disable support for comments and trackbacks in post types
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    public static function removeFromAdminBar(): void
    {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    }

    /**
     * Remove comments pages from rewrite rules
     * comment-page-([0-9]{1,})/?$
     *
     * @param array $rules
     *
     * @return array
     */
    public static function removeCommentsFromRewrites(array $rules): array
    {
        foreach ($rules as $rule => $rewrite) {
            if (str_contains($rewrite, '?cpage=') || str_contains($rewrite, '&cpage=')) {
                unset($rules[$rule]);
            }
        }

        return $rules;
    }
}
