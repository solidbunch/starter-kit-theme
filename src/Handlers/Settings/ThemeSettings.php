<?php

namespace StarterKit\Handlers\Settings;

defined('ABSPATH') || exit;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKit\Helper\Utils;
use WPRI\ImgUtils;

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
     * @throws NotFoundException
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
        $container->set_page_menu_title('Theme Settings');


        /** General */
        $container->add_tab(
            __('General', 'starter-kit'),
            [
                Field::make('separator', $prefix . 'sep_general_identity', __('Identity', 'starter-kit')),
                Field::make('image', $prefix . 'favicon_image', __('Favicon Image', 'starter-kit')),
            ]
        );

        /** Analytics */
        $container->add_tab(
            __('Analytics', 'starter-kit'),
            [
                Field::make('separator', $prefix . 'sep_analytics_google', __('Google', 'starter-kit')),

                Field::make('text', $prefix . 'tag_manager_code', __('Tag Manager Code', 'starter-kit'))
                     ->set_attribute('placeholder', 'GTM-XXXXXXX')
                     ->set_width(50),

                Field::make('text', $prefix . 'analytics_code', __('Analytics Code', 'starter-kit'))
                     ->set_attribute('placeholder', 'UA-XXXXXXXXX-X')
                     ->set_help_text(
                         __(
                             "For a better speed performance, " .
                             "please insert the analytics code through the tag manager." .
                             "Turn on google Analytics Scripts Local Load option",
                             'starter-kit'
                         )
                     )
                     ->set_width(50),
            ]
        );

        /** Security */
        $container->add_tab(
            __('Security', 'starter-kit'),
            [
                Field::make('separator', $prefix . 'sep_security_antispam', __('Antispam', 'starter-kit')),

                Field::make('checkbox', $prefix . 'forms_antispam', __('Antispam', 'starter-kit'))
                     ->set_option_value('1')
                     ->set_default_value('')
                     ->set_help_text(__('Antispam for all Email Forms', 'starter-kit')),
            ]
        );

        /** Performance */
        $container->add_tab(
            __('Performance', 'starter-kit'),
            [
                Field::make('separator', 'sep_image_sizes', __('Image sizes', 'starter-kit')),
                Field::make('set', $prefix . 'disable_img_sizes', __('Check image sizes to disable', 'starter-kit'))
                     ->set_options($imageSizes = ImgUtils::getAllInitedImageSizesFormatted())
                     ->set_default_value(
                         array_filter(
                             array_keys($imageSizes),
                             // @codingStandardsIgnoreLine
                             function ($value) { return !in_array($value, ['thumbnail', 'medium'], true); }
                         )
                     )
                    ->set_width(50),

                Field::make(
                    'text',
                    $prefix . 'big_image_size_threshold',
                    __('"BIG image" threshold value, px', 'starter-kit')
                )
                     ->set_default_value(Config::get('media/bigImageSizeThreshold'))
                     ->set_help_text(
                         __(
                             "When a new image is uploaded, if its original width or height exceeds the threshold, " .
                             "it will be scaled down. This threshold acts as the maximum width and height limit. " .
                             "The downscaled image will then serve as the largest size available, affecting the " .
                             "_wp_attached_file post meta value as well." .
                             "<br><br>" .
                             "For instance, the default threshold in WordPress is set to 2560 pixels. Considering " .
                             "display resolutions, 4096 pixels are typical for 4K monitors, while 5120 pixels " .
                             "provide enhanced clarity on 5K monitors.",
                             'starter-kit'
                         )
                     )
                     ->set_width(50),
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
