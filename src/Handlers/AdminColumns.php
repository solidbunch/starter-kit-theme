<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use StarterKit\Config;

/**
 * Add custom columns to admin post list
 *
 * @package    Starter Kit
 */
class AdminColumns
{
    public static function addImgColumn($columns): array
    {
        $columns['image'] = esc_html__('Featured Image', 'starter-kit');

        return $columns;
    }

    public static function manageImgColumn($columnName, $postId)
    {
        if ($columnName == 'image') {
            echo get_the_post_thumbnail($postId, 'thumbnail');
        }

        return $columnName;
    }

    public static function addNewsCategoryFilter($currentPostType, $which): void
    {
        $postType = Config::get('postTypeNewsID');
        $taxonomy = Config::get('postTypeNewsTaxonomyID');

        if ($currentPostType == $postType) {
            wp_dropdown_categories([
                'show_option_all' => get_taxonomy($taxonomy)->labels->all_items,
                'taxonomy'        => $taxonomy,
                'name'            => 'term',
                'value_field'     => 'slug',
                'orderby'         => 'name',
                'selected'        => $_GET['term'] ?? '',
                'show_count'      => true,
                'hide_empty'      => false,
            ]);

            echo '<input type="hidden" name="taxonomy" value="' . $taxonomy . '">';
        }
    }

}
