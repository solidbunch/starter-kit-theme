<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;

use StarterKit\Config;

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
        register_post_type(Config::get('postTypeNewsID'), [
            'label'             => esc_html__('News', 'starter-kit'),
            'description'       => '',
            'public'            => true,
            'show_ui'           => true,
            // Use Gutenberg editor
            'show_in_rest'      => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'capability_type'   => 'post',
            'hierarchical'      => false,
            'supports'          => ['title', 'editor', 'thumbnail', 'page-attributes'],
            'rewrite'           => ['slug' => Config::get('postTypeNewsSlug')],
            'has_archive'       => true,
            'query_var'         => false,
            'menu_position'     => 5,
            //'menu_icon'         => 'dashicons-welcome-write-blog',
            'menu_icon'         => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="black" d="M96 96c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H80c-44.2 0-80-35.8-80-80V128c0-17.7 14.3-32 32-32s32 14.3 32 32V400c0 8.8 7.2 16 16 16s16-7.2 16-16V96zm64 24v80c0 13.3 10.7 24 24 24H296c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm208-8c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zM160 304c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z"/></svg>' ),
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
            Config::get('postTypeNewsTaxonomyID'), Config::get('postTypeNewsID'), [
                'hierarchical'      => true,
                'show_ui'           => true,
                'public'            => true,
                'query_var'         => true,
                'show_in_nav_menus' => true,
                'rewrite'           => true,
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
            Config::get('postTypeNewsTagID'), Config::get('postTypeNewsID'), [
                'hierarchical'      => true,
                'show_ui'           => true,
                'public'            => true,
                'query_var'         => true,
                'show_in_nav_menus' => true,
                'rewrite'           => true,
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
