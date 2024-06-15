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
            $blockClass = 'StarterKitBlocks\\' . $blockName . '\\BlockRenderer';

            // Instantiate the block renderer class
            try {
                new $blockClass($blockName);
            } catch (Throwable $throwable) {
                ErrorHandler::handleThrowable($throwable);
            }


            //self::registerBlockTypeFromMetadata();

            //self::registerBlocksRestApiEndpoints($blockNamespace);

            //self::registerBlockOnInitFunction($blockNamespace);

            //self::registerBlockAssets($blockNamespace, $blockName);
        }
    }

    /**
     * Register block type from block.json metadata file
     * And register callback from block folder controller php file if exists
     *
     * @param string $blockMetaPath
     * @param string $blockNamespace
     *
     * @return void
     */
    private static function registerBlockTypeFromMetadata(string $blockMetaPath, string $blockNamespace): void
    {
        $blockTypeArgs = [];

        if (method_exists($blockNamespace, 'blockServerSideCallback')) {
            $blockTypeArgs['render_callback'] = function ($attributes, $content, $block) use ($blockNamespace) {
                return call_user_func(
                    [
                        $blockNamespace,
                        'blockServerSideCallback',
                    ],
                    $attributes,
                    $content,
                    $block
                );
            };
        }

        register_block_type_from_metadata($blockMetaPath, $blockTypeArgs);
    }

    /**
     * If we are calling registerBlocks() function on init hook,
     * we can call blockOnInit() function from block folder controller php file if exists
     *
     * @param string $blockNamespace
     *
     * @return void
     */
    private static function registerBlockOnInitFunction(string $blockNamespace): void
    {
        if (!method_exists($blockNamespace, 'blockOnInitFunction')) {
            return;
        }

        call_user_func(
            [
                $blockNamespace,
                'blockOnInit',
            ]
        );
    }

    /**
     * Register rest api callback from block folder controller php file if exists
     *
     * @param string $blockNamespace
     *
     * @return void
     */
    private static function registerBlocksRestApiEndpoints(string $blockNamespace): void
    {
        if (!method_exists($blockNamespace, 'blockRestApiEndpoints')) {
            return;
        }

        add_action('rest_api_init', function () use ($blockNamespace) {
            call_user_func(
                [
                    $blockNamespace,
                    'blockRestApiEndpoints',
                ]
            );
        });
    }


    /**
     *
     *
     * @param string $blockNamespace
     * @param string $blockName
     *
     * @return void
     */
    private static function registerBlockAssets(string $blockNamespace, string $blockName): void
    {
        if (!method_exists($blockNamespace, 'blockAssets')) {
            return;
        }

        call_user_func(
            [
                $blockNamespace,
                'blockAssets',
            ],
            $blockName
        );
    }
}
