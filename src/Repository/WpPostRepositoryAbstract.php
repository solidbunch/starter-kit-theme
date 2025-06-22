<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;
use WP_Query;
use WP_Post;

/**
 * Repository abstract for WP_Post objects
 *
 * @package    Starter Kit
 */
abstract class WpPostRepositoryAbstract implements WpPostRepositoryInterface
{
    /**
     * Gets the key of the post type for this repository
     *
     * @return string
     */
    abstract public static function getPostTypeKey(): string;


    /**
     * Gets posts WP_Query by params
     *
     * @param array $args
     *
     * @return WP_Query
     */
    public static function getQuery(array $args = []): WP_Query
    {
        $defaults = [
            'post_type'      => static::getPostTypeKey(),
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ],
        ];

        $args = wp_parse_args($args, $defaults);

        // tax_query_type, taxonomy_slug, taxonomy_terms - custom arguments
        if (isset($args['tax_query_type'])) {
            $taxonomySlug  = $args['taxonomy_slug'];
            $taxonomyTerms = explode(',', $args['taxonomy_terms']);

            if ($args['tax_query_type'] === 'only') {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomySlug,
                        'field'    => 'slug',
                        'terms'    => $taxonomyTerms,
                    ],
                ];
            } elseif ($args['tax_query_type'] === 'except') {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomySlug,
                        'field'    => 'slug',
                        'terms'    => $taxonomyTerms,
                        'operator' => 'NOT IN',
                    ],
                ];
            }
        }

        return new WP_Query($args);
    }


    /**
     * Gets WP_Post objects array
     *
     * @param array $args
     *
     * @return WP_Post[]
     */
    public static function get(array $args = []): array
    {
        unset($args['fields']); // prevent unexpected return
        $query  = static::getQuery($args);
        $result = $query->get_posts();
        wp_reset_postdata();

        return $result;
    }


    /**
     * Gets an array of Ids of the WP_Post objects
     *
     * @param array $args
     *
     * @return Int[]
     */
    public static function getIds(array $args = []): array
    {
        $args['fields'] = 'ids'; // prevent unexpected return
        $query          = static::getQuery($args);
        $result         = $query->get_posts();
        wp_reset_postdata();

        return $result;
    }


    /**
     * Gets a list of the WP_Post objects data
     *
     * @param array $args
     * @param bool  $keySlug
     *
     * @return array
     */
    public static function getAllList(array $args = [], bool $keySlug = false): array
    {
        $posts  = static::get($args);
        $values = [];

        foreach ($posts as $post) {
            /** @var WP_Post $post */

            if ($keySlug) {
                $values[$post->post_name] = $post->post_title;
            } else {
                $values[$post->ID] = $post->post_title;
            }
        }

        return $values;
    }


    /**
     * Gets a list of the WP_Post objects data with pagination
     *
     * @param array $args
     * @param bool  $keySlug
     *
     * @return array
     */
    public static function getPagedList(array $args = [], bool $keySlug = false): array
    {
        $query      = static::getQuery($args);
        $posts      = $query->get_posts();
        $values     = [];
        $totalPages = $query->max_num_pages;
        wp_reset_postdata();

        foreach ($posts as $post) {
            /** @var WP_Post $post */

            if ($keySlug) {
                $values[$post->post_name] = $post->post_title;
            } else {
                $values[$post->ID] = $post->post_title;
            }
        }

        return [
            $values,
            $args['paged'] ?? 1,
            $totalPages,
        ];
    }


    /**
     * Gets a list of the WP_Post objects data extended
     *
     * @param array $args
     *
     * @return array
     */
    public static function getAllListExt(array $args = []): array
    {
        $posts  = static::get($args);
        $values = [];

        foreach ($posts as $post) {
            /** @var WP_Post $post */
            $data = [];

            $data['id']    = $post->ID;
            $data['slug']  = $post->post_name;
            $data['title'] = $post->post_title;

            $values[] = $data;
        }

        return $values;
    }


    /**
     * Gets recent posts
     *
     * @param int   $limit
     * @param bool  $withThumbnailOnly
     * @param array $exclude
     *
     * @return WP_Post[]
     */
    public static function getRecentPosts(int $limit, bool $withThumbnailOnly = false, array $exclude = []): array
    {
        $args = [
            'post_type'           => static::getPostTypeKey(),
            'post_status'         => 'publish',
            'post__not_in'        => $exclude,
            'posts_per_page'      => $limit,
            'orderby'             => [
                'date' => 'DESC',
            ],
            'ignore_sticky_posts' => true,
        ];

        if ($withThumbnailOnly) {
            $args['meta_query'][] = [
                'key' => '_thumbnail_id',
            ];
        }

        return static::get($args);
    }


    /**
     * Gets popular posts
     *
     * @param int   $limit
     * @param bool  $withThumbnailOnly
     * @param array $exclude
     *
     * @return WP_Post[]
     */
    public static function getPopularPosts(int $limit, bool $withThumbnailOnly = false, array $exclude = []): array
    {
        $args = [
            'post_type'           => static::getPostTypeKey(),
            'post_status'         => 'publish',
            'post__not_in'        => $exclude,
            'posts_per_page'      => $limit,
            'orderby'             => [
                'comment_count' => 'DESC',
                'date'          => 'DESC',
            ],
            'ignore_sticky_posts' => true,
        ];

        if ($withThumbnailOnly) {
            $args['meta_query'][] = [
                'key' => '_thumbnail_id',
            ];
        }

        return static::get($args);
    }


    /**
     * Gets related posts
     *
     * @param int    $primaryPostId
     * @param int    $limit
     * @param string $taxonomy
     * @param bool   $withThumbnailOnly
     *
     * @return WP_Post[]
     */
    public static function getRelatedPosts(
        int $primaryPostId,
        int $limit,
        string $taxonomy = 'category',
        bool $withThumbnailOnly = false
    ): array {
        $terms = wp_get_post_terms($primaryPostId, $taxonomy);

        $result = [];

        if (count($terms) > 0) {
            $postTermsIds = [];

            foreach ($terms as $term) {
                $postTermsIds[] = $term->term_id;
            }

            $args = [
                'post_type'           => static::getPostTypeKey(),
                'post_status'         => 'publish',
                'posts_per_page'      => $limit,
                'orderby'             => 'rand',
                'post__not_in'        => [$primaryPostId],
                'tax_query'           => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => $taxonomy,
                        'field'    => 'id',
                        'terms'    => $postTermsIds,
                    ],
                ],
                'ignore_sticky_posts' => true,
            ];

            if ($withThumbnailOnly) {
                $args['meta_query'][] = [
                    'key' => '_thumbnail_id',
                ];
            }

            $result = static::get($args);
        }

        return $result;
    }


    /**
     * Gets random posts
     *
     * @param int   $limit
     * @param bool  $withThumbnailOnly
     * @param array $exclude
     *
     * @return WP_Post[]
     */
    public static function getRandomPosts(int $limit, bool $withThumbnailOnly = false, array $exclude = []): array
    {
        $args = [
            'post_type'           => static::getPostTypeKey(),
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'orderby'             => 'rand',
            'post__not_in'        => $exclude,
            'ignore_sticky_posts' => true,
        ];

        if ($withThumbnailOnly) {
            $args['meta_query'][] = [
                'key' => '_thumbnail_id',
            ];
        }

        return static::get($args);
    }


    /**
     * Checks if wp_post has correct post type
     *
     * @param int|WP_Post $post WP_Post Object or post ID
     *
     * @return bool
     */
    public static function isCorrectPostType(int|WP_Post $post): bool
    {
        if ($post instanceof WP_Post) {
            return static::getPostTypeKey() === $post->post_type;
        }

        $postId = (int)$post;
        if ($postId <= 0) {
            return false;
        }

        return static::getPostTypeKey() === get_post_type($postId);
    }


    /**
     * Gets one wp_post. Mainly used in repository of one page.
     *
     * @return WP_Post|null
     */
    public static function getOne(): WP_Post|null
    {
        $posts = static::get();

        return !empty($posts[0]) && $posts[0] instanceof WP_Post ? $posts[0] : null;
    }


    /**
     * Gets wp_post by post Id.
     *
     * @param int $postId
     *
     * @return WP_Post|null
     */
    public static function getById(int $postId): WP_Post|null
    {
        $post = get_post($postId);

        return static::isCorrectPostType($post) ? $post : null;
    }


    /**
     * Gets wp_post by post slug.
     *
     * @param string $slug
     *
     * @return WP_Post|null
     */
    public static function getBySlug(string $slug): WP_Post|null
    {
        $posts = static::get([
            'name'           => $slug,
            'post_type'      => static::getPostTypeKey(),
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        ]);

        return !empty($posts[0]) && $posts[0] instanceof WP_Post ? $posts[0] : null;
    }


    /**
     * Gets wp_post title.
     *
     * @param int $postId
     *
     * @return string
     */
    public static function getTitle(int $postId): string
    {
        return (string)get_the_title($postId);
    }


    /**
     * Gets wp_post slug.
     *
     * @param int $postId
     *
     * @return string
     */
    public static function getSlug(int $postId): string
    {
        return (string)get_post_field('post_name', $postId);
    }


    /**
     * Gets wp_post Featured Image Id.
     *
     * @param int $postId
     *
     * @return int|null
     */
    public static function getFeaturedImageId(int $postId): int|null
    {
        return get_post_thumbnail_id($postId) ?: null;
    }


    /**
     * Gets wp_post Featured Image URL.
     *
     * @param int          $postId
     * @param string|int[] $size
     *
     * @return string|null
     */
    public static function getFeaturedImageUrl(int $postId, string|array $size = 'full'): string|null
    {
        return get_the_post_thumbnail_url($postId, $size) ?: null;
    }


    /**
     * Gets wp_post content.
     *
     * @param int  $postId
     * @param bool $filter
     *
     * @return string
     */
    public static function getContent(int $postId, bool $filter = true): string
    {
        $contentRaw = get_the_content(null, false, $postId);
        if ($filter) {
            return (string)apply_filters('the_content', $contentRaw);
        }

        return $contentRaw;
    }


    /**
     * Gets RichText Meta Field helper.
     *
     * @param int    $postId
     * @param string $metaKey
     * @param bool   $filter
     *
     * @return string
     */
    protected static function getRichTextField(int $postId, string $metaKey, bool $filter = true): string
    {
        $contentRaw = Utils::getPostMetaFw($postId, $metaKey, '');
        if ($filter) {
            return (string)apply_filters('the_content', $contentRaw);
        }

        return $contentRaw;
    }


    /**
     * Gets Term RichText Meta Field helper.
     *
     * @param int    $termId
     * @param string $metaKey
     * @param bool   $filter
     *
     * @return string
     */
    protected static function getTermRichTextField(int $termId, string $metaKey, bool $filter = true): string
    {
        $contentRaw = Utils::getTermMetaFw($termId, $metaKey, '');
        if ($filter) {
            return (string)apply_filters('the_content', $contentRaw);
        }

        return $contentRaw;
    }


    /**
     * Gets Association Meta Field helper.
     *
     * @param int    $postId
     * @param string $metaKey
     *
     * @return Int[] Array of Ids.
     */
    protected static function getAssociationFieldIds(int $postId, string $metaKey): array
    {
        if (!$postId) {
            return [];
        }

        $items = Utils::getPostMetaFw($postId, $metaKey, []);
        if (!$items || !is_array($items)) {
            return [];
        }

        $ids = [];
        foreach ($items as $item) {
            if (isset($item['id']) && is_numeric($item['id'])) {
                $ids[] = (int)$item['id'];
            }
        }

        return $ids;
    }


    /**
     * Gets Image Meta Field Url helper.
     *
     * @param int          $postId
     * @param string       $metaKey
     * @param string|int[] $size
     *
     * @return string
     */
    protected static function getImageFieldUrl(int $postId, string $metaKey, string|array $size = 'full'): string
    {
        $imageId = (int)Utils::getPostMeta($postId, $metaKey);

        return (string)\wp_get_attachment_image_url($imageId, $size) ?: '';
    }
}
