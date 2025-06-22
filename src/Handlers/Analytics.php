<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;

/**
 * Google Analytics
 *
 * Operate all Analytics functions (GTM, GA etc)
 *
 * @package    Starter Kit
 */
class Analytics
{
    /**
     * Gets Google Tag Manager Code. Depends on options and environment.
     *
     * @return string
     */
    private static function getGTMCode(): string
    {
        if (Utils::isProdEnvironment()) {
            return (string)Utils::getOption('gtm_code', '');
        } else {
            $gtm_dev_ext = Utils::getOption('gtm_dev_ext', '');
            if ($gtm_dev_ext) {
                return (string)Utils::getOption('gtm_code', '');
            }
        }

        return '';
    }


    /**
     * Gets Google Tag Manager URL Extension for Non-Production Environment.
     *
     * @return string
     */
    private static function getGTMDevExt(): string
    {
        if (Utils::isProdEnvironment()) {
            return '';
        }

        return (string)Utils::getOption('gtm_dev_ext', '');
    }


    /**
     * Adds Google Tag Manager(GTM) code to html <head>
     *
     * @return void
     */
    public static function addGTMHead(): void
    {
        $gtm_code    = static::getGTMCode();
        $gtm_dev_ext = static::getGTMDevExt();

        if (empty($gtm_code)) {
            return;
        }
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl + <?php
                echo wp_json_encode($gtm_dev_ext); ?>;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', <?php echo wp_json_encode($gtm_code); ?>);
        </script>
        <!-- End Google Tag Manager -->
        <?php
    }


    /**
     * Adds Google Tag Manager(GTM) code after open <body> tag
     *
     * @return void
     */
    public static function addGTMBody(): void
    {
        $gtm_code    = static::getGTMCode();
        $gtm_dev_ext = static::getGTMDevExt();

        if (empty($gtm_code)) {
            return;
        }
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="<?php
            echo esc_url('https://www.googletagmanager.com/ns.html?id=' . $gtm_code . $gtm_dev_ext); ?>"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }


    /**
     * Adds Google Analytics code to head
     *
     * @return void
     */
    public static function addAnalyticsHead(): void
    {
        $analytics_code = Utils::getOption('ga_code', '');

        if (empty($analytics_code) || !Utils::isProdEnvironment()) {
            return;
        }
        ?>
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="<?php
        echo esc_url('https://www.googletagmanager.com/gtag/js?id=' . $analytics_code); ?>">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {dataLayer.push(arguments);}

            gtag('js', new Date());
            gtag('config', <?php echo wp_json_encode($analytics_code); ?>);
        </script>
        <!-- End Google Analytics -->
        <?php
    }


    /**
     * Adds Google site verification
     *
     * @return void
     **/
    public static function addGoogleSiteVerification(): void
    {
        $gsv_code = Utils::getOption('gsv_code', '');

        if (empty($gsv_code) || !Utils::isProdEnvironment()) {
            return;
        }
        ?>
        <meta name="google-site-verification" content="<?php echo esc_attr($gsv_code); ?>">
        <?php
    }
}
