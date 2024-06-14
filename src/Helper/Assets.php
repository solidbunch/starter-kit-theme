<?php

namespace StarterKit\Helper;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

defined('ABSPATH') || exit;

/**
 * Assets
 *
 * Helper functions
 *
 * @package    Starter Kit
 */
class Assets
{
    /**
     * Register theme script from /assets folder
     * Autogenerate handle with name '<filename>-script' if not provided
     *
     * @param string  $relativePath Relative path to the file
     * @param array   $deps         Dependencies
     * @param string  $handle       Name of the script
     * @param boolean $inFooter     connect to footer
     *
     * @return void
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     */
    public static function registerThemeScript(
        string $relativePath,
        array $deps = [],
        string $handle = '',
        bool $inFooter = true
    ): void {
        wp_register_script(
            $handle ?: basename($relativePath, '.js') . '-script',
            Config::get('assetsUri') . $relativePath,
            $deps,
            filemtime(Config::get('assetsDir') . $relativePath),
            $inFooter
        );
    }

    /**
     * Register theme style from /assets folder
     * * Autogenerate handle with name '<filename>-style' if not provided
     *
     * @param string $relativePath Relative path to the file
     * @param array  $deps         Dependencies
     * @param string $handle       Name of the style
     * @param string $media
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public static function registerThemeStyle(
        string $relativePath,
        array $deps = [],
        string $handle = '',
        string $media = 'all'
    ): void {
        wp_register_style(
            $handle ?: basename($relativePath, '.css') . '-style',
            Config::get('assetsUri') . $relativePath,
            $deps,
            filemtime(Config::get('assetsDir') . $relativePath),
            $media
        );
    }

    /**
     * Register block script from blocks folder
     * Autogenerate handle with name 'block-<BlockName>-script' if not provided
     *
     * @param string  $blockName Name of the block folder
     * @param string  $fileName  File name of the script in build folder
     * @param array   $deps      Dependencies
     * @param string  $handle    Name of the script
     * @param boolean $inFooter  connect to footer
     *
     * @return void
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     */
    public static function registerBlockScript(
        string $blockName,
        string $fileName,
        array $deps = [],
        string $handle = '',
        bool $inFooter = true
    ): void {
        wp_register_script(
            $handle ?: 'block-' . Utils::camelToKebab($blockName) . '-' . basename($fileName, '.js') . '-script',
            Config::get('blocksUri') . $blockName . '/build/' . $fileName,
            $deps,
            filemtime(Config::get('blocksDir') . $blockName . '/build/' . $fileName),
            $inFooter
        );
    }

    /**
     * Register bloc style from blocks folder
     * * Autogenerate handle with name 'block-<BlockName>-style' if not provided
     *
     * @param string $blockName Name of the block folder
     * @param string $fileName  File name of the style in build folder
     * @param array  $deps      Dependencies
     * @param string $handle    Name of the style
     * @param string $media
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public static function registerBlockStyle(
        string $blockName,
        string $fileName,
        array $deps = [],
        string $handle = '',
        string $media = 'all'
    ): void {
        wp_register_style(
            $handle ?: 'block-' . Utils::camelToKebab($blockName) . '-' . basename($fileName, '.css') . '-style',
            Config::get('blocksUri') . $blockName . '/build/' . $fileName,
            $deps,
            filemtime(Config::get('blocksDir') . $blockName . '/build/' . $fileName),
            $media
        );
    }
}
