<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Errors\ErrorHandler;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKitBlocks;
use Throwable;

/**
 * Register blocks functionality
 *
 * @package    Starter Kit
 */
class Register
{
    /**
     * Add Gutenberg block category
     *
     * @param array $categories
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     *
     * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
     */
    public static function registerBlocksCategories(array $categories): array
    {
        return array_merge(
            [
                [
                    'slug'  => Config::get('blocksCategorySlug'),
                    'title' => Config::get('blocksCategoryTitle'),
                ],
            ],
            $categories
        );
    }

    /**
     * Register all blocks in blocks directory
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public static function registerBlocks(): void
    {
        if (!function_exists('register_block_type_from_metadata')) {
            return;
        }

        $blocks = glob(Config::get('blocksDir') . '*', GLOB_ONLYDIR);

        foreach ($blocks as $blockPath) {
            $blockName = basename($blockPath);

            // Exclude blocks with name starting with underscore or without block.json file
            if (str_starts_with($blockName, '_') || !file_exists($blockPath . '/block.json')) {
                continue;
            }

            // Assuming each block has a BlockRenderer class in the appropriate namespace
            $Block = 'StarterKitBlocks\\' . $blockName . '\\Block';

            if (!class_exists($Block)) {
                continue;
            }

            // Instantiate the block class
            try {
                new $Block($blockName);
            } catch (Throwable $throwable) {
                ErrorHandler::handleThrowable($throwable);
            }
        }
    }
}
