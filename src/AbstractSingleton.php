<?php

namespace StarterKit;

/**
 *Abstract Class for creating Singleton Classes
 */
abstract class AbstractSingleton
{
    /**
     * Array of instances of singleton classes
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * Call this method to get singleton
     */
    public static function instance(): static
    {
        $class = static::class;

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
     * Make constructor protected, so nobody can call "new Class".
     */
    protected function __construct()
    {
    }

    /**
     * Make clone magic method protected, so nobody can clone instance.
     */
    protected function __clone()
    {
    }
}
