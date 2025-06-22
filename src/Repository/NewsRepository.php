<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Handlers\PostTypes;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class NewsRepository extends WpPostRepositoryAbstract
{
    /**
     * Gets the key of the post type for this repository
     *
     * @return string
     */
    public static function getPostTypeKey(): string
    {
        return PostTypes\News::getKey();
    }


    /**
     * Gets recent News
     *
     * @param int   $limit
     * @param bool  $withThumbnailOnly
     * @param array $exclude
     *
     * @return WP_Post[]
     */
    public static function getRecentNews(int $limit, bool $withThumbnailOnly = false, array $exclude = []): array
    {
        return static::getRecentPosts($limit, $withThumbnailOnly, $exclude);
    }


    /**
     * Gets related News
     *
     * @param int    $primaryPostId
     * @param int    $limit
     * @param string $taxonomy
     * @param bool   $withThumbnailOnly
     *
     * @return WP_Post[]
     */
    public static function getRelatedNews(
        int $primaryPostId,
        int $limit,
        string $taxonomy = 'category',
        bool $withThumbnailOnly = false
    ): array {
        return static::getRelatedPosts($primaryPostId, $limit, $taxonomy, $withThumbnailOnly);
    }


    /**
     * Gets random News
     *
     * @param int   $limit
     * @param bool  $withThumbnailOnly
     * @param array $exclude
     *
     * @return WP_Post[]
     */
    public static function getRandomNews(int $limit, bool $withThumbnailOnly = false, array $exclude = []): array
    {
        return static::getRandomPosts($limit, $withThumbnailOnly, $exclude);
    }


    /**
     * @param float $impact
     *
     * @return array
     */
    public static function getNewsPowerByImpact(float $impact): array
    {
        return match (true) {
            $impact >= 9.01 => ['title' => 'Definitely', 'color' => 'definitely'],
            $impact >= 7.01 => ['title' => 'Very Strong', 'color' => 'very-strong'],
            $impact >= 5.01 => ['title' => 'Strong', 'color' => 'strong'],
            $impact >= 3.01 => ['title' => 'Weak', 'color' => 'weak'],
            $impact >= 1.01 => ['title' => 'Very Weak', 'color' => 'very-weak'],
            $impact >= 0 => ['title' => 'Slightly', 'color' => 'slightly'],
            default => ['title' => 'No Power', 'color' => 'gray'],
        };
    }
}
