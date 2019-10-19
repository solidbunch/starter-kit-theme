<?php


namespace StarterKit\Helper\ResponsiveImages;


use StarterKit\Helper\Media;


class Source {
	
	/**
	 * @var string[]
	 */
	private $sourceAttrs = [];
	
	
	/**
	 * Constructor
	 *
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 * @param string $media
	 * @param string $type
	 */
	public function __construct( array $srcset, array $sizes = [], $media = '', $type = '' ) {
		$srcset = array_filter( $srcset, function ( $value ) {
			return $value instanceof SrcsetItem;
		} );
		$sizes  = array_filter( $sizes, function ( $value ) {
			return $value instanceof Size;
		} );
		
		$this->guard( $srcset, $sizes, $media, $type );
		$this->sourceAttrs['media'] = $media;
		$this->sourceAttrs['type']  = $type;
		$this->sourceAttrs['sizes'] = implode( ', ', $sizes );
		$this->resolveSrcset( $srcset );
	}
	
	
	
	/**
	 * Static constructor
	 *
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 * @param string $media
	 * @param string $type
	 *
	 * @return self
	 */
	public static function make( array $srcset, array $sizes = [], $media = '', $type = '' ) {
		return new self( $srcset, $sizes, $media, $type );
	}
	
	
	
	/**
	 * @param $attrName
	 * @param $attrValue , null - if no value, f.e. "readonly"
	 *
	 * @return $this
	 */
	public function addSourceAttr( $attrName, $attrValue ) {
		if ( in_array( strtolower( $attrName ), [ 'src', 'alt', 'srcset', 'sizes', 'media', 'type' ], true ) ) {
			return $this;
		}
		$this->sourceAttrs[ strtolower( $attrName ) ] = $attrValue;
		
		return $this;
	}
	
	
	
	/**
	 * @return string
	 */
	public function render() {
		
		//error_log('$this->sourceAttrs: ' . print_r($this->sourceAttrs, true));
		
		$sourceAttrs = apply_filters( 'StarterKit/media_picture/source_attributes', $this->sourceAttrs );
		
		//error_log("\n".'$sourceAttrs: ' . print_r($sourceAttrs, true));
		
		$tagContent = '';
		foreach ( $sourceAttrs as $attrName => $attrValue ) {
			if ( empty( $attrValue ) && in_array( $attrName, [ 'srcset', 'sizes', 'type' ], true ) ) {
				continue;
			}
			$tagContent .= $attrValue !== null ? $attrName . '="' . esc_attr( $attrValue ) . '" ' : esc_attr( $attrName ) . '" ';
		}
		
		return "<source {$tagContent}>";
	}
	
	
	
	public function __toString() {
		return $this->render();
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
		
		$this->sourceAttrs['srcset']                  = $srcsetHtml;
		$this->sourceAttrs['data-placeholder_srcset'] = $placeholderSrcsetHtml;
	}
	
	
	
	/**
	 * @param array SrcsetItem[] $srcset
	 * @param array Size[] $sizes
	 * @param string $media
	 * @param string $type
	 *
	 * @throws \InvalidArgumentException
	 */
	private function guard( array $srcset, array $sizes = [], $media = '', $type = '' ) {
		if ( ! $srcset ) {
			throw new \InvalidArgumentException( 'Source must have not empty Srcset' );
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