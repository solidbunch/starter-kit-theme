<?php

namespace StarterKit\Helper;

defined('ABSPATH') || exit;

use StarterKit\App;
use StarterKit\Exception\ConfigEntryNotFoundException;

/**
 * Theme configuration helper
 *
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
     *
     * @throws ConfigEntryNotFoundException
     */
    public static function get(string $key): mixed
    {
        $parts = explode('/', $key);

        $config = App::container()->get('config');

        if (! isset($config[$parts[0]])) {
            throw new ConfigEntryNotFoundException("No entry found for '$key'");
        }

        $value = $config[array_shift($parts)];

        foreach ($parts as $part) {
            if (is_array($value) && isset($value[$part])) {
                $value = $value[$part];
            } else {
                throw new ConfigEntryNotFoundException("No entry found for '$key'");
            }
        }

        return $value;
    }
}
