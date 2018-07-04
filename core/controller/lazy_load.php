<?php
/**
 * Lazy-load images.
 *
 * Modified version of Lazy Images module in Jetpack.
 *
 * @link https://github.com/Automattic/jetpack/blob/master/modules/lazy-images/lazy-images.php
 */

namespace ffblank\controller;

/**
 * Add LazyLoad support for all images
 **/
class lazy_load {
	
	/**
	 * Constructor
	 **/
	function __construct() {

		add_action( 'init', array( $this, 'run_lazy_load'));
		
	}

	/**
	 * Run lazy load
	 */
	function run_lazy_load() {
		// check if we need to run lazy load actions
		if ( ! $this->skip() ) {

			add_filter( 'the_content', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
			add_filter( 'post_thumbnail_html', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
			add_filter( 'get_avatar', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
			add_filter( 'widget_text', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
			add_filter( 'get_image_tag', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
			add_filter( 'wp_get_attachment_image_attributes', array( $this, 'process_image_attributes' ), PHP_INT_MAX );
	
			// Load scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
		
			// Do not lazy load avatar in admin bar.
			add_action( 'admin_bar_menu', array( $this, 'remove_filters' ), 0 );
			// Ensure that our lazy image attributes are not filtered out of image tags.
			add_filter( 'wp_kses_allowed_html', array( $this, 'allow_lazy_attributes' ) );

		}
	}

	/**
	 * Check if we need to run lazy load actions
	 */
	function skip() {

		// If this is the admin page, do nothing.
		if ( is_admin() ) {
			return true;
		}
		
		$is_img_lazy_load_enabled = (int)\ffblank\helper\utils::get_option( 'img_lazy_load', 0 );

		if ( $is_img_lazy_load_enabled !== 1 ) {
			return true;
		}
		
		// If the Jetpack Lazy-Images module is active, do nothing.
		if ( ! apply_filters( 'lazyload_is_enabled', true ) ) {
			return true;
		}
		
		// If AMP is active, do nothing.
		if ( \ffblank\helper\utils::is_amp() ) {
			return true;
		}
		
		return false;
	}

	/**
	 * Find image elements that should be lazy-loaded.
	 *
	 * @param string $content The content.
	 * @return string
	 */
	function add_image_placeholders( $content ) {
		// Don't lazyload for feeds, previews.
		if ( is_feed() || is_preview() ) {
			return $content;
		}
		// Don't lazy-load if the content has already been run through previously.
		if ( false !== strpos( $content, 'data-src' ) ) {
			return $content;
		}

		// Find all <img> elements via regex, add lazy-load attributes.
		$content = preg_replace_callback( '#<(img)([^>]+?)(>(.*?)</\\1>|[\/]?>)#si', array( $this, 'process_image' ), $content );
		return $content;

	}

	/**
	 * Returns true when a given string of classes contains a class signifying image
	 * should not be lazy-loaded
	 *
	 * @param string $classes A string of space-separated classes.
	 * @return bool
	 */
	function should_skip_image_with_blacklisted_class( $classes ) {
		$blacklisted_classes = array(
			'skip-lazy',
		);

		foreach ( $blacklisted_classes as $class ) {
			if ( false !== strpos( $classes, $class ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Processes images in content by acting as the preg_replace_callback.
	 *
	 * @param array $matches <img> element to be altered.
	 *
	 * @return string The image with updated lazy attributes
	 */
	function process_image( $matches ) {
		$old_attributes_str       = $matches[2];
		$old_attributes_kses_hair = wp_kses_hair( $old_attributes_str, wp_allowed_protocols() );
		if ( empty( $old_attributes_kses_hair['src'] ) ) {
			return $matches[0];
		}
		$old_attributes = $this->flatten_kses_hair_data( $old_attributes_kses_hair );
		$new_attributes = $this->process_image_attributes( $old_attributes );
		// If we didn't add lazy attributes, just return the original image source.
		if ( empty( $new_attributes['data-src'] ) ) {
			return $matches[0];
		}
		$new_attributes_str = $this->build_attributes_string( $new_attributes );

		return sprintf( '<img %1$s><noscript>%2$s</noscript>', $new_attributes_str, $matches[0] );
	}

	/**
	 * Given an array of image attributes, updates the `src`, `srcset`, and `sizes` attributes so
	 * that they load lazily.
	 *
	 * @param array $attributes Attributes of the current <img> element.
	 *
	 * @return array The updated image attributes array with lazy load attributes.
	 */
	function process_image_attributes( $attributes ) {
		if ( empty( $attributes['src'] ) ) {
			return $attributes;
		}
		if ( ! empty( $attributes['class'] ) && $this->should_skip_image_with_blacklisted_class( $attributes['class'] ) ) {
			return $attributes;
		}

		$old_attributes = $attributes;

		// Add the lazy class to the img element.
		$attributes['class'] = $this->set_lazy_class( $attributes );

		// Set placeholder and lazy-src.
		$attributes['src'] = $this->get_placeholder_image();

		// Set data-src to the original source uri.
		$attributes['data-src'] = $old_attributes['src'];

		// Process `srcset` attribute.
		if ( ! empty( $attributes['srcset'] ) ) {
			$attributes['data-srcset'] = $old_attributes['srcset'];
			unset( $attributes['srcset'] );
		}
		// Process `sizes` attribute.
		if ( ! empty( $attributes['sizes'] ) ) {
			$attributes['data-sizes'] = $old_attributes['sizes'];
			unset( $attributes['sizes'] );
		}

		return $attributes;
	}

	/**
	 * Append a `lazy` class to <img> elements for lazy-loading.
	 *
	 * @param array $attributes <img> element attributes.
	 * @return string
	 */
	function set_lazy_class( $attributes ) {
		if ( array_key_exists( 'class', $attributes ) ) {
			$classes  = $attributes['class'];
			$classes .= ' lazy';
		} else {
			$classes = 'lazy';
		}

		return $classes;
	}

	/**
	 * Set the placeholder image.
	 *
	 * @return string The URL to the placeholder image.
	 */
	function get_placeholder_image() {
		return get_theme_file_uri( 'assets/images/lazy/placeholder.svg' );
	}

	/**
	 * Flatten attribute list into string.
	 *
	 * @param array $attributes Array of attributes.
	 * @return array $flattened_attributes
	 */
	function flatten_kses_hair_data( $attributes ) {
		$flattened_attributes = array();
		foreach ( $attributes as $name => $attribute ) {
			$flattened_attributes[ $name ] = $attribute['value'];
		}
		return $flattened_attributes;
	}

	/**
	 * Build string of new attributes to be returned to the <img> element.
	 *
	 * @param array $attributes Array of attributes.
	 * @return string
	 */
	function build_attributes_string( $attributes ) {
		$string = array();
		foreach ( $attributes as $name => $value ) {
			if ( '' === $value ) {
				$string[] = sprintf( '%s', $name );
			} else {
				$string[] = sprintf( '%s="%s"', $name, esc_attr( $value ) );
			}
		}

		return implode( ' ', $string );
	}

	/**
	 * Load lazy JS
	 */
	function load_assets() {
		wp_enqueue_script( 'ffblank-lazy-load-images', FFBLANK()->config['assets_uri'] . 'js/lazyload.js', array(), FFBLANK()->config['cache_time'], false );
		wp_script_add_data( 'ffblank-lazy-load-images', 'defer', true );
	}

	/**
	 * Do not lazy load avatar in admin bar.
	 */
	function remove_filters() {
		remove_filter( 'the_content', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
		remove_filter( 'post_thumbnail_html', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
		remove_filter( 'get_avatar', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
		remove_filter( 'widget_text', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
		remove_filter( 'get_image_tag', array( $this, 'add_image_placeholders' ), PHP_INT_MAX );
		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'process_image_attributes' ), PHP_INT_MAX );
	}
	
	/**
	 * Ensure that our lazy image attributes are not filtered out of image tags.
	 *
	 * @param array $allowed_tags The allowed tags and their attributes.
	 * @return array
	 */
	function allow_lazy_attributes( $allowed_tags ) {
		if ( ! isset( $allowed_tags['img'] ) ) {
			return $allowed_tags;
		}
		// But, if images are allowed, ensure that our attributes are allowed!
		$img_attributes = array_merge( $allowed_tags['img'], array(
			'data-src'    => 1,
			'data-srcset' => 1,
			'data-sizes'  => 1,
			'class'       => 1,
		) );
		$allowed_tags['img'] = $img_attributes;
		return $allowed_tags;
	}

}
