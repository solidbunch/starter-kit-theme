<?php

namespace StarterKit;

use StarterKit\Helper\Utils;
use StarterKit\Base\ShortcodesManager;

/**
 * Application Singleton
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
final class App extends AbstractSingleton {
	
	/** @var array */
	private $config;
	
	/** @var ShortcodesManager */
	private $shortcodesManager;
	
	
	protected function __construct() {
		parent::__construct();
	}
	
	
	/**
	 * Run the theme
	 *
	 * @param array $config
	 */
	public function run( array $config ) {
		
		// Load config
		$this->config = $config;
		
		// Main Hooks functionality for the theme
		Base\Hooks::runHooks();
		
		// WPBakery shortcodes functionality
		$this->shortcodesManager = new ShortcodesManager();
		$this->shortcodesManager->init();
		
		// Load widgets
		Utils::autoload_dir( $this->config['widgets_dir'], 1 );
	}
	
	
	public function getConfig(): array {
		return $this->config;
	}
	
	
	public function getShortcodesManager(): ShortcodesManager {
		return $this->shortcodesManager;
	}
}
