<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Config;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class ServicesRepository extends AbstractWpPostRepository
{

    public static function getPostTypeID(): string
    {
        return Config::get('postTypeServicesID');
    }

}
