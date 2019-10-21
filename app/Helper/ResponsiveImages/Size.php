<?php


namespace StarterKit\Helper\ResponsiveImages;


class Size {
	
	/**
	 * @var string
	 */
	private $media;
	/**
	 * @var string
	 */
	private $widthOfSlot;
	
	/**
	 * Constructor
	 *
	 * @param string $media
	 * @param string $widthOfSlot -  Width of the slot for image
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct( $media, $widthOfSlot ) {
		$this->guard( $media, $widthOfSlot );
		$this->media       = $media;
		$this->widthOfSlot = $widthOfSlot;
	}
	
	
	
	/**
	 * Static constructor
	 *
	 * @param string $media
	 * @param string $widthOfSlot
	 *
	 * @return self
	 * @throws \InvalidArgumentException
	 */
	public static function make( $media, $widthOfSlot ) {
		return new self( $media, $widthOfSlot );
	}
	
	
	
	/**
	 * @return string
	 */
	public function render() {
		return $this->media ? "{$this->media} {$this->widthOfSlot}" : (string) $this->widthOfSlot;
	}
	
	
	
	public function __toString() {
		return $this->render();
	}
	
	
	
	/**
	 * @param string $media
	 * @param string $widthOfSlot -  Width of the slot for image
	 *
	 * @throws \InvalidArgumentException
	 */
	private function guard( $media, $widthOfSlot ) {
		if ( ! $widthOfSlot ) {
			throw new \InvalidArgumentException( 'Size must have not empty Width of the slot' );
		}
	}
}