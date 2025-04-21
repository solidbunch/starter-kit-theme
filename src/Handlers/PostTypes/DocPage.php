<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;


/**
 * Post type class
 *
 * @package    Starter Kit
 */
class DocPage
{
    public static function getKey(): string
    {
        return 'doc-page';
    }

    public static function getRewriteSlug(): string
    {
        return 'doc';
    }

    /**
     * Register post type
     *
     * @return void
     */
    public static function registerPostType(): void
    {
        register_post_type(
            static::getKey(),
            [
                'label'             => esc_html__('Doc Pages', 'starter-kit'),
                'description'       => '',
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => true, // Use Gutenberg editor
                'show_in_menu'      => true,
                'show_in_nav_menus' => true,
                'capability_type'   => 'page',
                'hierarchical'      => true,
                'supports'          => [
                    'title',
                    'editor',
                    'author',
                    'revisions',
                    'page-attributes',
                ],
                'rewrite'           => [
                    'slug'         => static::getRewriteSlug(),
                    'with_front'   => false,
                    'hierarchical' => true,
                ],
                'has_archive'       => false,
                'query_var'         => true,
                'menu_position'     => 5,
                // https://wp-kama.com/function/register_post_type#menu_icon
                'menu_icon'         => 'dashicons-book',
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
                    'name'               => esc_html__('Doc Pages', 'starter-kit'),
                    'singular_name'      => esc_html__('Doc Page', 'starter-kit'),
                    'menu_name'          => esc_html__('Doc Pages', 'starter-kit'),
                    'add_new'            => esc_html__('Add Doc Page', 'starter-kit'),
                    'add_new_item'       => esc_html__('Add Doc Page', 'starter-kit'),
                    'all_items'          => esc_html__('All Doc Pages', 'starter-kit'),
                    'edit_item'          => esc_html__('Edit Doc Page', 'starter-kit'),
                    'new_item'           => esc_html__('New Doc Page', 'starter-kit'),
                    'view_item'          => esc_html__('View Doc Page', 'starter-kit'),
                    'search_items'       => esc_html__('Search Doc Page', 'starter-kit'),
                    'not_found'          => esc_html__('No Doc Page Found', 'starter-kit'),
                    'not_found_in_trash' => esc_html__('No Doc Page Found in Trash', 'starter-kit'),
                    'parent_item_colon'  => esc_html__('Parent Doc Page:', 'starter-kit'),
                ],
            ]
        );
    }
}
