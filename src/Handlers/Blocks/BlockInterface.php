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
     * @param array  $attributes
     * @param string $content
     * @param object $block
     *
     * @return string
     */
    public static function blockServerSideCallback(array $attributes, string $content, object $block): string;
}
