<?php

namespace StarterKit\Handlers\Errors;

defined('ABSPATH') || exit;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Util\Misc;
use Whoops\Run;
use StarterKit\Helper\Logger;

class ErrorHandler
{
    /**
     * @throws \Throwable
     */
    public static function handleThrowable(\Throwable $throwable): void
    {
        $error_message = 'PHP error: ' .
                         $throwable->getMessage() .
                         ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine();

        $error_message .= PHP_EOL . 'Stack trace:';
        $error_message .= PHP_EOL . $throwable->getTraceAsString();

        error_log($error_message);

        if (static::hideErrors()) {
            return;
        }

        throw $throwable;
    }


    /**
     * Register Whoops conditionally on debug configuration
     */
    public static function register(LoggerInterface $logger)
    {
        if (static::hideErrors()) {
            return;
        }

        $whoops = new Run();

        $whoops->pushHandler(static::getPrettyHandler());
        $whoops->pushHandler(static::getAjaxHandler());
        $whoops->pushHandler(static::getRestApiHandler());

        if (Misc::isCommandLine()) {
            $whoops->pushHandler(static::getPlainTextHandler());
        }

        $whoops->pushHandler(function ($exception, $inspector, $run) use ($logger) {
            $logger->error($exception);
        });

        $whoops->register();

        ob_start(); // Don`t display WP markup before whoops.
    }


    private static function hideErrors(): bool
    {
        return ! static::isDebug() || ! static::isDebugDisplay() || static::isProdEnvironment();
    }


    private static function isDebug(): bool
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }


    private static function isDebugDisplay(): bool
    {
        return defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY;
    }


    private static function isProdEnvironment(): bool
    {
        return 'production' === wp_get_environment_type();
    }


    private static function getTables(): array
    {
        $tables = [
            '$wp'       => function () {
                global $wp;

                if (! $wp instanceof \WP) {
                    return [];
                }

                $output = get_object_vars($wp);
                unset($output['private_query_vars']);
                unset($output['public_query_vars']);

                return array_filter($output);
            },
            '$wp_query' => function () {
                global $wp_query;

                if (! $wp_query instanceof \WP_Query) {
                    return [];
                }

                $output = get_object_vars($wp_query);
                $output['query_vars'] = array_filter($output['query_vars']);
                unset($output['posts']);
                unset($output['post']);

                return array_filter($output);
            },
            '$post'     => function () {
                $post = get_post();

                if (! $post instanceof \WP_Post) {
                    return [];
                }

                return get_object_vars($post);
            },
        ];

        return $tables;
    }


    private static function getPrettyHandler(): \Whoops\Handler\HandlerInterface
    {
        $handler = new PrettyPageHandler();

        foreach (static::getTables() as $name => $callback) {
            $handler->addDataTableCallback($name, $callback);
        }

        // Requires Remote Call plugin.
        $handler->addEditor('phpstorm-remote-call', 'http://localhost:8091?message=%file:%line');

        return $handler;
    }


    private static function getAjaxHandler(): \Whoops\Handler\HandlerInterface
    {
        $handler = new AjaxHandler();
        $handler->addTraceToOutput(true);

        return $handler;
    }


    private static function getRestApiHandler(): \Whoops\Handler\HandlerInterface
    {
        $handler = new RestApiHandler();
        $handler->addTraceToOutput(true);

        return $handler;
    }


    private static function getPlainTextHandler(): \Whoops\Handler\HandlerInterface
    {
        return new PlainTextHandler();
    }
}
