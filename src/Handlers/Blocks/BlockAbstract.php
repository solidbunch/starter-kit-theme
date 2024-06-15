<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use RuntimeException;
use StarterKit\Handlers\Errors\ErrorHandler;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use Throwable;

/**
 * Block abstract class
 *
 * @package    Starter Kit
 */
abstract class BlockAbstract implements BlockInterface
{
    protected string $blockName;

    public function __construct($blockName)
    {
        $this->blockName = $blockName;

        $this->registerBlock();

        //ToDo vvv Do we need to add 'init' and other hooks here? (enqueue_block_editor_assets, enqueue_block_assets, etc.)
        add_action('rest_api_init',[$this, 'blockRestApiEndpoints']);
        //$this->blockRestApiEndpoints();

        // ToDo vvv maybe move block Assets functions to abstract class?
        add_action('enqueue_block_editor_assets', [$this, 'blockEditorAssets']);
        add_action('enqueue_block_assets', [$this, 'blockAssets']);
    }
    /**
     * Load block view
     *
     * @param string      $file
     * @param array       $data
     * @param string|null $base
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function loadBlockView(string $file = '', array $data = [], string $base = null): string
    {
        if ($base === null) {
            $base = Config::get('blocksDir') . $this->blockName . '/' . Config::get('blocksViewDir');
        }

        $viewFilePath = $base . $file . '.php';

        ob_start();

        try {
            if (file_exists($viewFilePath)) {
                require $viewFilePath;
            } else {
                throw new RuntimeException('The view path ' . $viewFilePath . ' can not be found.');
            }
        } catch (Throwable $throwable) {
            ErrorHandler::handleThrowable($throwable);
        }

        return ob_get_clean();
    }

    /**
     * Generating block classes including spacers
     *
     * @param array $attributes
     *
     * @return string
     */
    public function generateBlockClasses(array $attributes): string
    {
        $blockClasses = [];

        if (!empty($attributes['className'])) {
            $blockClasses[] = $attributes['className'];
        }

        $blockClasses = array_merge($blockClasses, $this->generateSpacersClasses($attributes['spacers'] ?? []));

        return esc_attr(implode(' ', $blockClasses));
    }

    /**
     * Generating spacers classes
     *
     * @param array $spacers
     *
     * @return array
     */
    public function generateSpacersClasses(array $spacers): array
    {
        $spacerClasses = [];
        // ToDo store grid variables in one place - maybe scss
        $numberOfGrid = 5;

        foreach ($spacers as $item) {
            if (isset($item['valueRange'])) {
                foreach ($item['valueRange'] as $key => $value) {
                    $modifiedValue   = ($value === ($numberOfGrid + 1)) ? 'auto' : $value;
                    $modifiedClass   = str_replace('-xs', '', "$key-$modifiedValue");
                    $spacerClasses[] = $modifiedClass;
                }
            }
        }

        return $spacerClasses;
    }
}
