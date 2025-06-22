<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Handlers\PostTypes;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class DocPageRepository extends WpPostRepositoryAbstract
{
    public static function getPostTypeKey(): string
    {
        return PostTypes\DocPage::getKey();
    }

    /**
     * Returns all pricing with metadata
     *
     * @param array $args
     *
     * @return array
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
                'link'  => get_permalink($post->ID),
            ];
        }

        return $values;
    }
}
