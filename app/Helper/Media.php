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
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Media {
	
	/**
	 * Generate image tag with various attributes
	 *
	 * @param array $image_atts
	 * @param array $func_atts
	 *
	 * @echo  string image tag
	 * or
	 * @return bool false
	 **/
	public static function the_img( $image_atts = [], $func_atts = [] ) {
		if ( ! class_exists( 'Aq_Resize' ) ) {
			require_once get_template_directory() . '/vendor-custom/aq_resizer/aq_resizer.php';
		}
		
		$is_queried_post_thumb = false;
		
		$func_dafault_atts = [
			'attachment_id' => 0,
			'hdmi'          => true,
			'size'          => 'full',
			'crop'          => false,
			'single'        => true,
			'upscale'       => false,
			'resize'        => true,
		];
		
		$func_atts = wp_parse_args( $func_atts, $func_dafault_atts );
		
		// If src and attachment_id is empty or if src image is post featured image, we can find out attachment_id
		if ( ( empty( $image_atts['src'] ) && empty( $func_atts['attachment_id'] ) ) or ( ! empty( $image_atts['src'] ) && $image_atts['src'] === get_the_post_thumbnail_url( get_the_ID(), $func_atts['size'] ) ) ) {
			
			$is_queried_post_thumb = true;
			$func_atts['attachment_id'] = get_post_thumbnail_id( get_the_ID() );
		}
		
		if ( ! empty( $func_atts['attachment_id'] ) ) {
			
			$attachment_data['url'] = wp_get_attachment_image_url( $func_atts['attachment_id'], $func_atts['size'] );
			$attachment_data['alt'] = get_post_meta( $func_atts['attachment_id'], '_wp_attachment_image_alt', true ) ? get_post_meta( $func_atts['attachment_id'], '_wp_attachment_image_alt', true ) : '';
			
		} else {
			
			$attachment_data['url'] = '';
			$attachment_data['alt'] = '';
			
		}
		
		$default_attrs = [
			'src'    => $attachment_data['url'] ? $attachment_data['url'] : '',
			'width'  => 0,
			'height' => 0,
			'title'  => '',
			'alt'    => $is_queried_post_thumb ? strip_tags( get_the_title() ) : $attachment_data['alt'],
			'id'     => '',
			'class'  => '',
		];
		
		$image_atts = wp_parse_args( $image_atts, $default_attrs );
		
		
		if ( empty( $image_atts['src'] ) ) {
			return false;
		}
		
		$orig_src = $image_atts['src'];
		// SVG
		$is_svg = Utils::is_attachment_svg( $func_atts['attachment_id'], $image_atts['src'] );

		if ( $func_atts['resize'] && ! $is_svg ) {
			
			if ( ! empty( $image_atts['data-width'] ) ) {
				
				$image_atts['data-height'] = ! empty( $image_atts['data-height'] ) ? $image_atts['data-height'] : null;
				
				$src = aq_resize( $image_atts['src'], absint( $image_atts['data-width'] ), absint( $image_atts['data-height'] ), $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );
			} else {
				$src = aq_resize( $image_atts['src'], absint( $image_atts['width'] ), absint( $image_atts['height'] ), $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );
			}
			
		}
		
		
		if ( empty( $src ) || $is_svg ) {
			$image_atts['src'] = esc_url( $image_atts['src'] );
		} else {
			$image_atts['src'] = esc_url( $src );
		}
		
		if ( filter_var( $func_atts['hdmi'], FILTER_VALIDATE_BOOLEAN ) && ! $is_svg ) {
			
			if ( ! empty( $image_atts['data-width'] ) ) {
				$double_width = ! is_null( $image_atts['data-width'] ) ? absint( $image_atts['data-width'] ) * 2 : null;
				$double_height = ! is_null( $image_atts['data-height'] ) ? absint( $image_atts['data-height'] ) * 2 : null;
			} else {
				$double_width = ! is_null( $image_atts['width'] ) ? absint( $image_atts['width'] ) * 2 : null;
				$double_height = ! is_null( $image_atts['height'] ) ? absint( $image_atts['height'] ) * 2 : null;
			}
			
			$src2x = aq_resize( $orig_src, $double_width, $double_height, $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );
			
			if ( $src2x != false ) {
				$image_atts['srcset'] = esc_url( $src ) . ' 1x, ' . esc_url( $src2x ) . ' 2x';
			}
		}
		
		$image_atts['width'] = absint( $image_atts['width'] );
		$image_atts['height'] = absint( $image_atts['height'] );
		
		//Add filter to atts
		$image_atts = apply_filters( 'StarterKit/media_img/attributes', $image_atts );
		
		$image_html = '<img ';
		
		foreach ( $image_atts as $att_name => $image_att ) {
			if ( ! empty( $image_att ) || $att_name === 'alt' ) {
				$image_html .= $att_name . '="' . esc_attr( $image_att ) . '" ';
			}
			
		}
		
		$image_html .= '>';
		
		echo $image_html;
	}
	
	
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
		
		$svg = base64_encode( Starter_Kit()->View->load( '/template-parts/lazy-loading-svg', $data, true ) );
		
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
		if ( ! strncmp( $url, $https_prefix, strlen( $https_prefix ) ) ) { //if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
		} elseif ( ! strncmp( $url, $http_prefix, strlen( $http_prefix ) ) ) { //if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );
		} elseif ( ! strncmp( $url, $relative_prefix, strlen( $relative_prefix ) ) ) { //if url begins with // make $upload_url begin with // as well
			$upload_url = str_replace( array( 0 => (string) $http_prefix, 1 => (string) $https_prefix ), $relative_prefix, $upload_url );
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
	 *
	 * @return string
	 */
	public static function pictureForPost( $postId, array $mqWithWidth = [], $hasDoubleDevicePixelRatio = true ) {
		$postId = (int) $postId;
		
		if ( ! $postId || ! has_post_thumbnail( $postId ) ) {
			return '';
		}
		
		$pictureHtml = '';
		
		try {
			
			$originUrl = get_the_post_thumbnail_url( $postId, 'full' );
			$imgAlt    = esc_attr( strip_tags( get_the_title() ) );
			
			$resizer = Resizer::makeByUrl( $originUrl );
			
			$sources = [];
			foreach ( $mqWithWidth as $mediaQuery => $widthToResize ) {
				$mediaQuery = is_string( $mediaQuery) && ! empty( $mediaQuery ) ? $mediaQuery : '';
				$widthToResize = (int) $widthToResize;
				
				$srcsetItems   = [];
				$srcsetItems[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize ), '1x' );
				if ( $hasDoubleDevicePixelRatio ) {
					$srcsetItems[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize * 2 ), '2x' );
				}
				
				$sources[] = Source::make( $srcsetItems, [], $mediaQuery );
			}
			
			$pictureHtml = Picture::make( $originUrl, $imgAlt, null, null, $sources )->render();
			
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
	 *
	 * @return string
	 */
	public static function imgForPost( $postId, array $mqWithWidth = [], $hasDoubleDevicePixelRatio = true ) {
		$postId = (int) $postId;
		
		if ( ! $postId || ! has_post_thumbnail( $postId ) ) {
			return '';
		}
		
		$imgHtml = '';
		
		try {
			
			$originUrl = get_the_post_thumbnail_url( $postId, 'full' );
			$imgAlt    = esc_attr( strip_tags( get_the_title() ) );
			
			$resizer = Resizer::makeByUrl( $originUrl );
			
			$sizes = $srcset = [];
			foreach ( $mqWithWidth as $mediaQuery => $widthToResize ) {
				$mediaQuery = is_string( $mediaQuery) && ! empty( $mediaQuery ) ? $mediaQuery : '';
				$widthToResize = (int) $widthToResize;
				
				$sizes[] = Size::make( $mediaQuery, "{$widthToResize}px" );
				
				$srcset[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize ), "{$widthToResize}w" );
				if ( $hasDoubleDevicePixelRatio ) {
					$srcset[] = SrcsetItem::makeWithResize( $resizer->setWidth( $widthToResize * 2 ),
						( $widthToResize * 2 ) . 'w' );
				}
			}
			
			
			$imgHtml = Img::make( $originUrl, $imgAlt, null, null, $srcset, $sizes )->render();
			
		} catch ( \Exception $ex ) {
			error_log( "\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n" );
		}
		
		return $imgHtml;
	}
}
