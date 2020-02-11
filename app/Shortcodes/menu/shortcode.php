<?php
/**
 * Menu Shortcode
 *
 **/

use StarterKit\Base\Shortcode;
use StarterKit\Helper\View;

if ( ! class_exists( 'StarterKitShortcode_Menu' ) ) {
	class StarterKitShortcode_Menu extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'el_id'           => '',
				'menu'            => '',
				'menu_id'         => '',
				'menu_class'      => '',
				'depth'           => '',
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'classes'         => ''
			], $this->atts( $atts ), $this->shortcode );

			$args = [
				'menu'            => $atts['menu'],
				'menu_id'         => $atts['menu_id'],
				'menu_class'        => $atts['menu_class'],
				'depth'           => $atts['depth'],
				'container'       => $atts['container'],
				'container_class'   => $atts['container_class'],
				'container_id'      => $atts['container_id'],
			];

			//startbootstrapmenu
			$args['menu_class'] = $args['menu_class'] . ' nav navbar-nav ml-auto';
			$args['container'] = $args['container'] ? $args['container'] : 'div';
			$args['container_class'] = $args['container_class'] . ' collapse navbar-collapse pt-3 pb-3';
			$args['container_id'] = $args['container_id'] ? $args['container_id'] : 'navbar-collapse-' . $atts['el_id'];
			$args['fallback_cb'] = 'WP_Bootstrap_Navwalker::fallback';
			$args['walker'] =  new WP_Bootstrap_Navwalker();
			//endbootstrapmenu

			\StarterKit\Helper\Assets::enqueue_style_dist( 'shortcode-' . $this->shortcode . '-style', 'shortcode-' . $this->shortcode . '.css' );

			$data = $this->data( [
				'atts'    => $atts,
				'args'    => $args,
				'content' => $content
			] );
			
			return View::load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}