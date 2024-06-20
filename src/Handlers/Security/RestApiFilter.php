<?php

namespace StarterKit\Handlers\Security;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use WP_REST_Request;
use WP_REST_Server;

/**
 * Allow only defined REST API requests from FrontEnd
 *
 * @package    Starter Kit
 */
class RestApiFilter
{
    /**
     * Allow only whitelist REST API requests like https://example.com/wp-json/<namespase>/data
     * Other REST API requests, including default will be disabled
     *
     * @param mixed           $result
     * @param WP_REST_Server  $server
     * @param WP_REST_Request $request
     *
     * @return mixed $result
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public static function restApiWhitelistOnly(
        mixed $result,
        WP_REST_Server $server,
        WP_REST_Request $request
    ): mixed {
        if (!defined('REST_REQUEST') || !Config::get('security/restrictRestApiToWhitelistOnly')) {
            return $result;
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $route   = $request->get_route();

        // Allow access for editors and administrators only from the admin panel
        if (
            (current_user_can('editor') || current_user_can('administrator')) &&
            str_starts_with($referer, site_url('/') . 'wp-admin/')
        ) {
            return $result;
        }

        // Get REST API namespaces whitelist
        $allowedNamespaces = Config::get('security/RestApiNamespaceWhitelist');

        // Add current namespace to allowed list
        $allowedNamespaces[] = Config::get('restApiNamespace');


        foreach ($allowedNamespaces as $allowedNamespace) {
            if ($allowedNamespace[0] !== '/') {
                $allowedNamespace = '/' . $allowedNamespace;
            }

            // Allow access for the whitelist namespace only (disable whitelist namespace root request too)
            if (str_starts_with($route, $allowedNamespace) && $route != $allowedNamespace) {
                return $result;
            }
        }

        status_header(404);
        nocache_headers();
        // ToDo return 404 template
        exit;
    }
}
