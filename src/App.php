<?php

namespace StarterKit;

defined('ABSPATH') || exit;

use StarterKit\Base\Hooks;
use StarterKit\Handlers\CLI\CLI;
use StarterKit\Error\ErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Application main class
 *
 * @package    Starter Kit
 */
final class App extends AbstractSingleton
{
    /** @var ContainerInterface|null  Dependency Injection Container */
    private ?ContainerInterface $container = null;


    /**
     * Run the Application
     *
     * @param ContainerInterface $container Dependency Injection Container
     *
     * @throws Throwable
     */
    public function run(ContainerInterface $container): void
    {
        if (isset($this->container)) {
            return;
        }

        $this->container = $container;

        ErrorHandler::register($container->get(LoggerInterface::class));

        // Main Hooks functionality
        Hooks::initHooks();

        // WP_CLI functionality
        CLI::addCommands();
    }


    public static function container(): ContainerInterface
    {
        return self::instance()->container;
    }
}
