<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use WP_Query;
use WP_Post;

/**
 * Repository interface for WP_Post objects
 *
 * @package    Starter Kit
 */
interface WpPostRepositoryInterface
{
    /**
     * Get query by specific args
     *
     * @param  array  $args
     *
     * @return WP_Query
     */
    public static function getQuery(array $args): WP_Query;


    /**
     * Get WP_Post objects array
     *
     * @param  array  $args
     *
     * @return WP_Post []
     */
    public static function get(array $args): array;


    /**
     * Get array for Autocomplete param type
     *
     * @param  array  $args
     *
     * @return array
     */
    public static function getAutocompleteValues(array $args): array;
}
