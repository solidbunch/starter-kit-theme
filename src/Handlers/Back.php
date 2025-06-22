<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

/**
 * Back End handler
 *
 * @package    Starter Kit
 */
class Back
{
    /**
     * Load assets in editor
     *
     * @return void
     */
    public static function enqueueBlockEditorAssets(): void
    {
        $style = 'build/styles/editor.css';

        $styleUri  = SK_ASSETS_URI . $style;
        $stylePath = SK_ASSETS_DIR . $style;

        wp_enqueue_style('theme-editor-style', $styleUri, [], filemtime($stylePath));

        $editorScript = 'build/js/editor.js';

        $editorScriptUri  = SK_ASSETS_URI . $editorScript;
        $editorScriptPath = SK_ASSETS_DIR . $editorScript;

        wp_enqueue_script('theme-editor-script', $editorScriptUri, [], filemtime($editorScriptPath), true);


        $style = 'build/fonts/block-icons/block-icons.font.css';

        $styleUri  = SK_ASSETS_URI . $style;
        $stylePath = SK_ASSETS_DIR . $style;

        wp_enqueue_style('block-icons-style', $styleUri, [], filemtime($stylePath));
    }
}
