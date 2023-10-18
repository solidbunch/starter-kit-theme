<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

/**
 * Blocks interface for blocks controllers
 *
 * @package    Starter Kit
 */
interface BlockInterface
{
    /**
     * Block server side endpoint
     *
     * @param $attributes
     * @param $content
     * @param $block
     *
     * @return string
     */
    public static function blockServerSideCallback($attributes, $content, $block): string;

}
