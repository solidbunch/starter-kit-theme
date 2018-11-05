<?php
namespace param;

awesome_box::get_instance();

/**
 * Class awesome_box
 *
 * @since 1.0
 */
class awesome_box {

	/**
	 * The single instance of the class
	 * @var awesome_box
	 */

	protected static $instance = null;

	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new awesome_box();
		}

		return self::$instance;
	}

	/**
	 * autoload function
	 *
	 */
	private function __construct() {

		/** init param **/
		if ( function_exists( 'vc_add_shortcode_param' ) ) {

			vc_add_shortcode_param( 'awesome_icon', array( $this, 'awesome_icon_settings' ) );

		} else {

			if ( function_exists( 'add_shortcode_param' ) ) {

				add_shortcode_param( 'awesome_icon', array( $this, 'awesome_icon_settings' ) );

			}
		}

		/** init scripts**/
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * awesome icon settings
	 *
	 * @param $settings array
	 * @param $value array
	 *
	 * @return bool|mixed|string
	 * @throws Exception
	 * @throws \Exception
	 */
	public function awesome_icon_settings( $settings, $value ) {

		$param_dir = dirname( __FILE__ );

		/** Shortcode data to output **/
		$data = array(
			'settings' => $settings,
			'value'    => $value,
		);

		return FFBLANK()->view->load( '/view/view', $data, true, $param_dir );
	}

	/**
	 * add styles and scripts
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		/** styles **/
		wp_enqueue_style( 'shortcode-tabs',
			\ffblank\helper\utils::get_param_uri( basename( dirname( __FILE__ ) ) ) . 'assets/css/style.css', false,
			FFBLANK()->config['cache_time'] );

		/** scripts **/
		wp_enqueue_script( 'param-awesome',
			\ffblank\helper\utils::get_param_uri( basename( dirname( __FILE__ ) ) ) . 'assets/js/scripts_awesome.js',
			array( 'jquery' ), FFBLANK()->config['cache_time'] );

	}

}

?>
