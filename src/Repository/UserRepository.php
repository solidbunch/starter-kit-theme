<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use WP_User;
use StarterKit\Helper\Utils;

class UserRepository implements WpUserRepositoryInterface
{
    /**
     * Gets List of users.
     *
     * @param array $args
     *
     * @return \stdclass [] | int[] | WP_User[]
     */
    public static function get(array $args = []): array
    {
        $defaults = [
            'role'                => '',
            'role__in'            => [],
            'role__not_in'        => [],
            'meta_key'            => '',
            'meta_value'          => '',
            'meta_compare'        => '',
            'meta_query'          => [],
            'include'             => [],
            'exclude'             => [],
            'orderby'             => 'login',
            'order'               => 'ASC',
            'offset'              => '',
            'search'              => '',
            'search_columns'      => [],
            'number'              => '',
            'paged'               => 1,
            'count_total'         => false,
            'fields'              => 'all',
            'who'                 => '',
            'has_published_posts' => null,
            'date_query'          => [] // see WP_Date_Query
        ];

        $args = (array)\wp_parse_args($args, $defaults);

        return get_users($args);
    }


    /**
     *  Gets user by Id.
     *
     * @param int $userId
     *
     * @return \WP_User|null
     */
    public static function getById(int $userId): WP_User|null
    {
        return get_user_by('ID', $userId) ?: null;
    }


    /**
     * Gets User Avatar Image Id
     *
     * @param int $userId
     *
     * @return int
     */
    public static function getAvatarId(int $userId): int
    {
        return (int)Utils::getUserMeta($userId, 'avatar_id');
    }


    /**
     * Gets User Avatar Image URL.
     *
     * @param int          $userId
     * @param string|int[] $size
     *
     * @return string
     */
    public static function getAvatarUrl(int $userId, string|array $size = 'full'): string
    {
        $avatarId = static::getAvatarId($userId);

        return \wp_get_attachment_image_url($avatarId, $size) ?: '';
    }


    /**
     * Gets User position.
     *
     * @param int $userId
     *
     * @return string
     */
    public static function getPosition(int $userId): string
    {
        return (string)Utils::getUserMeta($userId, 'position');
    }
}
