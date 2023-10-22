<?php

namespace StarterKit\Handlers\Security;

defined('ABSPATH') || exit;

use StarterKit\Config;

/**
 * Allow only defined REST API requests from FrontEnd
 *
 * @package    Starter Kit
 */
class RestApiFilter
{
    public static function allowOnlyThemeNamespace(): void
    {
        $requestUri     = $_SERVER['REQUEST_URI'];
        $referer        = $_SERVER['HTTP_REFERER'] ?? '';
        $allowedRestUri = '/wp-json/' . Config::get('restApiNamespace') . '/';

        if (str_contains($requestUri, '/wp-json') || isset($_GET['rest_route'])) {
            // Allow access for editors and administrators only from the admin panel
            if ((current_user_can('editor') || current_user_can('administrator')) && str_starts_with($referer, site_url('/') . 'wp-admin/')) {
                return;
            }

            // Allow access for the custom namespace only (disable custom namespace root request too)
            if (!str_starts_with($requestUri, $allowedRestUri) || $requestUri === $allowedRestUri) {
                status_header(404);
                nocache_headers();
                get_404_template();
                exit;
            }
        }
    }
}
