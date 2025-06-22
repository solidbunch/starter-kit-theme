<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use WP_User;

interface WpUserRepositoryInterface
{
    /**
     * Gets List of users.
     *
     * @param array $args
     *
     * @return \stdclass [] | int[] | WP_User[]
     */
    public static function get(array $args = []): array;
}
