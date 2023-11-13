<?php

namespace StarterKit\Handlers\Settings;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GeneratorWizard
{

    public static array $replaceNames
        = [
            'theme_name'      => 'Starter Kit Theme',
            'package'         => 'Starter Kit',
            'theme_slug_'     => 'starter-kit-theme',
            'theme_slug'      => 'starter-kit',
            'theme_namespace' => 'StarterKit',
            'hooks_prefix'    => 'starter_kit',
        ];

    public static function addMenuItem(): void
    {
        add_submenu_page(
            'options-general.php', __('Generator Wizard', 'starter-kit'), __('Generator Wizard', 'starter-kit'), 'manage_options', 'generator-wizard', [self::class, 'generatorWizardPage']
        );
    }

    public static function generatorWizardPage(): void
    {
        ?>
        <div class="wrap">
            <h1><?php _e('Generator Wizard', 'starter-kit'); ?></h1>
            <?php
            // Check if the form is submitted
            if (isset($_POST['submit'])) {
                self::getData();

                return;
            }
            ?>
            <p>Add data to generate new theme</p>
            <form method="post" action="">
                <h2>Replace Names</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="theme_name"><?php _e('Theme Name:', 'starter-kit'); ?></label></th>
                        <td><input type="text" name="theme_name" id="theme_name" value="" placeholder="<?php echo self::$replaceNames['theme_name']; ?>" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="package"><?php _e('Package:', 'starter-kit'); ?></label></th>
                        <td><input type="text" name="package" id="package" value="" placeholder="<?php echo self::$replaceNames['package']; ?>" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="theme_slug"><?php _e('Theme Slug (Textdomain):', 'starter-kit'); ?></label></th>
                        <td><input type="text" name="theme_slug" id="theme_slug" value="" placeholder="<?php echo self::$replaceNames['theme_slug']; ?>" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="theme_namespace"><?php _e('Theme Namespace:', 'starter-kit'); ?></label></th>
                        <td><input type="text" name="theme_namespace" id="theme_namespace" placeholder="<?php echo self::$replaceNames['theme_namespace']; ?>" value="" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="hooks_prefix"><?php _e('Hooks Prefix:', 'starter-kit'); ?></label></th>
                        <td><input type="text" name="hooks_prefix" id="hooks_prefix" value="" placeholder="<?php echo self::$replaceNames['hooks_prefix']; ?>" class="regular-text"/></td>
                    </tr>
                </table>

                <?php wp_nonce_field('generator_wizard_admin_page_nonce'); ?>
                <?php submit_button(__('Run Wizard', 'starter-kit')); ?>
            </form>
        </div>
        <?php
    }

    private static function getData(): void
    {
        if (isset($_POST['_wpnonce']) && !wp_verify_nonce($_POST['_wpnonce'], 'generator_wizard_admin_page_nonce')) {
            wp_die('Security check failed');
        }

        echo "<h3>Results:</h3>";

        // Collect form data
        $formData = [];

        foreach (self::$replaceNames as $key => $value) {
            $formData[$key] = isset($_POST[$key]) ? sanitize_text_field($_POST[$key]) : '';
            if ($key == 'theme_slug_') {
                $formData[$key] = isset($_POST['theme_slug']) ? sanitize_text_field($_POST['theme_slug']) : '';
            }
            if (empty($formData[$key])) {
                echo "<strong>Error: " . $formData[$key] . " is empty</strong>";

                return;
            }
        }

        $newThemeDirectory = self::copyTheme($formData['theme_slug']);

        self::searchAndReplaceInTheme($newThemeDirectory, $formData);
    }

    private static function searchAndReplaceInTheme($newThemeDirectory, $formData): void
    {
        $iterator = new RecursiveDirectoryIterator($newThemeDirectory);
        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            // Skip 'node_modules', 'vendor' directories, and image files
            if ($file->isFile() && !self::isImageFile($file->getFilename())) {
                $content = file_get_contents($file);

                if ($file->getFilename() == 'Hooks.php') {
                    $content = str_ireplace("add_action('admin_menu', [Handlers\Settings\GeneratorWizard::class, 'addMenuItem']);", "", $content);
                }

                foreach ($formData as $key => $replace_with) {
                    if (!empty($replace_with) && str_contains($content, self::$replaceNames[$key])) {
                        $content = str_ireplace(self::$replaceNames[$key], $replace_with, $content);
                    }
                }

                file_put_contents($file, $content); // Write the new content back to the file
                echo "<p>File " . $file->getPathname() . " done </p>";
            }
        }
    }

    private static function isImageFile($filename): bool
    {
        return preg_match('/\.(jpg|jpeg|png|gif|bmp|svg|webp)$/i', $filename);
    }

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

            if ($item->getFileName() == 'GeneratorWizard.php') {
                continue;
            }

            // Skip 'node_modules', 'vendor', and '.git' directories
            if (str_contains($relativePath, '/node_modules') || str_contains($relativePath, '/vendor') || str_contains($relativePath, '/.git')) {
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
