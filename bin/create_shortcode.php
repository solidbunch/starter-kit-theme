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
			$template = str_replace( array( '{name}', '{base}' ), array( $name, $base ),
				file_get_contents( __DIR__ . '/file_templates/shortcode_init.txt' ) );

			if ( ! mkdir( $concurrentDirectory = $shrotcodes_dir . $base ) && ! is_dir( $concurrentDirectory ) ) {
				throw new \RuntimeException( sprintf( 'Directory "%s" was not created', $concurrentDirectory ) );
			}

			$handle = fopen( $concurrentDirectory . '/init.php', 'wb' );

			if ( $handle && fwrite( $handle, $template ) ) {
				WP_CLI::success( "Shortcode {$name} : init.php created in {$concurrentDirectory}" );
			}

			//proceed shortcodes.php
			$template = str_replace( array( '{base}' ), array( $base_class ),
				file_get_contents( __DIR__ . '/file_templates/shortcode_class.txt' ) );

			$handle = fopen( $concurrentDirectory . '/shortcode.php', 'wb' );

			if ( $handle && fwrite( $handle, $template ) ) {
				WP_CLI::success( "Shortcode {$name} : shortcode.php created in {$concurrentDirectory}" );
			}

			//proceed view.php
			if ( ! mkdir( $concurrentDirectory = $shrotcodes_dir . $base . '/view' ) && ! is_dir( $concurrentDirectory ) ) {
				throw new \RuntimeException( sprintf( 'Directory "%s" was not created', $concurrentDirectory ) );
			}

			$template = file_get_contents( __DIR__ . '/file_templates/shortcode_view.txt' );

			$handle = fopen( $concurrentDirectory . '/view.php', 'wb' );

			if ( $handle && fwrite( $handle, $template ) ) {
				WP_CLI::success( "Shortcode {$name} : view.php created in {$concurrentDirectory}" );
			}
		}
	);
} catch ( \Exception $exception ) {
	WP_CLI::error( $exception->getMessage() );
}



