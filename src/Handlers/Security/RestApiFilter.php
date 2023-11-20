<?php

namespace StarterKit\Handlers\Security;

defined('ABSPATH') || exit;

use StarterKit\Base\Config;

/**
 * Allow only defined REST API requests from FrontEnd
 *
 * @package    Starter Kit
 */
class RestApiFilter
{
    /**
     * Allow only requests like https://starter-kit.com/wp-json/skt/v1/data
     * Other REST API requests, including default will be disabled
     *
     * @return void
     */
    public static function allowOnlyThemeNamespace(): void
    {
        if (!Config::get('allowOnlyThemeRestNamespace')) {
            return;
        }
        $requestUri     = $_SERVER['REQUEST_URI'];
        $referer        = $_SERVER['HTTP_REFERER'] ?? '';
        $allowedRestUri = '/wp-json/' . Config::get('restApiNamespace') . '/';

        if (defined('REST_REQUEST')) {
            // Allow access for editors and administrators only from the admin panel
            if (
                (current_user_can('editor') || current_user_can('administrator')) &&
                str_starts_with($referer, site_url('/') . 'wp-admin/')
            ) {
                return;
            }

            // Allow access for the custom namespace only (disable custom namespace root request too)
            if (!str_starts_with($requestUri, $allowedRestUri) || $requestUri === $allowedRestUri) {
                status_header(404);
                nocache_headers();
                // ToDo return 404 template
                exit;
            }
        }
    }
}
