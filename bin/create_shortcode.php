<?php
/**
 * @category   WP_CLI commands
 * @package    fruitfulblank
 * @author     Mates Marketing <hello@matesmarketing.com>
 * @author     Nikita Bolotov <nikita.bolotov@matesmarketing.com>
 * @copyright  2018 Nikita Bolotov
 * @license    https://opensource.org/licenses/OSL-3.0
 */
try {
	WP_CLI::add_command(
		'create:shortcode',
		function ( $args, $assoc_args ) {
			$shrotcodes_dir = THEME_ROOT_DIRECTORY . '/core/shortcodes/';

			$name       = $assoc_args['name'];
			$base       = strtolower( $name );
			$base_class = ucfirst( $name );

			//proceed init.php
			$concurrentDirectory = create_dir( $shrotcodes_dir, $base );
			create_file(
				__DIR__ . '/file_templates/shortcode_init.txt',
				[ '{name}', '{base}' ],
				[ $name, $base ],
				$concurrentDirectory . '/init.php'
			);

			//proceed shortcodes.php
			create_file(
				__DIR__ . '/file_templates/shortcode_class.txt',
				[ '{base}' ],
				[ $base_class ],
				$concurrentDirectory . '/shortcode.php'
			);

			//proceed view.php
			$concurrentDirectory = create_dir( $concurrentDirectory, '/view' );
			create_file(
				__DIR__ . '/file_templates/shortcode_view.txt',
				[ '{base}' ],
				[ $base ],
				$concurrentDirectory . '/view.php'
			);
		}
	);
} catch ( \Exception $exception ) {
	WP_CLI::error( $exception->getMessage() );
}
