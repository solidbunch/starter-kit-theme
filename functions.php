<?php

defined('ABSPATH') || exit;

use StarterKit\StarterKit;

/**
 * StarterKit Theme bootstrap file
 *
 * @package    Starter Kit
 */

if (PHP_VERSION_ID < 80100) {
    $theme              = wp_get_theme();
    $requiredPhpVersion = $theme->get('RequiresPHP');

    error_log(sprintf(__('Theme requires at least PHP %s (You are using PHP %s) '), $requiredPhpVersion, PHP_VERSION));
    if (!is_admin()) {
        wp_die(__('Theme requires a higher PHP Version. Please check the Logs for more details.'));
    }
} else {
    try {
        require_once __DIR__ . '/vendor/autoload.php';

        $StarterKit = new StarterKit();

        $StarterKit->run();
    } catch (Throwable $throwable) {
        $error_message = 'PHP error: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine();
        $error_message .= PHP_EOL . 'Stack trace:';
        $error_message .= PHP_EOL . $throwable->getTraceAsString();

        error_log($error_message);
    }
}
