<?php


namespace StarterKit\Helper\ResponsiveImages;


use StarterKit\Handlers\LazyLoad;
use StarterKit\Helper\Media;
use StarterKit\Helper\Utils;


class SrcsetItem {
	
	/**
	 * @var string
	 */
	private $url;
	/**
	 * @var string
	 */
	private $descriptor;
	/**
	 * @var int|null Pixel width for placeholder
	 */
	private $width;
	/**
	 * @var int|null Pixel height for placeholder
	 */
	private $height;
	/**
	 * @var bool
	 */
	private $skipLazyLoad;
	
	
	/**
	 * Constructor
	 *
	 * @param string $url
	 * @param string $descriptor
	 * @param int|null Pixel width for placeholder
	 * @param int|null Pixel height for placeholder
	 * @param bool $skipLazyLoad
	 */
	public function __construct( $url, $descriptor = '', $width = null, $height = null, $skipLazyLoad = false ) {
		$this->guard( $url, $descriptor, $width, $height );
		$this->url        = $url;
		$this->descriptor = $descriptor;
		
		$this->skipLazyLoad = (bool) $skipLazyLoad || LazyLoad::skip();
		
		$is_svg = Utils::is_attachment_svg( null, $url );
		if ( ! $is_svg ) {
			$this->resolveImageInfo( $width, $height );
		}
	}
	
	
	
	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}
	
	
	/**
	 * @return string
	 */
	public function getDescriptor() {
		return $this->descriptor;
	}
	
	
	/**
	 * @return int|null
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 * @return int|null
	 */
	public function getHeight() {
		return $this->height;
	}
	
	
	
	/**
	 * Static constructor
	 *
	 * @param string $url
	 * @param string $descriptor
	 * @param int|null Pixel width for placeholder
	 * @param int|null Pixel height for placeholder
	 * @param bool $skipLazyLoad
	 *
	 * @return self
	 */
	public static function make( $url, $descriptor = '', $width = null, $height = null, $skipLazyLoad = false ) {
		return new self( $url, $descriptor, $width, $height, $skipLazyLoad );
	}
	
	
	
	/**
	 * @param Resizer $resizer
	 * @param string $descriptor
	 * @param bool $skipLazyLoad
	 *
	 * @return self
	 */
	public static function makeWithResize( Resizer $resizer, $descriptor = '', $skipLazyLoad = false ) {
		$is_svg = Utils::is_attachment_svg( null, $resizer->getOriginUrl() );
		if ( $is_svg ) {
			return new self( $resizer->getOriginUrl(), $descriptor, null, null, $skipLazyLoad );
		}
		$resultData   = $resizer->process();
		$resultUrl    = ! empty( $resultData[0] ) ? $resultData[0] : null;
		$resultWidth  = ! empty( $resultData[1] ) ? $resultData[1] : null;
		$resultHeight = ! empty( $resultData[2] ) ? $resultData[2] : null;
		
		return new self( $resultUrl, $descriptor, $resultWidth, $resultHeight, $skipLazyLoad );
	}
	
	
	
	/**
	 * @param null $width
	 * @param null $height
	 */
	private function resolveImageInfo( $width = null, $height = null ) {
		if ( $width ) {
			$this->width = (int) $width;
		}
		if ( $height ) {
			$this->height = (int) $height;
		}
		
		if (
			( ! $this->width || ! $this->height )
			&&
			! $this->skipLazyLoad
		) {
			$attachInfo   = Media::getAttachmentInfoByPath( Media::getAttachmentPathByUrl( $this->url ) );
			$this->width  = ! empty( $attachInfo[0] ) ? (int) $attachInfo[0] : null;
			$this->height = ! empty( $attachInfo[1] ) ? (int) $attachInfo[1] : null;
		}
	}
	
	
	
	/**
	 * @param string $url
	 * @param string $descriptor
	 * @param int|null Pixel width for placeholder
	 * @param int|null Pixel height for placeholder
	 *
	 * @throws \InvalidArgumentException
	 */
	private function guard( $url, $descriptor = '', $width = null, $height = null ) {
		if ( ! $url ) {
			throw new \InvalidArgumentException( 'Srcset item must have not empty Url' );
		}
	}
}