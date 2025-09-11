<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use StarterKit\Error\ErrorHandler;
use StarterKit\Exception\ConfigEntryNotFoundException;
use StarterKit\Helper\Config;
use StarterKit\Helper\Logger;
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
     * @throws ConfigEntryNotFoundException
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
     * @param string $blocksDir Custom blocks directory path
     * @param string $namespace Custom namespace for blocks
     * @param string $blocksUri Custom blocks URI path
     *
     * @return void
     *
     * @throws Throwable
     */
    public static function loadBlocks(string $blocksDir = '', string $namespace = '', string $blocksUri = ''): void
    {
        if (!function_exists('register_block_type_from_metadata')) {
            return;
        }

        // Use provided directory or default theme blocks directory
        $blocksDir = !empty($blocksDir) ? $blocksDir : SK_BLOCKS_DIR;
        $namespace = !empty($namespace) ? $namespace : SK_BLOCKS_NS;
        $blocksUri = !empty($blocksUri) ? $blocksUri : SK_BLOCKS_URI;

        if (!is_dir($blocksDir) || empty($namespace) || empty($blocksUri)) {
            Logger::error('Blocks configuration is invalid', [
                'blocksDir'        => $blocksDir,
                'namespace'        => $namespace,
                'blocksUri'        => $blocksUri,
                'isDir'            => is_dir($blocksDir),
                'isEmptyNamespace' => empty($namespace),
                'isEmptyUri'       => empty($blocksUri),
            ]);

            return;
        }

        $blocks = glob($blocksDir . '*', GLOB_ONLYDIR);

        foreach ($blocks as $blockPath) {
            $blockName = basename($blockPath);

            // Exclude blocks with name starting with underscore or without block.json file
            if (str_starts_with($blockName, '_') || !file_exists($blockPath . '/block.json')) {
                continue;
            }

            // Assuming each block has a BlockRenderer class in the appropriate namespace
            $Block = $namespace . '\\' . $blockName . '\\Block';

            // Instantiate the block class
            try {
                new $Block($blockName, $blocksDir, $blocksUri);
            } catch (Throwable $throwable) {
                ErrorHandler::handleThrowable($throwable);
            }
        }
    }

    public static function addSpacerAttributeToBlocks($args): array
    {
        $args['attributes']['spacers'] = [
            'type'    => 'object',
            'default' => [
                'xs'  => [],
                'sm'  => [],
                'md'  => [],
                'lg'  => [],
                'xl'  => [],
                'xxl' => [],
            ],
        ];

        return $args;
    }
}
