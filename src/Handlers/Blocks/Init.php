<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

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
class Init
{
    /**
     * Add Gutenberg block category
     *
     * @param array $categories
     *
     * @return array
     *
     * @throws NotFoundException
     *
     * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
     */
    public static function loadBlocksCategories(array $categories): array
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
     * @throws NotFoundException
     * @throws Throwable
     */
    public static function loadBlocks(): void
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

            // Instantiate the block class
            try {
                new $Block($blockName);
            } catch (Throwable $throwable) {
                ErrorHandler::handleThrowable($throwable);
            }
        }
    }

    public static function addSpacerAttributeToBlocks($args): array
    {
        $args['attributes']['spacers'] = [
            'type' => 'object',
            'default' => [
                'xs' => [],
                'sm' => [],
                'md' => [],
                'lg' => [],
                'xl' => [],
                'xxl' => [],
            ],
        ];

        return $args;
    }
}
