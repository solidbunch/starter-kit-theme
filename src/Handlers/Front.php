<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use Exception;
use PHPMailer;
use StarterKit\Helper\Assets;
use StarterKit\Helper\Config;
use StarterKit\Exception\ConfigEntryNotFoundException;
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
     *
     * @throws ConfigEntryNotFoundException
     */
    public static function enqueueCriticalAssets(): void
    {
        $style = 'build/styles/theme.css';

        $styleUri  = Config::get('assetsUri') . $style;
        $stylePath = Config::get('assetsDir') . $style;

        wp_enqueue_style('theme-main-style', $styleUri, [], filemtime($stylePath));

        $style = 'build/fonts/icons/icons.font.css';

        $styleUri = Config::get('assetsUri') . $style;
        $stylePath = Config::get('assetsDir') . $style;

        wp_enqueue_style('icons-font-style', $styleUri, [], filemtime($stylePath));
    }

    /**
     * To make critical common styles load before blocks assets
     * It's because Gutenberg blocks assets loads not on 'enqueue_block_assets' hook but on render_block() function
     *
     * https://github.com/WordPress/gutenberg/discussions/39023
     *
     * @param $dependencies
     * @param $blockName
     * @param $type
     *
     * @return array
     */
    public static function addThemeStyleDependencyToBlocks($dependencies, $blockName, $type): array
    {
        if ($type !== 'style' && $type !== 'view_style') {
            return $dependencies;
        }

        $dependencies[] = 'theme-main-style';

        return $dependencies;
    }

    /**
     * Load Bootstrap modules
     *
     * @return void
     *
     * @throws ConfigEntryNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function enqueueBootstrap(): void
    {
        Assets::registerThemeScript('build/js/bootstrap/alert.js');
        Assets::registerThemeScript('build/js/bootstrap/collapse.js');
        Assets::registerThemeScript('build/js/bootstrap/dropdown.js');
        Assets::registerThemeScript('build/js/bootstrap/offcanvas.js');
    }

    /**
     * Load regular theme assets after blocks assets
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws ConfigEntryNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public static function enqueueThemeAssets(): void
    {
    }

    /**
     * Load additional JS data variables
     *
     * @return void
     *
     * @throws ConfigEntryNotFoundException
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
     *
     * @throws ConfigEntryNotFoundException
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

        $ver = filemtime($style->extra['path']);

        return add_query_arg('ver', $ver, $src);
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
     * @param PHPMailer $phpmailer
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
