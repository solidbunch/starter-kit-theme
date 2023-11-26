<?php

namespace StarterKit\Handlers\Security;

defined('ABSPATH') || exit;

/**
 * Security
 *
 * Provides some security options
 *
 * @package    Starter Kit
 */
class Xmlrpc
{
    /**
     * Disables trackbacks/pingbacks
     * In general xmlrpc.php should be closed in nginx/apache config
     * see nginx/common.conf.template
     */
    public static function disableXmlrpcTrackbacks(): void
    {
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('xmlrpc_methods', [self::class, 'filterXmlrpcMethod']);
        add_filter('wp_headers', [self::class, 'filterHeaders']);
        add_filter('rewrite_rules_array', [self::class, 'removeTrackbacksFromRewrites']);
        add_filter('bloginfo_url', [self::class, 'killPingbackUrl'], 10, 2);
        add_action('xmlrpc_call', [self::class, 'killXmlrpc']);
        // <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://example.com/xmlrpc.php?rsd" />
        remove_action('wp_head', 'rsd_link');
    }

    /**
     * Disable pingback XMLRPC method
     *
     * @param $methods
     *
     * @return mixed
     */
    public static function filterXmlrpcMethod($methods): mixed
    {
        unset($methods['pingback.ping']);

        return $methods;
    }

    /**
     * Remove pingback header
     *
     * @param $headers
     *
     * @return mixed
     */
    public static function filterHeaders($headers): mixed
    {
        if (isset($headers['X-Pingback'])) {
            unset($headers['X-Pingback']);
        }

        return $headers;
    }

    /**
     * Kill trackback rewrite rule
     *
     * @param  array  $rules
     *
     * @return array
     */
    public static function removeTrackbacksFromRewrites(array $rules): array
    {
        foreach ($rules as $rule => $rewrite) {
            if (preg_match('/trackback\/\?\$$/i', $rule)) {
                unset($rules[$rule]);
            }
        }

        return $rules;
    }

    /**
     * Kill bloginfo('pingback_url')
     *
     * @param $output
     * @param $show
     *
     * @return string
     */
    public static function killPingbackUrl($output, $show): string
    {
        if ($show === 'pingback_url') {
            $output = '';
        }

        return $output;
    }

    /**
     * Disable XMLRPC call
     *
     * @param $action
     */
    public static function killXmlrpc($action): void
    {
        if ($action === 'pingback.ping') {
            status_header(404);
            nocache_headers();
            // ToDo return 404 template
            exit;
        }
    }
}
