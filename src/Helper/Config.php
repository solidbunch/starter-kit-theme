<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;

use StarterKit\App;
use StarterKit\Helper\NotFoundException;


/**
 * Theme configuration helper
 *
 * @throws NotFoundException No entry found for the given name.
 * @package Starter Kit
 *
 */
class Config
{
    /**
     * Get config value by key
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        $parts = explode('/', $key);

        $config = App::container()->get('config');

        if (! isset($config[$parts[0]])) {
            throw new NotFoundException("No entry found for '$key'");
        }

        $value = $config[array_shift($parts)];

        foreach ($parts as $part) {
            if (is_array($value) && isset($value[$part])) {
                $value = $value[$part];
            } else {
                throw new NotFoundException("No entry found for '$key'");
            }
        }

        return $value;
    }
}
