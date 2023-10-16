<?php

namespace StarterKit;

defined('ABSPATH') || exit;

use StarterKit\Base\Hooks;

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
    }

}
