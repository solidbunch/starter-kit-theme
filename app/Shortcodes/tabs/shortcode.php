<?php

/**
 * Tabs Shortcode
 **/

StarterKit\Helper\OpenFields::open_file( dirname( __FILE__ ) );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_Tabs extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {

			/** Init style \ scripts **/
			$this->enqueue_scripts();

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$atts          = vc_map_get_attributes( $this->getShortcode(), $atts );

			/** Shortcode data to output **/
			$data = array(
				'atts'    => $atts,
				'content' => $content,
			);

			return Starter_Kit()->View->load( '/view/view', $data, true, $shortcode_dir );

		}

		/**
		 *
		 * add styles and scripts
		 *
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			/** scripts **/
			wp_register_script( 'shortcode-tabs',
				\StarterKit\Helper\Utils::get_shortcodes_uri( basename( dirname( __FILE__ ) ) ) . 'assets/js/scripts.js',
				array( 'jquery' ), Starter_Kit()->config['cache_time'] );

			wp_enqueue_script( 'shortcode-tabs' );
			/** styles **/
			wp_enqueue_style( 'shortcode-tabs',
				\StarterKit\Helper\Utils::get_shortcodes_uri( basename( dirname( __FILE__ ) ) ) . 'assets/css/styles.css',
				false, Starter_Kit()->config['cache_time'] );
		}

	}
}
