<?php

namespace StarterKit\Handlers\Settings;

defined('ABSPATH') || exit;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Config;
use StarterKit\Helper\Utils;

/**
 * Theme settings handler
 *
 * @package    Starter Kit
 */
class ThemeSettings
{
    /**
     * Connect Carbon Fields
     *
     * @return void
     */
    public static function boot(): void
    {
        Carbon_Fields::boot();
    }

    /**
     * Make Carbon Fields
     *
     * @return void
     */
    public static function make(): void
    {
        $prefix = Config::get('settingsPrefix');

        $container = Container::make(
            'theme_options',  // type
            'theme_settings', // id
            __('Site Settings', 'starter-kit') // desc
        );

        $container->set_page_parent('options-general.php'); // id of the "Appearance" admin section
        $container->set_page_menu_title('Site Settings');


        /** General */
        $container->add_tab(
            __('General', 'starter-kit'), [
                Field::make('separator', $prefix . 'sep_general_identity', __('Identity', 'starter-kit')),
                Field::make('image', $prefix . 'favicon_image', __('Favicon Image', 'starter-kit')),
            ]
        );

        /** Analytics */
        $container->add_tab(
            __('Analytics', 'starter-kit'), [
                Field::make('separator', $prefix . 'sep_analytics_google', __('Google', 'starter-kit')),

                Field::make('text', $prefix . 'tag_manager_code', __('Tag Manager Code', 'starter-kit'))->set_attribute('placeholder', 'GTM-XXXXXXX')->set_width(50),

                Field::make('text', $prefix . 'analytics_code', __('Analytics Code', 'starter-kit'))->set_attribute('placeholder', 'UA-XXXXXXXXX-X')->set_help_text(
                    __(
                        'For a better speed performance, please insert the analytics code through the tag manager. Turn on google Analytics Scripts Local Load option',
                        'starter-kit'
                    )
                )->set_width(50),
            ]
        );
    }

    /**
     * Use Carbon Fields to update favicon
     *
     * @return void
     */
    public static function updateFaviconFromThemeOptions(): void
    {
        $faviconImageId = Utils::getOption('favicon_image');
        update_option('site_icon', $faviconImageId);
        wp_cache_flush();
    }

}
