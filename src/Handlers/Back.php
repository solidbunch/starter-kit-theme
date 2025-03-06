<?php

namespace StarterKit\Handlers;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;
use StarterKit\Exception\ConfigEntryNotFoundException;

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
     *
     * @throws ConfigEntryNotFoundException
     */
    public static function enqueueBlockEditorAssets(): void
    {
        $style = 'build/styles/editor.css';

        $styleUri  = Config::get('assetsUri') . $style;
        $stylePath = Config::get('assetsDir') . $style;

        wp_enqueue_style('theme-editor-style', $styleUri, [], filemtime($stylePath));

        $editorScript = 'build/js/editor.js';

        $editorScriptUri  = Config::get('assetsUri') . $editorScript;
        $editorScriptPath = Config::get('assetsDir') . $editorScript;

        wp_enqueue_script('theme-editor-script', $editorScriptUri, [], filemtime($editorScriptPath), true);


        $style = 'build/fonts/block-icons/block-icons.font.css';

        $styleUri = Config::get('assetsUri') . $style;
        $stylePath = Config::get('assetsDir') . $style;

        wp_enqueue_style('block-icons-style', $styleUri, [], filemtime($stylePath));
    }
}
