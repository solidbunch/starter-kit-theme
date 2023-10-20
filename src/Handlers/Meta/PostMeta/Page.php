<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Config;
use StarterKit\Repository\CountryRepository;

/**
 * Post type meta data handler
 *
 * @package    Starter Kit
 */
class Page
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . 'page_';

        $countries = CountryRepository::getCountries();

        Container::make('post_meta', __('Page Settings', 'starter-kit'))
                 ->where('post_type', '=', 'page')
                 ->set_priority('default')
                 ->add_fields([
                     Field::make('multiselect', $metaPrefix . 'countries', __('Countries for current page', 'starter-kit'))
                          ->set_options($countries)
                          ->set_help_text(__('What countries are related to this page', 'starter-kit'))
                          ->set_width(30),
                 ]);
    }

}
