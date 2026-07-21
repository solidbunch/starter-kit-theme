<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Carbon Fields "Page Sections" flexible-content page builder for the `page` post type.
 *
 * Read back with Utils::getPostMetaFw($postId, SK_PREFIX . 'page_sections', []) — see
 * page.php's dispatch loop and template-parts/sections/{hero,text,cta}.php for the consumer
 * side of this contract.
 *
 * @package    Starter Kit
 */
class PageBuilder
{
    public static function make(): void
    {
        $metaPrefix = SK_PREFIX . 'page_';

        Container::make('post_meta', __('Page Builder', 'starter-kit'))
                 ->where('post_type', '=', 'page')
                 ->add_fields([
                     Field::make('complex', $metaPrefix . 'sections', __('Sections', 'starter-kit'))
                          ->set_layout('tabbed-vertical')
                          ->add_fields('hero', __('Hero', 'starter-kit'), [
                              Field::make('text', 'title', __('Title', 'starter-kit')),
                              Field::make('textarea', 'subtitle', __('Subtitle', 'starter-kit')),
                              Field::make('image', 'image', __('Image', 'starter-kit')),
                              Field::make('text', 'button_text', __('Button Text', 'starter-kit')),
                              Field::make('text', 'button_url', __('Button URL', 'starter-kit')),
                          ])
                          ->add_fields('text', __('Text', 'starter-kit'), [
                              Field::make('text', 'heading', __('Heading', 'starter-kit')),
                              Field::make('rich_text', 'content', __('Content', 'starter-kit')),
                          ])
                          ->add_fields('cta', __('Call To Action', 'starter-kit'), [
                              Field::make('text', 'heading', __('Heading', 'starter-kit')),
                              Field::make('text', 'button_text', __('Button Text', 'starter-kit')),
                              Field::make('text', 'button_url', __('Button URL', 'starter-kit')),
                          ]),
                 ]);
    }
}
