<?php

namespace StarterKit\Handlers;

/**
 * Custom Menus
 *
 * add support of custom menus positions
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Menu {
	
	/**
	 * Register theme menus
	 **/
	public static function register_menus() {
		
		register_nav_menus( [
			'header_menu'     => esc_html__( 'Header Menu', 'starter-kit' ),
			'bottom_bar_menu' => esc_html__( 'Bottom Bar Menu', 'starter-kit' ),
		] );
	}
	
	//startbootstrapmenu
	
	/**
	 * Fix Bootstrap multilevel menu, replace click to hover (additional function in header-menu.js)
	 *
	 * @param array $atts link attributes
	 * @param object $item menu item
	 * @param object $args item arguments
	 * @param integer $depth current depth
	 *
	 * @return array $atts - link attributes
	 **/
	public static function nav_menu_link_attributes( $atts, $item, $args, $depth ) {
		
		if ( isset( $args->has_children ) && $args->has_children && 0 === $depth && $args->depth > 1 ) {
			$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
		}
		
		if ( isset( $args->has_children ) && $args->has_children && $depth > 0 && $args->depth > 1 ) {
			$atts['href']  = ! empty( $item->url ) ? $item->url : '#';
			$atts['class'] = 'dropdown-item dropdown-toggle';
		}
		
		
		if ( ! empty( $atts['data-toggle'] ) ) {
			unset( $atts['data-toggle'] );
			$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
		}
		if ( ! empty( $atts['aria-haspopup'] ) ) {
			unset( $atts['aria-haspopup'] );
		}
		if ( ! empty( $atts['aria-expanded'] ) ) {
			unset( $atts['aria-expanded'] );
		}
		if ( ! empty( $atts['id'] ) ) {
			unset( $atts['id'] );
		}
		
		return $atts;
	}
	
	/**
	 * Add a button to mobile menu to click to open submenu
	 *
	 * @param string $item_output menu item output
	 * @param object $item menu item
	 * @param integer $depth current depth
	 * @param object $args item arguments
	 *
	 * @return string $item_output menu item output
	 **/
	public static function walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
		if ( isset( $args->has_children ) && $args->has_children && $args->depth > 1 ) {
			$item_output .= '<button  class="btn rh-arrow dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="menu-item-dropdown-' . $item->ID . '">
				<span class="sr-only">' . __( 'Toggle Dropdown', 'starter-kit' ) . '</span>
			</button>';
		}
		
		return $item_output;
	}
	//endbootstrapmenu
}
