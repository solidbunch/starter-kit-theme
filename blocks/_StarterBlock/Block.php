<?php

namespace StarterKitBlocks\StarterBlock;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;

/**
 * Block controller
 *
 * Copy this folder, rename the namespace/folder/block.json "name" to match, then trim any
 * asset entry / method you don't need. Full guide: blocks/CLAUDE.md.
 *
 * @package    Starter Kit
 */
class Block extends BlockAbstract
{
    /**
     * Block assets for editor and frontend.
     *
     * File names here are the COMPILED .js/.css in build/, not the src/ source files.
     * Every entry below is optional except 'editor_script' — delete the ones you don't need,
     * and delete the matching src/ file (Laravel Mix only compiles what's actually there).
     *
     * @var array
     */
    protected array $blockAssets = [
        'editor_script' => [ // A JavaScript file for use only in the Block Editor — always required
            'file'         => 'index.js',
            'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
        ],
        'editor_style'  => [ // A CSS file for use only in the Block Editor
            'file'         => 'editor.css',
            'dependencies' => [],
        ],
        'script'        => [ // A JavaScript file loaded in both the Block Editor and the front end
            'file'         => 'script.js',
            'dependencies' => [],
        ],
        'style'         => [ // A CSS file applied in both the Block Editor and the front end
            'file'         => 'style.css',
            'dependencies' => [],
        ],
        'view_script'   => [ // A JavaScript file for use only on the front end
            'file'         => 'view.js',
            'dependencies' => [],
        ],
        'view_style'    => [ // A CSS file for use only on the front end
            'file'         => 'view.css',
            'dependencies' => [],
        ],
    ];

    /**
     * Register block additional arguments including server side render callback.
     *
     * Leave this empty for a STATIC block (this scaffold's default — content is saved into
     * post HTML by src/index.jsx's save(), nothing renders server-side).
     *
     * To turn this into a DYNAMIC block instead (PHP renders it fresh on every request —
     * needed for DB data, post meta, or other runtime content):
     * 1. Set the render callback below.
     * 2. Change save() in src/index.jsx to `save: () => null`.
     * 3. Add a view/layout.php template and render it via $this->loadBlockView().
     * 4. If the callback needs post meta, read blocks/CLAUDE.md's "CRITICAL GOTCHAS" section
     *    first (usesContext in block.json, get_the_ID() returning 0 in REST context, etc.).
     *
     * public function registerBlockArgs(): void
     * {
     *     $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
     * }
     *
     * public function blockServerSideCallback(array $attributes, string $content, object $block): string
     * {
     *     $templateData = [
     *         'blockClass' => $this->generateBlockClasses($attributes), // merges className + spacers
     *     ];
     *
     *     return $this->loadBlockView('layout', $templateData); // → view/layout.php
     * }
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
    }

    /**
     * Register rest api endpoints.
     * Runs by abstract constructor on rest_api_init.
     *
     * Optional — only needed if the editor (or frontend) fetches data through a custom route,
     * e.g. Navigation's menu picker or News's paginated list.
     *
     * public function blockRestApiEndpoints(): void
     * {
     *     register_rest_route(SK_REST_API_NS, '/starter-block-example', [
     *         'methods'             => 'GET',
     *         'callback'            => [$this, 'exampleRestCallback'],
     *         'permission_callback' => fn () => current_user_can('edit_posts'),
     *     ]);
     * }
     *
     * public function exampleRestCallback(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
     * {
     *     return rest_ensure_response(['example' => true]);
     * }
     *
     * @return void
     */
    public function blockRestApiEndpoints(): void
    {
    }
}
