<?php


namespace StarterKit\Helper\ResponsiveImages;


class Resizer {
	
	/**
	 * @var null|string
	 */
	private $originUrl;
	/**
	 * @var null|int
	 */
	private $width;
	/**
	 * @var null|int
	 */
	private $height;
	/**
	 * @var bool
	 */
	private $crop;
	/**
	 * @var bool
	 */
	private $single = false;
	/**
	 * @var bool
	 */
	private $upscale;
	
	/**
	 * Resizer constructor.
	 *
	 * @param string $originUrl
	 * @param null|int $width
	 * @param null|int $height
	 * @param bool $crop
	 * @param bool $upscale
	 */
	public function __construct( $originUrl = null, $width = null, $height = null, $crop = false, $upscale = false ) {
		$this->originUrl = $originUrl;
		$this->width     = $width;
		$this->height    = $height;
		$this->crop      = $crop;
		$this->upscale   = $upscale;
	}
	
	
	/**
	 * @param null $originUrl
	 * @param null|int $width
	 * @param null|int $height
	 * @param bool $crop
	 * @param bool $upscale
	 *
	 * @return self
	 */
	public static function makeByUrl( $originUrl, $width = null, $height = null, $crop = false, $upscale = false ) {
		return new self( $originUrl, $width, $height, $crop, $upscale );
	}
	
	
	/**
	 * @param int $attachmentId
	 * @param null|int $width
	 * @param null|int $height
	 * @param bool $crop
	 * @param bool $upscale
	 *
	 * @return self
	 */
	public static function makeByAttachmentId(
		$attachmentId,
		$width = null,
		$height = null,
		$crop = false,
		$upscale = false
	) {
		$originUrl = wp_get_attachment_image_url( $attachmentId, 'full' );
		
		return new self( $originUrl, $width, $height, $crop, $upscale );
	}
	
	
	
	/**
	 * @param int $postId
	 * @param null|int $width
	 * @param null|int $height
	 * @param bool $crop
	 * @param bool $upscale
	 *
	 * @return self
	 */
	public static function makeByPostId( $postId, $width = null, $height = null, $crop = false, $upscale = false ) {
		$originUrl = get_the_post_thumbnail_url( $postId, 'full' );
		
		return new  self( $originUrl, $width, $height, $crop, $upscale );
	}
	
	
	
	/**
	 * @return bool|string
	 */
	public function process() {
		if ( ! function_exists( 'aq_resize' ) ) {
			require_once get_template_directory() . '/vendor-custom/aq_resizer/aq_resizer.php';
		}
		
		return \aq_resize( $this->originUrl, $this->width, $this->height, $this->crop, $this->single, $this->upscale );
	}
	
	/**
	 * @return null|string
	 */
	public function getOriginUrl() {
		return $this->originUrl;
	}
	
	/**
	 * @param null|string $originUrl
	 *
	 * @return Resizer
	 */
	public function setOriginUrl( $originUrl ) {
		$this->originUrl = $originUrl;
		
		return $this;
	}
	
	/**
	 * @return null|int
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 * @param null|int $width
	 *
	 * @return Resizer
	 */
	public function setWidth( $width ) {
		$this->width = $width;
		
		return $this;
	}
	
	/**
	 * @return null|int
	 */
	public function getHeight() {
		return $this->height;
	}
	
	/**
	 * @param null|int $height
	 *
	 * @return Resizer
	 */
	public function setHeight( $height ) {
		$this->height = $height;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function getCrop() {
		return $this->crop;
	}
	
	/**
	 * @param bool $crop
	 *
	 * @return Resizer
	 */
	public function setCrop( $crop ) {
		$this->crop = $crop;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isUpscale() {
		return $this->upscale;
	}
	
	/**
	 * @param bool $upscale
	 *
	 * @return Resizer
	 */
	public function setUpscale( $upscale ) {
		$this->upscale = $upscale;
		
		return $this;
	}
}
