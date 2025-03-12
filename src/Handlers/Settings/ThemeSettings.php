<?php

namespace StarterKit\Handlers\Settings;

defined('ABSPATH') || exit;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Exception\ConfigEntryNotFoundException;
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
     *
     * @throws ConfigEntryNotFoundException
     */
    public static function make(): void
    {
        $prefix = SK_PREFIX;

        $container = Container::make(
            'theme_options',  // type
            'theme_settings', // id
            __('Site Settings', 'starter-kit') // desc
        );

        $container->set_page_parent('options-general.php'); // id of the "Settings" admin section
        $container->set_page_menu_title(__('Theme Settings'));


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

                Field::make('text', $prefix . 'gtm_code', __('Tag Manager Code (GTM)', 'starter-kit'))
                     ->set_attribute('placeholder', 'GTM-XXXXXXX')
                     ->set_width(50),

                Field::make(
                    'text',
                    $prefix . 'gtm_dev_ext',
                    __('GTM URL Extension for Non-Production Environment', 'starter-kit')
                )
                     ->set_attribute('placeholder', '&gtm_auth=xxx&gtm_preview=env-xx&gtm_cookies_win=x,')
                     ->set_help_text(
                         sprintf(
                             'Works only on <b>Non-Production </b> Environment. Now is <b>%s</b>',
                             wp_get_environment_type()
                         )
                     )
                     ->set_width(50),

                Field::make('text', $prefix . 'ga_code', __('Google Analytics Code', 'starter-kit'))
                     ->set_attribute('placeholder', 'G-XXXXXXXXXX')
                     ->set_help_text(
                         'For a better speed performance, please insert the analytics code through the ' .
                         '<b>tag manager</b>. ' .
                         sprintf(
                             'Works only on <b>production</b> environment. Now is <b>%s</b>',
                             wp_get_environment_type()
                         )
                     )
                     ->set_width(100),

                Field::make('text', $prefix . 'gsv_code', __('Google site verification Code', 'starter-kit'))
                     ->set_attribute('placeholder', '')
                     ->set_help_text(
                         sprintf(
                             'Works only on <b>production</b> environment. Now is <b>%s</b>',
                             wp_get_environment_type()
                         )
                     )
                     ->set_width(100),
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
