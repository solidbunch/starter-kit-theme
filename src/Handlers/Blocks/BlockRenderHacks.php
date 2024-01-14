<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

/**
 * Includes workarounds for rendering issues in blocks.
 * Non-standard solutions or quick fixes for block rendering problems
 *
 * @package    Starter Kit
 */
class BlockRenderHacks
{
    /**
     * Tweak to address the issue where the template part wrapper is rendered outside the template part file.
     * It provides a workaround to correct this rendering behavior,
     * subtly implementing fixes without altering the core functionality.
     *
     * @param  string  $block_content
     * @param  array   $block
     *
     * @return string $block_content
     */
    public static function templatePartWrapperHack(string $block_content, array $block): string
    {
        if (
            $block['blockName'] !== 'core/template-part' ||
            empty($block['attrs']['removeWrapper']) ||
            !str_starts_with($block_content, '<div class="wp-block-template-part">')
        ) {
            return $block_content;
        }

        if (str_ends_with($block_content, '</div>')) {
            $block_content = substr($block_content, strlen('<div class="wp-block-template-part">'));
            $block_content = substr($block_content, 0, -strlen('</div>'));
        }

        return $block_content;
    }
}
