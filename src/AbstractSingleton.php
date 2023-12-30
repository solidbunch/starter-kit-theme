<?php
/**
 * Abstract Class for creating Singleton Classes
 *
 */

namespace StarterKit;

/**
 * Class AbstractSingleton
 *
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
     * Make constructor private, so nobody can call "new Class".
     */
    protected function __construct() { }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    protected function __clone() { }

}
