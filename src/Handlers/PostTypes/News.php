<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;

use StarterKit\Helper\Logger;
use StarterKit\Helper\Config;

/**
 * Post type class
 *
 * @package    Starter Kit
 */
class News
{
    /**
     * Register post type
     *
     * @return void
     */
    public static function registerPostType(): void
    {
        register_post_type(Config::get('postTypes/NewsID'), [
            'label'             => esc_html__('News', 'starter-kit'),
            'description'       => '',
            'public'            => true,
            'show_ui'           => true,
            'show_in_rest'      => true, // Use Gutenberg editor
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'capability_type'   => 'post',
            'hierarchical'      => false,
            'supports'          => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'revisions',
                'page-attributes'
            ],
            'taxonomies'        => ['news-category'],
            'rewrite'           => ['slug' => Config::get('postTypes/NewsSlug')],
            'has_archive'       => true,
            'query_var'         => false,
            'menu_position'     => 5,
            // https://wp-kama.com/function/register_post_type#menu_icon
            'menu_icon'         => 'dashicons-welcome-write-blog',
            'capabilities'      => [
                'publish_posts'       => 'edit_pages',
                'edit_posts'          => 'edit_pages',
                'edit_others_posts'   => 'edit_pages',
                'delete_posts'        => 'edit_pages',
                'delete_others_posts' => 'edit_pages',
                'read_private_posts'  => 'edit_pages',
                'edit_post'           => 'edit_pages',
                'delete_post'         => 'edit_pages',
                'read_post'           => 'edit_pages',
            ],
            'labels'            => [
                'name'               => esc_html__('News', 'starter-kit'),
                'singular_name'      => esc_html__('News Item', 'starter-kit'),
                'menu_name'          => esc_html__('News', 'starter-kit'),
                'add_new'            => esc_html__('Add News', 'starter-kit'),
                'add_new_item'       => esc_html__('Add News', 'starter-kit'),
                'all_items'          => esc_html__('All News', 'starter-kit'),
                'edit_item'          => esc_html__('Edit News', 'starter-kit'),
                'new_item'           => esc_html__('New News', 'starter-kit'),
                'view_item'          => esc_html__('View News', 'starter-kit'),
                'search_items'       => esc_html__('Search News', 'starter-kit'),
                'not_found'          => esc_html__('No News Found', 'starter-kit'),
                'not_found_in_trash' => esc_html__('No News Found in Trash', 'starter-kit'),
                'parent_item_colon'  => esc_html__('Parent News:', 'starter-kit'),
            ],
        ]);
    }

    /**
     * Register taxonomy Categories
     *
     * @return void
     */
    public static function registerCategoryTaxonomy(): void
    {
        register_taxonomy(
            Config::get('postTypes/NewsTaxonomyID'),
            Config::get('postTypes/NewsID'),
            [
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_in_rest'      => true,
                'hierarchical'      => true,
                'rewrite'           => true,
                'query_var'         => true,
                'show_admin_column' => true,
                'capabilities'      => [
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ],
                'labels'            => [
                    'name'          => esc_html_x('News Categories', 'taxonomy general name', 'starter-kit'),
                    'singular_name' => esc_html_x('News Category', 'taxonomy singular name', 'starter-kit'),
                    'search_items'  => esc_html__('Search in categories', 'starter-kit'),
                    'all_items'     => esc_html__('All Categories', 'starter-kit'),
                    'edit_item'     => esc_html__('Edit Category', 'starter-kit'),
                    'update_item'   => esc_html__('Update Category', 'starter-kit'),
                    'add_new_item'  => esc_html__('Add New Category', 'starter-kit'),
                    'new_item_name' => esc_html__('New Category', 'starter-kit'),
                    'menu_name'     => esc_html__('Categories', 'starter-kit'),
                ],
            ]
        );
    }

    /**
     * Register taxonomy Tags
     *
     * @return void
     */
    public static function registerTagTaxonomy(): void
    {
        register_taxonomy(
            Config::get('postTypes/NewsTagID'),
            Config::get('postTypes/NewsID'),
            [
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_in_rest'      => true,
                'hierarchical'      => true,
                'rewrite'           => true,
                'query_var'         => true,
                'show_admin_column' => true,
                'capabilities'      => [
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ],
                'labels'            => [
                    'name'          => esc_html_x('News Tags', 'taxonomy general name', 'starter-kit'),
                    'singular_name' => esc_html_x('News Tag', 'taxonomy singular name', 'starter-kit'),
                    'search_items'  => esc_html__('Search in tags', 'starter-kit'),
                    'all_items'     => esc_html__('All Tags', 'starter-kit'),
                    'edit_item'     => esc_html__('Edit Tag', 'starter-kit'),
                    'update_item'   => esc_html__('Update Tag', 'starter-kit'),
                    'add_new_item'  => esc_html__('Add New Tag', 'starter-kit'),
                    'new_item_name' => esc_html__('New Tag', 'starter-kit'),
                    'menu_name'     => esc_html__('Tags', 'starter-kit'),
                ],
            ]
        );
    }
}
