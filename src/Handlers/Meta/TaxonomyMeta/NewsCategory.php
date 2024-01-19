<?php

namespace StarterKit\Handlers\Meta\TaxonomyMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;

/**
 * Taxonomy meta data handler
 *
 * @package    Starter Kit
 */
class NewsCategory
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . Config::get('postTypes/NewsTaxonomyID') . '_';

        Container::make('term_meta', __('News Category Settings', 'starter-kit'))
                 ->where('term_taxonomy', '=', Config::get('postTypes/NewsTaxonomyID'))
                 ->add_fields([
                     Field::make('image', $metaPrefix . 'image_id', __('Image', 'starter-kit')),
                 ]);
    }
}
