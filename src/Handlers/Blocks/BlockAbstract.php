<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use RuntimeException;
use StarterKit\Base\Config;
use StarterKit\Helper\Utils;
use Throwable;

/**
 * Block abstract class
 *
 * @package    Starter Kit
 */
abstract class BlockAbstract implements BlockInterface
{
    /**
     * Load block view
     *
     * @param  string  $file
     * @param  array   $data
     * @param  null    $base
     *
     * @return string
     */
    public static function loadBlockView(string $file = '', array $data = [], $base = null): string
    {
        if ($base === null) {
            $base = Config::get('blocksDir') . self::getCurrentBlockName() . '/' . Config::get('blocksViewDir');
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
            Utils::errorHandler($throwable);
        }

        return ob_get_clean();
    }

    /**
     * Generate block name from class name
     * StarterKitBlocks\BlockName\BlockName
     *
     * @return string
     */
    public static function getCurrentBlockName(): string
    {
        $blockNamespace = explode('\\', static::class);

        return array_slice($blockNamespace, -2, 1)[0] ?? '';
    }
}
