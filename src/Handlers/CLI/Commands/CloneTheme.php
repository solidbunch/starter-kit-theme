<?php

namespace StarterKit\Handlers\CLI\Commands;

defined('ABSPATH') || exit;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use StarterKit\Helper\Config;
use WP_CLI;
use WP_CLI\ExitException;

/**
 * WP-CLI Command to clone current theme to new one with new namespace
 *
 * @package    Starter Kit
 */
class CloneTheme implements CLICommandInterface
{
    /**
     * Search values
     *
     * @var array
     */
    public static array $searchNames = [];

    /**
     * Values to be replaced with
     *
     * @var array
     */
    public static array $replaceNames = [];

    /**
     * Run the command
     *
     * @throws ExitException
     */
    public static function run(): void
    {
        $searchNames['themeName']        = Config::get('themeName');
        $searchNames['package']          = Config::get('package');
        $searchNames['themeSlug']        = Config::get('themeSlug');
        $searchNames['themeNamespace']   = Config::get('themeNamespace');
        $searchNames['hooksPrefix']      = Config::get('hooksPrefix');
        $searchNames['settingsPrefix']   = Config::get('settingsPrefix');
        $searchNames['restApiNamespace'] = Config::get('restApiNamespace');

        self::$searchNames = $searchNames;

        self::readData();

        $newThemeDirectory = self::copyTheme(self::$replaceNames['themeSlug']);

        if (empty($newThemeDirectory)) {
            WP_CLI::error('New theme path is empty');
        }

        self::searchAndReplaceInTheme($newThemeDirectory, self::$replaceNames);

        WP_CLI::success('New theme cloned into ' . $newThemeDirectory);
    }

    /**
     * Read the value from prompt
     *
     * @throws ExitException
     */
    private static function read($readLabel, $required = true): string
    {
        WP_CLI::line("Please enter " . $readLabel . ":");
        $handle = fopen("php://stdin", "r");
        $value  = trim(fgets($handle));
        fclose($handle);

        if ($required && empty($value)) {
            WP_CLI::error('Empty value not allowed');
        }

        return sanitize_text_field($value);
    }

    /**
     * Read the $searchNames values and write to $replaceNames
     *
     * @throws ExitException
     */
    private static function readData(): void
    {
        foreach (self::$searchNames as $key => $value) {
            self::$replaceNames[$key] = self::read("\"" . $key . "\" (current: \"" . $value . "\")");
        }
    }


    /**
     * Update names in new theme
     *
     * @param $newThemeDirectory
     * @param $replaceNames
     *
     * @return void
     */
    private static function searchAndReplaceInTheme($newThemeDirectory, $replaceNames): void
    {
        $iterator = new RecursiveDirectoryIterator($newThemeDirectory);
        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            // Skip 'node_modules', 'vendor' directories, and image files
            if ($file->isFile() && !self::isImageFile($file->getFilename())) {
                $content = file_get_contents($file);

                foreach ($replaceNames as $key => $replaceWith) {
                    if (!empty($replaceWith) && str_contains($content, self::$searchNames[$key])) {
                        if ($key == 'themeSlug') {
                            $content = str_ireplace(self::$searchNames[$key] . '-theme', $replaceWith, $content);
                        }
                        $content = str_ireplace(self::$searchNames[$key], $replaceWith, $content);
                    }
                }

                file_put_contents($file, $content); // Write the new content back to the file
                WP_CLI::line("File " . $file->getPathname() . " done");
            }
        }
    }

    /**
     * Check file type
     *
     * @param $filename
     *
     * @return bool
     */
    private static function isImageFile($filename): bool
    {
        return preg_match('/\.(jpg|jpeg|png|gif|bmp|svg|webp)$/i', $filename);
    }

    /**
     * Copy current theme to new one
     *
     * @param $themeSlug
     *
     * @return string
     */
    private static function copyTheme($themeSlug): string
    {
        $source      = get_theme_root() . '/' . get_template();
        $destination = get_theme_root() . '/' . $themeSlug;

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $iterator = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST) as $item) {
            // Construct the relative path
            $relativePath = str_replace($source, '', $item->getPathname());

            // Skip 'node_modules', 'vendor', and '.git' directories
            if ($relativePath == '/node_modules' || $relativePath == '/vendor' || $relativePath == '/.git') {
                continue;
            }
            if (
                str_contains($relativePath, '/node_modules/') ||
                str_contains($relativePath, '/vendor/') ||
                str_contains($relativePath, '/.git/')
            ) {
                continue;
            }

            // Construct the destination path
            $destPath = $destination . $relativePath;

            if ($item->isDir()) {
                mkdir($destPath, 0755, true);
            } else {
                copy($item->getPathname(), $destPath);
            }
        }

        return $destination;
    }
}
