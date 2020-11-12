<?php

namespace StarterKit\Helper;

use StarterKit\Helper\ResponsiveImages\Img;
use StarterKit\Helper\ResponsiveImages\Picture;
use StarterKit\Helper\ResponsiveImages\Resizer;
use StarterKit\Helper\ResponsiveImages\Size;
use StarterKit\Helper\ResponsiveImages\Source;
use StarterKit\Helper\ResponsiveImages\SrcsetItem;

/**
 * Media Helper
 *
 * Helper functions for work with media objects
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Media {
	
	/**
	 * Resize image
	 *
	 * @param string $url
	 * @param integer $width
	 * @param integer $height
	 * @param bool $crop
	 *
	 * @return string image path
	 */
	public static function img_resize( $url, $width, $height, $crop = true ) {
		if ( ! class_exists( 'Aq_Resize' ) ) {
			require_once \get_template_directory() . '/vendor-custom/aq_resizer/aq_resizer.php';
		}
		
		if ( strpos( $url, 'http' ) !== 0 ) {
			$protocol = \is_ssl() ? 'https:' : 'http:';
			if ( $url <> '' ) {
				$url = $protocol . $url;
			}
		}
		
		$src = \aq_resize( $url, $width, $height, $crop );
		
		if ( ! $src ) {
			$src = $url;
		}
		
		return $src;
		
	}
	
	
	/**
	 * Get the placeholder svg image.
	 *
	 * @param int $imageWidth
	 * @param int $imageHeight
	 *
	 * @return string The URL to the placeholder image.
	 */
	public static function getPlaceholderImage( $imageWidth = 24, $imageHeight = 24 ) {
		$data = [
			'width'  => (int) $imageWidth,
			'height' => (int) $imageHeight,
			'fill'   => Utils::get_option( 'placeholder_color', '#555' ),
		];
		
		$svg = base64_encode( View::load( '/template-parts/lazy-loading-svg', $data, true ) );
		
		return "data:image/svg+xml;base64," . $svg;
	}
	
	
	/**
	 * Retrieve attachment local Path by it`s Url
	 *
	 * @param $url
	 *
	 * @return bool|string
	 */
	public static function getAttachmentPathByUrl( $url ) {
		if ( ! $url || ! is_string( $url ) ) {
			return false;
		}
		// Define upload path & dir.
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info['basedir'];
		$upload_url  = $upload_info['baseurl'];
		
		$http_prefix     = 'http://';
		$https_prefix    = 'https://';
		$relative_prefix = '//'; // The protocol-relative URL
		
		/* if the $url scheme differs from $upload_url scheme, make them match 
		   if the schemes differe, images don't show up. */
		if ( ! strncmp( $url, $https_prefix,
			strlen( $https_prefix ) ) ) { //if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
		} elseif ( ! strncmp( $url, $http_prefix,
			strlen( $http_prefix ) ) ) { //if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );
		} elseif ( ! strncmp( $url, $relative_prefix,
			strlen( $relative_prefix ) ) ) { //if url begins with // make $upload_url begin with // as well
			$upload_url = str_replace( array( 0 => (string) $http_prefix, 1 => (string) $https_prefix ),
				$relative_prefix, $upload_url );
		}
		
		
		// Check if $img_url is local.
		if ( false === strpos( $url, $upload_url ) ) {
			return false;
		}
		
		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = $upload_dir . $rel_path;
		
		return $img_path;
	}
	
	
	/**
	 * @param $img_path
	 *
	 * @return array|false
	 */
	public static function getAttachmentInfoByPath( $img_path ) {
		// Check if img path exists, and is an image indeed.
		if ( file_exists( $img_path ) ) {
			return getimagesize( $img_path );
		}
		
		return false;
	}
	
	
	/**
	 * Responsive images helper
	 * Create html tag Picture from post thumbnail
	 *
	 * @param $postId
	 * @param array $mqWithWidth , format ['metaQuery' => widthInPx(int), ..., defaultWidthInPx(int) ]
	 * @param bool $hasDoubleDevicePixelRatio
	 * @param bool $skipLazyLoad
	 *
	 * @return string
	 */
	public static function pictureForPost(
		$postId,
		array $mqWithWidth = [],
		$hasDoubleDevicePixelRatio = true,
		$skipLazyLoad = false
	) {
		$postId = (int) $postId;
		
		if ( ! $postId || ! has_post_thumbnail( $postId ) ) {
			return '';
		}
		
		$originUrl = get_the_post_thumbnail_url( $postId, 'full' );
		$imgAlt    = esc_attr( strip_tags( get_the_title() ) );
		
		return self::picture( $originUrl, $mqWithWidth, $hasDoubleDevicePixelRatio, $imgAlt, $skipLazyLoad );
	}
	
	
	
	/**
	 * Responsive images helper
	 * Create html tag Picture from attachment url
	 *
	 * @param string $originUrl
	 * @param array $mqWithWidth , format ['metaQuery' => widthInPx(int), ..., defaultWidthInPx(int) ]
	 * @param bool $hasDoubleDevicePixelRatio
	 * @param string $imgAlt
	 * @param bool $skipLazyLoad
	 *
	 * @return string
	 */
	public static function picture(
		$originUrl,
		array $mqWithWidth = [],
		$hasDoubleDevicePixelRatio = true,
		$imgAlt = '',
		$skipLazyLoad = false
	) {
		
		$pictureHtml = '';
		
		try {
			$imgAlt  = esc_attr( strip_tags( $imgAlt ) );
			$resizer = Resizer::makeByUrl( $originUrl );
			
			$sources = [];
			foreach ( $mqWithWidth as $mediaQuery => $widthToResize ) {
				$mediaQuery    = is_string( $mediaQuery ) && ! empty( $mediaQuery ) ? $mediaQuery : '';
				$widthToResize = (int) $widthToResize;
				
				$srcsetItems   = [];
				$srcsetItems[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize ), '1x',
					$skipLazyLoad );
				if ( $hasDoubleDevicePixelRatio ) {
					$srcsetItems[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize * 2 ), '2x',
						$skipLazyLoad );
				}
				
				$sources[] = Source::make( $srcsetItems, [], $mediaQuery, '', $skipLazyLoad );
			}
			
			$pictureHtml = Picture::make( $originUrl, $imgAlt, null, null, $sources, $skipLazyLoad )->render();
			
		} catch ( \Exception $ex ) {
			error_log( "\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n" );
		}
		
		return $pictureHtml;
	}
	
	
	
	/**
	 * Responsive images helper
	 * Create html tag Img from post thumbnail
	 *
	 * @param $postId
	 * @param array $mqWithWidth , format ['metaQuery' => widthInPx(int), ... ]
	 * @param bool $hasDoubleDevicePixelRatio
	 * @param bool $skipLazyLoad
	 *
	 * @return string
	 */
	public static function imgForPost(
		$postId,
		array $mqWithWidth = [],
		$hasDoubleDevicePixelRatio = true,
		$skipLazyLoad = false
	) {
		$postId = (int) $postId;
		
		if ( ! $postId || ! has_post_thumbnail( $postId ) ) {
			return '';
		}
		
		$originUrl = get_the_post_thumbnail_url( $postId, 'full' );
		$imgAlt    = esc_attr( strip_tags( get_the_title() ) );
		
		return self::img( $originUrl, $mqWithWidth, $hasDoubleDevicePixelRatio, $imgAlt, $skipLazyLoad );
	}
	
	
	
	/**
	 * Responsive images helper
	 * Create html tag Img from attachment url
	 *
	 * @param string $originUrl
	 * @param array $mqWithWidth , format ['metaQuery' => widthInPx(int), ... ]
	 * @param bool $hasDoubleDevicePixelRatio
	 * @param string $imgAlt
	 * @param bool $skipLazyLoad
	 *
	 * @return string
	 */
	public static function img(
		$originUrl,
		array $mqWithWidth = [],
		$hasDoubleDevicePixelRatio = true,
		$imgAlt = '',
		$skipLazyLoad = false
	) {
		$imgHtml = '';
		
		try {
			$imgAlt  = esc_attr( strip_tags( $imgAlt ) );
			$resizer = Resizer::makeByUrl( $originUrl );
			
			$sizes = $srcset = [];
			foreach ( $mqWithWidth as $mediaQuery => $widthToResize ) {
				$mediaQuery    = is_string( $mediaQuery ) && ! empty( $mediaQuery ) ? $mediaQuery : '';
				$widthToResize = (int) $widthToResize;
				
				$sizes[] = Size::make( $mediaQuery, "{$widthToResize}px" );
				
				$srcset[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize ), "{$widthToResize}w",
					$skipLazyLoad );
				if ( $hasDoubleDevicePixelRatio ) {
					$srcset[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize * 2 ),
						( $widthToResize * 2 ) . 'w', $skipLazyLoad );
				}
			}
			
			
			$imgHtml = Img::make( $originUrl, $imgAlt, null, null, $srcset, $sizes, $skipLazyLoad )->render();
			
		} catch ( \Exception $ex ) {
			error_log( "\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n" );
		}
		
		return $imgHtml;
	}
	
	
	
	/**
	 * Get size information for all registered image sizes. Even they was removed by filters
	 *
	 * @return array Data for all registered image sizes (width, height, crop, name).
	 */
	public static function getAllInitedImageSizes() {
		$sizes = [];
		
		$default_sizes    = [ 'thumbnail', 'medium', 'medium_large', 'large' ];
		$additional_sizes = wp_get_additional_image_sizes();
		
		if ( ! empty( $additional_sizes ) ) {
			$default_sizes = array_merge( $default_sizes, array_keys( $additional_sizes ) );
		}
		
		foreach ( $default_sizes as $size_name ) {
			$sizes[ $size_name ] = [
				'width'  => '',
				'height' => '',
				'crop'   => false,
				'name'   => $size_name,
			];
			
			$sizes[ $size_name ]['width'] = isset( $additional_sizes[ $size_name ]['width'] )
				? (int) $additional_sizes[ $size_name ]['width']  // // For theme-added sizes.
				: (int) get_option( "{$size_name}_size_w" ); // For default sizes set in options.
			
			
			$sizes[ $size_name ]['height'] = isset( $additional_sizes[ $size_name ]['height'] )
				? (int) $additional_sizes[ $size_name ]['height']  // // For theme-added sizes.
				: (int) get_option( "{$size_name}_size_h" ); // For default sizes set in options.
			
			
			$sizes[ $size_name ]['crop'] = isset( $additional_sizes[ $size_name ]['crop'] )
				? (int) $additional_sizes[ $size_name ]['crop']  // // For theme-added sizes.
				: (int) get_option( "{$size_name}_crop" ); // For default sizes set in options.
		}
		
		return $sizes;
	}
	
	
	
	/**
	 * Get the image sizes (formatted strings). Uses for settings
	 *
	 * @return array A list of image sizes in the form of 'medium' => 'medium - 300 × 300'.
	 */
	public static function getAllInitedImageSizesFormatted() {
		$sizes = self::getAllInitedImageSizes();
		
		foreach ( $sizes as $size_key => $size_data ) {
			$sizes[ $size_key ] = sprintf(
				'%s - %d x %d (crop = %s)', esc_html( stripslashes( $size_data['name'] ) ),
				$size_data['width'],
				$size_data['height'],
				$size_data['crop']
			);
		}
		
		return $sizes;
	}
}
