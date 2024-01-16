<?php

namespace StarterKit;

/**
 *Abstract Class for creating Singleton Classes
 */
abstract class AbstractSingleton
{
    /**
     * Call this method to get singleton
     */
    public static function instance()
    {
        static $instance = false;
        if ($instance === false) {
            $instance = new static();
        }

        return $instance;
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
