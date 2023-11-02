<?php

namespace StarterKitBlocks\News;

defined('ABSPATH') || exit;

use StarterKit\Config;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Repository\NewsRepository;
use WP_Error;
use WP_HTTP_Response;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class BlockRenderer extends BlockAbstract
{
    /**
     * Block server side render callback
     * Used in register block type from metadata
     *
     * @param $attributes
     * @param $content
     * @param $block
     *
     * @return string
     */
    public static function blockServerSideCallback($attributes, $content, $block): string
    {
        $templateData = [];

        $templateData['newsData']     = 'Some data';
        $templateData['newsCategory'] = $attributes['category'] ?? true;

        return self::loadBlockView('layout', $templateData);
    }

    /**
     * Register rest api endpoints
     * Runs by Blocks Register Handler
     *
     * @return void
     */
    public static function blockRestApiEndpoints(): void
    {
        register_rest_route(Config::get('restApiNamespace'), '/news', [
            'methods'             => 'GET,POST',
            'callback'            => [self::class, 'getNewsCallback'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * REST API endpoint callback
     *
     * @param  WP_REST_Request  $request
     *
     * @return WP_Error|WP_REST_Response|WP_HTTP_Response
     */
    public static function getNewsCallback(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        $requestData = esc_sql(json_decode($request->get_body(), true));
        if (empty($requestData)) {
            status_header(404);
            nocache_headers();
            // ToDo return 404 template
            exit;
        }
        $params        = $requestData['params'];
        $requestedPage = $requestData['page'] ?? 1;
        //$nonce         = $requestData['nonce'];

        $metaPrefix = Config::get('settingsPrefix') . Config::get('postTypeNewsID') . '_';

        $args = [];

        list($news, $page, $totalPages) = NewsRepository::getPagedList($args);

        $response['page']        = $page;
        $response['total_pages'] = $totalPages;
        $response['news']        = $news;

        return rest_ensure_response($response);
    }
}
