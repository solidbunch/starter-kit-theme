<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;
use StarterKit\Exception\ConfigEntryNotFoundException;

/**
 * Gates the block editor per post type after FSE is removed.
 *
 * The theme's custom Gutenberg blocks (blocks/*) are retained project-wide, but only editorial
 * post types listed in `gutenberg/blockEditorPostTypes` (config/common/gutenberg.php) open in the
 * block editor; every other editorial post type falls back to the classic editor (plus Carbon
 * Fields, where registered — see Meta/PostMeta/PageBuilder for `page`).
 *
 * Two things the allowlist deliberately does NOT override:
 *   - It cannot turn the block editor ON for a type whose own register_post_type() call has
 *     `show_in_rest => false` — that is a separate, earlier core gate
 *     (see wp-includes/post.php::use_block_editor_for_post_type()).
 *   - WordPress's own `wp_*` block-based internal types (reusable blocks / synced patterns,
 *     template parts, navigation, ...) are left on core's decision — they have no classic-editor
 *     equivalent, and the allowlist is about editorial content, not core infrastructure.
 *
 * @package    Starter Kit
 */
class BlockEditorSupport
{
    public static function filterPostType(bool $useBlockEditor, string $postType): bool
    {
        // Core's own block-based post types keep whatever core decided — forcing reusable blocks,
        // navigation or template parts into the classic editor would break wp-admin.
        if (str_starts_with($postType, 'wp_')) {
            return $useBlockEditor;
        }

        try {
            $allowedPostTypes = Config::get('gutenberg/blockEditorPostTypes');
        } catch (ConfigEntryNotFoundException) {
            // Filter active before the config key was merged (a partially-applied conversion) —
            // defer to core instead of fataling every wp-admin edit screen.
            return $useBlockEditor;
        }

        return in_array($postType, $allowedPostTypes, true);
    }
}
