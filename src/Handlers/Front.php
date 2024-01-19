<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use Exception;
use PHPMailer;
use StarterKit\Helper\Config;
use StarterKit\Helper\Utils;

/**
 * Front End handler
 *
 * @package    Starter Kit
 */
class Front
{
    /**
     * Load critical assets before blocks assets
     *
     * @return void
     */
    public static function enqueueCriticalAssets(): void
    {
        $style = Config::get('assetsUri') . 'build/styles/theme.css';

        $styleUri  = get_template_directory_uri() . $style;
        $stylePath = get_template_directory() . $style;

        wp_enqueue_style('theme-main-style', $styleUri, [], filemtime($stylePath));
    }

    /**
     * Load regular theme assets after blocks assets
     *
     * @return void
     */
    public static function enqueueThemeAssets(): void
    {
        $bootstrapBundle = Config::get('assetsUri') . 'libs/bootstrap/bootstrap.bundle.min.js';

        $bootstrapBundleUri  = get_template_directory_uri() . $bootstrapBundle;
        $bootstrapBundlePath = get_template_directory() . $bootstrapBundle;

       // wp_enqueue_script('bootstrap-bundle', $bootstrapBundleUri, [], filemtime($bootstrapBundlePath), true);
    }

    /**
     * Load additional JS data variables
     *
     * @return void
     */
    public static function loadFrontendJsData(): void
    {
        wp_register_script('front-vars', '', [], '', true);
        wp_enqueue_script('front-vars');
        $frontendData = [
            'restApiUrl'    => get_rest_url(),
            'restNamespace' => Config::get('restApiNamespace'),
            'restNonce'     => wp_create_nonce('theme_rest_nonce'),
        ];

        wp_localize_script('front-vars', 'frontendData', $frontendData);
    }

    /**
     * Completely disable browser HTML cache
     *
     * @return void
     */
    public static function addNoCacheHeaders(): void
    {
        if (Config::get('optimization/addNoCacheHeaders') === true) {
            nocache_headers();
        }
    }

    /**
     * Adding ver=<file-time> to styles src for refresh user side cache
     *
     * @param $src
     * @param $handle
     *
     * @return string
     */
    public static function addFileTimeVerToStyles($src, $handle): string
    {
        $registered_styles = wp_styles()->registered;

        $style = $registered_styles[$handle] ?? '';

        if (
            empty($style) || !empty($style->ver) ||
            empty($style->extra['path']) || !file_exists($style->extra['path'])
        ) {
            return $src;
        }

        return add_query_arg('ver', filemtime($style->extra['path']), $src);
    }

    /**
     * Load Google Tag Manager code
     *
     * @return void
     */
    public static function addGTMHead(): void
    {
        $tag_manager_code = Utils::getOption('tag_manager_code', '');

        if (empty($tag_manager_code)) {
            return;
        }

        ?>
        <script>(function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '<?php echo $tag_manager_code; ?>');
        </script>
        <?php
    }

    public static function addGTMBody(): void
    {
        $tag_manager_code = Utils::getOption('tag_manager_code', '');

        if (empty($tag_manager_code)) {
            return;
        }

        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php
            echo $tag_manager_code; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }

    /**
     * add Google Analytics code to head
     *
     * @return void
     */
    public static function addAnalyticsHead(): void
    {
        $analytics_code = Utils::getOption('analytics_code', '');

        if (!empty($analytics_code)) {
            View::load('/template-parts/analytics/analytics', ['analytics_code' => $analytics_code]);
        }
    }

    /**
     * Change excerpt More text
     *
     * @param $more
     *
     * @return string
     */
    public static function changeExcerptMore($more): string
    {
        return '…';
    }

    /**
     * @param  PHPMailer  $phpmailer
     *
     * @return null|PHPMailer
     * @throws Exception
     */
    public static function antispamForm(PHPMailer $phpmailer): null|PHPMailer
    {
        if (self::antispam_enabled() !== 1) {
            return null;
        }

        $date_utc = new \DateTime("now", new \DateTimeZone("UTC"));

        $code = ($date_utc->format('H') + 1) * $date_utc->format('d') * $date_utc->format('m') * $date_utc->format('Y');

        if (!empty($_POST) && !empty($_POST['as_code']) && $_POST['as_code'] == $code) {
            return null;
        }

        $phpmailer->clearAllRecipients();

        return $phpmailer;
    }
}
