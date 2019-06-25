<?php

namespace StarterKit\Controller;

/**
 * Custom Menus
 *
 * Controller which add support of custom menus positions
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Menu {

	/**
	 * Constructor
	 **/
	public function __construct() {

		// register menus
		add_action( 'after_setup_theme', [ $this, 'register_menus' ] );

		//startbootstrapmenu
		// add wp-bootstrap-navwalker
		require_once get_template_directory() . '/vendor-custom/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';

		add_filter( 'nav_menu_link_attributes', [ $this, 'nav_menu_link_attributes' ], 10, 4 );

		add_filter( 'walker_nav_menu_start_el', [ $this, 'walker_nav_menu_start_el' ], 10, 4 );
		//endbootstrapmenu

		// here we can add custom menu fields, modify admin walkers etc

	}

	/**
	 * Register theme menus
	 **/
	public function register_menus() {

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
	public function nav_menu_link_attributes( $atts, $item, $args, $depth ) {

		if ( isset( $args->has_children ) && $args->has_children && 0 === $depth && $args->depth > 1 ) {
			$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
		}

		if ( isset( $args->has_children ) && $args->has_children && $depth > 0 && $args->depth > 1 ) {
			$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
			$atts['class']         = 'dropdown-item dropdown-toggle';
		}


		if ( !empty( $atts['data-toggle'] ) ) {
			unset( $atts['data-toggle'] );
			$atts['href'] = ! empty( $item->url ) ? $item->url : '#';
		}
		if ( !empty( $atts['aria-haspopup'] ) ) {
			unset( $atts['aria-haspopup'] );
		}
		if ( !empty( $atts['aria-expanded'] ) ) {
			unset( $atts['aria-expanded'] );
		}
		if ( !empty( $atts['id'] ) ) {
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
	public function walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
		if ( isset( $args->has_children ) && $args->has_children && $args->depth > 1 ) {
			$item_output .= '<button  class="btn rh-arrow dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="menu-item-dropdown-' . $item->ID.'">
				<span class="sr-only">' . __( 'Toggle Dropdown', 'starter-kit' ) . '</span>
			</button>';
		}
		return $item_output;
	}
	//endbootstrapmenu

}
