<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Utils;

/**
 *  Setup Theme handlers
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class SetupTheme {
	
	/**
	 * Add theme translation support
	 **/
	public static function load_theme_textdomain() {
		load_theme_textdomain( 'starter-kit', get_template_directory() . '/languages' );
	}
	
	/**
	 * Add theme support
	 **/
	public static function add_theme_support() {
		add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		//add_theme_support( 'automatic-feed-links' );
/*		add_theme_support( 'starter-content', [
			'options'     => '',
			'theme_mods'  => '',
			'widgets'     => '',
			'nav_menus'   => '',
			'attachments' => '',
			'posts'       => '',
		] );*/
		//add_theme_support( 'align-wide' ); //Gutenberg images wide
		//remove_theme_support( 'core-block-patterns' );
	}
	
	/**
	 * Register theme sidebars
	 **/
	public static function register_sidebars() {
		
		register_sidebar( [
			'name'          => esc_html__( 'Left Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Right Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Shop Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-shop',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Footer Col 1 Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-footer-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Footer Col 2 Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-footer-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Footer Col 3 Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-footer-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
		
		register_sidebar( [
			'name'          => esc_html__( 'Footer Col 4 Sidebar', 'starter-kit' ),
			'id'            => 'sidebar-footer-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
	}
	
	/**
	 * Filtering image sizes by theme settings
	 **/
	public static function filter_image_sizes( $image_sizes ) {
		$sizes_for_disabling = Utils::get_option_fw( 'disable_img_sizes', [] );
		
		foreach ( $image_sizes as $index => $image_size ) {
			if ( in_array( $image_size, $sizes_for_disabling, true ) ) {
				unset( $image_sizes[ $index ] );
			}
		}
		
		return $image_sizes;
	}
}
