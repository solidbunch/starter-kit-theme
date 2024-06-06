<?php

namespace StarterKit\Handlers\CLI\Commands;

defined('ABSPATH') || exit;

/**
 * Interface for CLI commands
 *
 * @package    Starter Kit
 */
interface CLICommandInterface
{
    /**
     * CLI command run function
     * @return void
     */
    public static function run(): void;
}
