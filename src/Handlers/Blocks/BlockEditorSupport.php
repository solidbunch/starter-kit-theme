<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Turns the block editor off for specific post types, via a denylist.
 *
 * Only meant for post types with no registration file of their own to control this — WordPress's
 * native `post`/`page`. Custom post types already decide this at `register_post_type()`
 * (`show_in_rest` + `supports('editor')` in `Handlers/PostTypes/*.php`) — that registration is the
 * source of truth for them; listing one here on top of that is redundant, not wrong (this filter
 * can only turn the editor OFF, never force it ON over `show_in_rest => false`).
 *
 * `wp_*` post types (reusable blocks, navigation, template parts) are left alone — they have no
 * classic-editor equivalent and forcing them off would break wp-admin.
 *
 * @package    Starter Kit
 */
class BlockEditorSupport
{
    public static function filterPostType(bool $useBlockEditor, string $postType): bool
    {
        if (str_starts_with($postType, 'wp_')) {
            return $useBlockEditor;
        }

        $disabledPostTypes = Config::get('gutenberg/disableGutenbergForPostTypes');
        $disabledPostTypes = is_array($disabledPostTypes) ? $disabledPostTypes : [];

        if (in_array($postType, $disabledPostTypes, true)) {
            return false;
        }

        return $useBlockEditor;
    }
}
