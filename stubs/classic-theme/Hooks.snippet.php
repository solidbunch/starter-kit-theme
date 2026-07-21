<?php

/**
 * Deltas to apply to src/Base/Hooks.php::initHooks() during conversion.
 * Every block-related hook already in Hooks.php STAYS — this only adds lines, per
 * Architecture note E in the conversion plan (blocks/Gutenberg are retained).
 */

// 1. Gate the block editor per post type — ALWAYS applied. Add under the "Gutenberg blocks"
//    section, alongside the existing loadBlocks/loadBlocksCategories/DisableDefaultBlocks lines:
add_filter('use_block_editor_for_post_type', [Handlers\Blocks\BlockEditorSupport::class, 'filterPostType'], 10, 2);

// 2. Register the PageBuilder CF container — OPTIONAL, only if the Page Builder add-on
//    (optional/page-builder/) is emitted. Group with the other `carbon_fields_register_fields`
//    lines already in the "Meta Fields" section:
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\PageBuilder::class, 'make']);
