<?php

/**
 * Delta to apply to src/Base/Hooks.php::initHooks() during conversion.
 * Every block-related hook already in Hooks.php STAYS — this only adds one line, per
 * Architecture note E in the conversion plan (blocks/Gutenberg are retained).
 *
 * Note: the `use_block_editor_for_post_type` filter (Handlers\Blocks\BlockEditorSupport) is
 * already live in this theme's Hooks.php regardless of FSE/classic — it's not a conversion delta,
 * see `config/common/gutenberg.php`'s `disableGutenbergForPostTypes` key instead.
 */

// Register the PageExampleMeta CF container — ALWAYS applied; the unified page-example scaffold
// (page-example.php + its Repository/Meta pair) is emitted unconditionally. Group this with the
// other `carbon_fields_register_fields` lines already in the "Meta Fields" section:
add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\PageExampleMeta::class, 'make']);
