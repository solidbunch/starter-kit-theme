<?php

/**
 * Reference result for config/common/gutenberg.php after conversion.
 *
 * Merge `blockEditorPostTypes` into the existing `gutenberg` group — don't replace the file,
 * `disableRedundantBlocks`/`disableAllDefaultBlocks`/`disableDefaultBlocksStyles` stay exactly
 * as they were (still correct: core blocks remain unwanted in favor of `starter-kit/*` for
 * whichever post types keep the block editor).
 *
 * `blockEditorPostTypes` is the allowlist consumed by
 * Handlers\Blocks\BlockEditorSupport::filterPostType() — post types not listed here fall back to
 * the classic editor. Ask the user for this list during the skill's scope-questions step;
 * `['post', 'news']` below is only the default — see CONVERT.md's post-type table.
 */

return [
    'config' => [
        'gutenberg' => [
            'disableRedundantBlocks'     => [
                'core/image',
                'core/heading',
                'core/code',
                'core/media-text',
                'core/columns',
                'core/group',
                'core/row',
                'core/stack',
            ],
            'disableAllDefaultBlocks'    => false,
            'disableDefaultBlocksStyles' => false,
            'blockEditorPostTypes'       => ['post', 'news'],
        ],
    ],
];
