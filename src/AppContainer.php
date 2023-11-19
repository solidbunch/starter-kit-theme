<?php

namespace StarterKit;

defined('ABSPATH') || exit;

use StarterKit\Base\Hooks;
use StarterKit\Handlers\CLI\CLI;

/**
 * Application main class
 *
 * @package    Starter Kit
 */
final class AppContainer
{

    public function __construct()
    {
    }

    /**
     * Run the Application
     */
    public function run(): void
    {
        // Main Hooks functionality
        Hooks::initHooks();

        // WP_CLI functionality
        CLI::addCommands();
    }

}
