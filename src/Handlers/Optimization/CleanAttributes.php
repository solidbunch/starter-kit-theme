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
class CleanAttributes
{
    public static function init(): void
    {
        if (is_admin()) {
            return;
        }

        if (!empty(Config::get('optimization/cleanBodyClass'))) {
            add_filter('body_class', [self::class, 'cleanBodyClass']);
        }

        if (!empty(Config::get('optimization/removeAssetsAttributes'))) {
            add_filter('style_loader_tag', [self::class, 'removeAssetsAttributes'], 10, 2);
            add_filter('script_loader_tag', [self::class, 'removeAssetsAttributes'], 10, 2);
        }
    }

    /**
     * Clean body class
     *
     * @param array $classes
     *
     * @return array
     */
    public static function cleanBodyClass(array $classes): array
    {
        $remove_classes = [
            'page-template-default',
            'no-customize-support',
            'wp-custom-logo',
            'wp-embed-responsive',
        ];

        // Add post/page slug if not present
        if (is_single() || is_page() && !is_front_page()) {
            if (!in_array($slug = basename(get_permalink()), $classes, true)) {
                $classes[] = $slug;
            }
        }

        if (is_front_page()) {
            $remove_classes[] = 'page-id-' . get_option('page_on_front');
        }

        return array_values(array_diff($classes, $remove_classes));
    }

    /**
     * Remove assets attributes
     *
     * @param string $tag
     * @param string $handle
     *
     * @return string
     */
    public static function removeAssetsAttributes(string $tag, string $handle): string
    {
        $tag = preg_replace("/ id=['\"](.*?)['\"]/", '', $tag);

        return preg_replace("/\s+media=['\"]all['\"]/", '', $tag);
    }
}
