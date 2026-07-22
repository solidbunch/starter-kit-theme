<?php

/**
 * Delta to apply to src/Handlers/SetupTheme.php::addThemeSupport() during conversion.
 *
 * As an FSE (block) theme, WordPress core auto-registers `post-thumbnails` via
 * _add_default_theme_supports() (gated on wp_is_block_theme()) and renders the document <title>
 * unconditionally through the block-template loader. Once templates/*.html are deleted the theme is
 * no longer a block theme, so BOTH of those go away — a classic theme must declare them itself or it
 * loses the Featured Image metabox (no post-thumbnails support) and emits no <title> on any page
 * (no title-tag support → core's _wp_render_title_tag() bails).
 *
 * Add these two lines to the existing addThemeSupport() body; keep every other line in the method.
 */

add_theme_support('title-tag');
add_theme_support('post-thumbnails');
