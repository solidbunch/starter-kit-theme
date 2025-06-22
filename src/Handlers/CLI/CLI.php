<?php

namespace StarterKit\Handlers\CLI;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;
use StarterKit\Error\ErrorHandler;
use Throwable;
use WP_CLI;

/**
 * Container for custom WP-CLI commands
 *
 * @package    Starter Kit
 */
class CLI
{
    /**
     * Adds WP_CLI commands
     *
     * @return void
     * @throws Throwable
     */
    public static function addCommands(): void
    {
        if (!Utils::isDoingWPCLI()) {
            return;
        }

        try {
            WP_CLI::add_command('clone-theme', [Commands\CloneTheme::class, 'run']);
        } catch (Throwable $throwable) {
            ErrorHandler::handleThrowable($throwable);
        }
    }
}
