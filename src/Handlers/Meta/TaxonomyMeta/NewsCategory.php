<?php

namespace StarterKit\Handlers\Meta\TaxonomyMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Base\Config;

/**
 * Taxonomy meta data handler
 *
 * @package    Starter Kit
 */
class NewsCategory
{

    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . Config::get('postTypeNewsTaxonomyID') . '_';

        Container::make('term_meta', __('News Category Settings', 'starter-kit'))
                 ->where('term_taxonomy', '=', Config::get('postTypeNewsTaxonomyID'))
                 ->add_fields([
                     Field::make('image', $metaPrefix . 'image_id', __('Image', 'starter-kit')),
                 ]);
    }
}
