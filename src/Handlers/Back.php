<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

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
        $style = Config::get('assetsUri') . 'build/styles/editor.css';

        $styleUri  = get_template_directory_uri() . $style;
        $stylePath = get_template_directory() . $style;

        wp_enqueue_style('theme-editor-style', $styleUri, [], filemtime($stylePath));

        $editorScript = Config::get('assetsUri') . 'build/js/editor.js';

        $editorScriptUri  = get_template_directory_uri() . $editorScript;
        $editorScriptPath = get_template_directory() . $editorScript;

        wp_enqueue_script('theme-editor-script', $editorScriptUri, [], filemtime($editorScriptPath), true);


        $style = Config::get('assetsUri') . 'fonts/block-icons/main.css';

        $styleUri = get_template_directory_uri() . $style;
        $stylePath = get_template_directory() . $style;

        wp_enqueue_style('block-icons-style', $styleUri, [], filemtime($stylePath));
    }
}
