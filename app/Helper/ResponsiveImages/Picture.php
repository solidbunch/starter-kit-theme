<?php

namespace StarterKit\Helper\ResponsiveImages;

use StarterKit\Helper\Media;
use StarterKit\Helper\Utils;

class Picture {
	
	/**
	 * @var array Source[]
	 */
	private $sources = [];
	/**
	 * @var string[]
	 */
	private $imgAttrs = [];
	/**
	 * @var string[]
	 */
	private $pictureAttrs = [];
	
	/**
	 * Constructor
	 *
	 * @param string $imgSrc
	 * @param string $imgAlt
	 * @param int|null $width
	 * @param int|null $height
	 * @param array $sources Source[]
	 */
	public function __construct( $imgSrc, $imgAlt = '', $width = null, $height = null, array $sources = [] ) {
		$sources = array_filter( $sources, function ( $value ) {
			return $value instanceof Source;
		} );
		
		$this->guard( $imgSrc, $imgAlt, $width, $height, $sources );
		
		$this->imgAttrs['src'] = $imgSrc;
		$this->imgAttrs['alt'] = $imgAlt;
		
		$is_svg = Utils::is_attachment_svg( null, $imgSrc );
		if ( ! $is_svg ) {
			$this->sources = $sources;
			$this->resolveImageInfo( $width, $height );
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
	 * @param array $sources Source[]
	 *
	 * @return self
	 */
	public static function make( $imgSrc, $imgAlt = '', $width = null, $height = null, array $sources = [] ) {
		return new self( $imgSrc, $imgAlt, $width, $height, $sources );
	}
	
	
	
	/**
	 * @param $attrName
	 * @param $attrValue , null - if no value, f.e. "readonly"
	 *
	 * @return $this
	 */
	public function addPictureAttr( $attrName, $attrValue ) {
		$this->pictureAttrs[ strtolower( $attrName ) ] = $attrValue;
		
		return $this;
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
		$sources = implode( "\n\t", $this->sources );
		$sources = $sources ? "{$sources}\n\t" : '';
		
		$img = $this->renderImg();
		
		$tagContent = '';
		foreach ( $this->pictureAttrs as $attrName => $attrValue ) {
			$tagContent .= $attrValue !== null ? $attrName . '="' . esc_attr( $attrValue ) . '" ' : esc_attr( $attrName ) . '" ';
		}
		
		
		return "<picture {$tagContent}>\n\t{$sources}{$img}\n</picture>";
	}
	
	
	
	/**
	 * @return string
	 */
	public function renderImg() {
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
	 * @param string $imgSrc
	 * @param string $imgAlt
	 * @param int|null $width
	 * @param int|null $height
	 * @param array $sources Source[]
	 *
	 * @throws \InvalidArgumentException
	 */
	private function guard( $imgSrc, $imgAlt = '', $width = null, $height = null, array $sources = [] ) {
		if ( ! $imgSrc ) {
			throw new \InvalidArgumentException( '[Picture]img must have not empty "src"' );
		}
		foreach ( $sources as $source ) {
			if ( ! $source instanceof Source ) {
				throw new \InvalidArgumentException( '$sources must contain only Source objects' );
			}
		}
	}
}