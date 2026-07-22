<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Carbon Fields container for the "Example Page" classic template.
 *
 * ONE container demonstrates the whole spectrum: plain/fixed fields hardcoded into this template
 * (hero title/subtitle, intro) AND a flexible, editor-managed builder (the "Page sections" complex
 * field). Fixed vs builder is a per-field choice inside the same container — not two mechanisms.
 *
 * Paired with Repository\PageExampleRepository, the only place these fields are read back; this
 * class only registers them. Copy this shape for any project page: duplicate under a new name,
 * change the ->where('post_template', ...) target and the field keys, keep or drop the builder
 * field depending on whether that page needs editor-managed section reordering.
 *
 * @package    Starter Kit
 */
class PageExampleMeta
{
    private static string $metaPrefix = SK_PREFIX . 'page_example__';

    public static function make(): void
    {
        $prefix = self::$metaPrefix;

        Container::make('post_meta', __('Example page', 'starter-kit'))
                 ->where('post_template', '=', 'page-example.php')
                 ->add_fields([

                     // --- Fixed fields: hardcoded into this template's design ---
                     Field::make('separator', $prefix . 'sep_hero', __('Hero (fixed fields)', 'starter-kit')),

                     Field::make('text', $prefix . 'hero_title', __('Hero title', 'starter-kit'))
                          ->set_width(50),

                     Field::make('text', $prefix . 'hero_subtitle', __('Hero subtitle', 'starter-kit'))
                          ->set_width(50),

                     Field::make('rich_text', $prefix . 'intro', __('Intro text', 'starter-kit')),

                     // --- Flexible builder: editor-managed, reorderable sections ---
                     Field::make(
                         'separator',
                         $prefix . 'sep_sections',
                         __('Page sections (flexible builder)', 'starter-kit')
                     ),

                     Field::make('complex', $prefix . 'sections', __('Page sections', 'starter-kit'))
                          ->set_layout('tabbed-vertical')
                          ->add_fields('hero', __('Hero', 'starter-kit'), [
                              Field::make('text', 'title', __('Title', 'starter-kit')),
                              Field::make('text', 'subtitle', __('Subtitle', 'starter-kit')),
                              Field::make('image', 'image', __('Image', 'starter-kit')),
                              Field::make('text', 'button_text', __('Button text', 'starter-kit'))
                                   ->set_width(50),
                              Field::make('text', 'button_url', __('Button URL', 'starter-kit'))
                                   ->set_width(50),
                          ])
                          ->add_fields('text', __('Text', 'starter-kit'), [
                              Field::make('text', 'heading', __('Heading', 'starter-kit')),
                              Field::make('rich_text', 'content', __('Content', 'starter-kit')),
                          ])
                          ->add_fields('cta', __('Call to action', 'starter-kit'), [
                              Field::make('text', 'heading', __('Heading', 'starter-kit')),
                              Field::make('text', 'button_text', __('Button text', 'starter-kit'))
                                   ->set_width(50),
                              Field::make('text', 'button_url', __('Button URL', 'starter-kit'))
                                   ->set_width(50),
                          ]),

                 ]);
    }
}
