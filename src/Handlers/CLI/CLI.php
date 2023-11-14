<?php

namespace StarterKit\Handlers\CLI;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;
use Throwable;
use WP_CLI;

class CLI
{

    /**
     * Adds WP_CLI commands
     *
     * @return void
     */
    public static function addCommands(): void
    {
        if (!Utils::isDoingWPCLI()) {
            return;
        }

        try {
            WP_CLI::add_command('clone-theme', [Commands\CloneTheme::class, 'run']);
        } catch (Throwable $throwable) {
            Utils::errorHandler($throwable);
        }
    }


}
