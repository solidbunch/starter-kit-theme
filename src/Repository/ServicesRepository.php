<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class ServicesRepository extends WpPostRepositoryAbstract
{
    public static function getPostTypeID(): string
    {
        return Config::get('postTypes/ServicesID');
    }
}
