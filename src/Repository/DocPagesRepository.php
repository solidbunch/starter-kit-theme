<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class DocPagesRepository extends WpPostRepositoryAbstract
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     */
    public static function getPostTypeID(): string
    {
        return Config::get('postTypes/DocPagesID');
    }

    /**
     * Returns all pricing with metadata
     *
     * @param array $args
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     */
    public static function getAllHierarchicallyWithLinks(array $args): array
    {
        $posts  = static::get($args);
        $values = [];


        foreach ($posts as $post) {
            if (!isset($post->post_parent)) {
                $values[$post->post_parent] = array();
            }

            $values[$post->post_parent][$post->ID] = [
                'title' => $post->post_title,
                'link' => get_permalink($post->ID),
            ];
        }

        return $values;
    }
}
