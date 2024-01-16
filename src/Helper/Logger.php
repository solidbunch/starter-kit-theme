<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;

use StarterKit\App;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;


/**
 * Theme logging helper
 *
 * @package    Starter Kit
 */
class Logger
{
    /**
     * @var LoggerInterface
     */
    private static $logger = null;

    public static function instance(): LoggerInterface
    {
        if (! static::$logger instanceof LoggerInterface) {
            static::$logger = App::container()->get(LoggerInterface::class);
        }

        return static::$logger;
    }


    /**
     * Logs with an arbitrary level.
     *
     * @param string|\Stringable $message
     * @param mixed              $level Ex: \Psr\Log\LogLevel::DEBUG
     * @param mixed[]            $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public static function log(string|\Stringable $message, string $level = LogLevel::INFO, array $context = []): void
    {
        static::instance()->log($level, $message, $context);
    }

    /**
     * System is unusable.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function emergency(string|\Stringable $message, array $context = []): void
    {
        static::instance()->emergency($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function alert(string|\Stringable $message, array $context = []): void
    {
        static::instance()->alert($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function critical(string|\Stringable $message, array $context = []): void
    {
        static::instance()->critical($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function error(string|\Stringable $message, array $context = []): void
    {
        static::instance()->error($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function warning(string|\Stringable $message, array $context = []): void
    {
        static::instance()->warning($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function notice(string|\Stringable $message, array $context = []): void
    {
        static::instance()->notice($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function info(string|\Stringable $message, array $context = []): void
    {
        static::instance()->info($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string|\Stringable $message
     * @param mixed[]            $context
     *
     * @return void
     */
    public static function debug(string|\Stringable $message, array $context = []): void
    {
        static::instance()->debug($message, $context);
    }
}
