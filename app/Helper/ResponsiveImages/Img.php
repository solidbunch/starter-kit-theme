<?php


namespace StarterKit\Helper\ResponsiveImages;


use StarterKit\Helper\Media;
use StarterKit\Helper\Utils;

class Img {
	
	/**
	 * @var string[]
	 */
	private $imgAttrs = [];
	
	/**
	 * Constructor
	 *
	 * @param string $imgSrc
	 * @param string $imgAlt
	 * @param int|null $width
	 * @param int|null $height
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 */
	public function __construct(
		$imgSrc,
		$imgAlt = '',
		$width = null,
		$height = null,
		array $srcset = [],
		array $sizes = []
	) {
		$srcset = array_filter( $srcset, function ( $value ) {
			return $value instanceof SrcsetItem;
		} );
		$sizes  = array_filter( $sizes, function ( $value ) {
			return $value instanceof Size;
		} );
		
		$this->guard( $imgSrc, $imgAlt, $width, $height, $srcset, $sizes );
		
		$this->imgAttrs['src'] = $imgSrc;
		$this->imgAttrs['alt'] = $imgAlt;
		
		$is_svg = Utils::is_attachment_svg( null, $imgSrc );
		if ( ! $is_svg ) {
			$this->imgAttrs['sizes'] = implode( ', ', $sizes );
			$this->resolveImageInfo( $width, $height );
			$this->resolveSrcset( $srcset );
		} else {
			$this->imgAttrs['data-is_svg'] = 1;
		}
	}
	
	
	
	/**
	 * Static constructor
	 *
	 * @param string $imgSrc
	 * @param string $imgAlt
	 * @param int|null $width
	 * @param int|null $height
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 *
	 * @return self
	 */
	public static function make(
		$imgSrc,
		$imgAlt = '',
		$width = null,
		$height = null,
		array $srcset = [],
		array $sizes = []
	) {
		return new self( $imgSrc, $imgAlt, $width, $height, $srcset, $sizes );
	}
	
	
	
	/**
	 * @param $attrName
	 * @param $attrValue , null - if no value, f.e. "readonly"
	 *
	 * @return $this
	 */
	public function addImgAttr( $attrName, $attrValue ) {
		if ( in_array( strtolower( $attrName ), [ 'src', 'alt', 'srcset', 'sizes' ], true ) ) {
			return $this;
		}
		$this->imgAttrs[ strtolower( $attrName ) ] = $attrValue;
		
		return $this;
	}
	
	
	
	/**
	 * @return string
	 */
	public function render() {
		$imgAttrs = apply_filters( 'StarterKit/media_img/attributes', $this->imgAttrs );
		
		$tagContent = '';
		foreach ( $imgAttrs as $attrName => $attrValue ) {
			if ( empty( $attrValue ) && in_array( $attrName, [ 'srcset', 'sizes' ], true ) ) {
				continue;
			}
			$tagContent .= $attrValue !== null ? $attrName . '="' . esc_attr( $attrValue ) . '" ' : esc_attr( $attrName ) . '" ';
		}
		
		return "<img {$tagContent}>";
	}
	
	
	
	public function __toString() {
		return $this->render();
	}
	
	
	
	/**
	 * @param null $width
	 * @param null $height
	 */
	private function resolveImageInfo( $width = null, $height = null ) {
		if ( $width ) {
			$this->imgAttrs['width'] = (int) $width;
		}
		if ( $height ) {
			$this->imgAttrs['height'] = (int) $height;
		}
		
		if ( empty( $this->imgAttrs['width'] ) || empty( $this->imgAttrs['height'] ) ) {
			$attachInfo = Media::getAttachmentInfoByPath( Media::getAttachmentPathByUrl( $this->imgAttrs['src'] ) );
			
			$this->imgAttrs['width']  = ! empty( $attachInfo[0] ) ? (int) $attachInfo[0] : null;
			$this->imgAttrs['height'] = ! empty( $attachInfo[1] ) ? (int) $attachInfo[1] : null;
		}
	}
	
	
	
	/**
	 * @param array SrcsetItem[] $srcset
	 */
	private function resolveSrcset( array $srcset ) {
		$srcsetHtml            = '';
		$placeholderSrcsetHtml = '';
		
		/* @var SrcsetItem $srcsetItem */
		foreach ( $srcset as $srcsetItem ) {
			// origin srcset
			$srcsetHtml .= $srcsetItem->getDescriptor() ? "{$srcsetItem->getUrl()} {$srcsetItem->getDescriptor()}" : $srcsetItem->getUrl();
			$srcsetHtml .= ', ';
			
			// srcset with placeholders
			$placeholderUrl        = Media::getPlaceholderImage( $srcsetItem->getWidth(), $srcsetItem->getHeight() );
			$placeholderSrcsetHtml .= $srcsetItem->getDescriptor() ? "{$placeholderUrl} {$srcsetItem->getDescriptor()}" : $placeholderUrl;
			$placeholderSrcsetHtml .= ', ';
		}
		$srcsetHtml            = rtrim( $srcsetHtml, ', ' );
		$placeholderSrcsetHtml = rtrim( $placeholderSrcsetHtml, ', ' );
		
		$this->imgAttrs['srcset']                  = $srcsetHtml;
		$this->imgAttrs['data-placeholder_srcset'] = $placeholderSrcsetHtml;
	}
	
	
	
	/**
	 * @param string $imgSrc
	 * @param string $imgAlt
	 * @param int|null $width
	 * @param int|null $height
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 *
	 * @throws \InvalidArgumentException
	 */
	private function guard(
		$imgSrc,
		$imgAlt = '',
		$width = null,
		$height = null,
		array $srcset = [],
		array $sizes = []
	) {
		if ( ! $imgSrc ) {
			throw new \InvalidArgumentException( '[Img]img must have not empty "src"' );
		}
		foreach ( $srcset as $srcsetItem ) {
			if ( ! $srcsetItem instanceof SrcsetItem ) {
				throw new \InvalidArgumentException( '$srcset must contain only SrcsetItem objects' );
			}
		}
		foreach ( $sizes as $size ) {
			if ( ! $size instanceof Size ) {
				throw new \InvalidArgumentException( '$sizes must contain only Size objects' );
			}
		}
	}
}