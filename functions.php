<?php

defined('ABSPATH') || exit;

use StarterKit\App;
use StarterKit\Handlers\Errors\ErrorHandler;
use Psr\Container\ContainerInterface;

/**
 * Theme bootstrap file
 *
 * @package    Starter Kit
 */

if (PHP_VERSION_ID < 80100) {
    $activeTheme        = wp_get_theme();
    $requiredPhpVersion = $activeTheme->get('RequiresPHP');

    error_log(sprintf(__('Theme requires at least PHP %s (You are using PHP %s) '), $requiredPhpVersion, PHP_VERSION));
    if (!is_admin()) {
        wp_die(__('Theme requires a higher PHP Version. Please check the Logs for more details.'));
    }
} else {
    try {
        // helper debug functions for developers
        require_once __DIR__ . '/src/dev.php';
        // psr-4 autoload
        require_once __DIR__ . '/vendor/autoload.php';

        /** @var ContainerInterface $container */
        $container = apply_filters('starter_kit/container', require __DIR__ . '/config/container.php');

        App::instance()->run($container);
    } catch (Throwable $throwable) {
        try {
            ErrorHandler::handleThrowable($throwable);
        } catch (Throwable $e) {
            error_log($e);
        }
    }
}
