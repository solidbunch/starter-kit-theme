<?php
vc_map( array(
	'name'            => esc_html__( 'Tabs', 'starter-kit' ),
	'base'            => 'tabs_child',
	'content_element' => true,
	'as_child'        => array(
		'only' => 'tabs',
	),
	'params'          => array(
		array(
			"type"        => "awesome_icon",
			"heading"     => esc_html__( 'Awesome icon', 'starter-kit' ),
			"param_name"  => "awesome_text",
			"value"       => '',
			"description" => __( "Select awesome icon", 'starter-kit' ),
			'admin_label' => false,

		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'starter-kit' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Text', 'starter-kit' ),
			'param_name'  => 'content',
			'value'       => '',
			'description' => esc_html__( 'Enter your content.', 'starter-kit' )
		),
	),
) );


if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_Tabs_Child extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \StarterKit\Helper\Utils::get_shortcodes_uri( $shortcode );
			$atts          = vc_map_get_attributes( $this->getShortcode(), $atts );

			/** Shortcode data to output **/
			$data = array(
				'atts'    => $atts,
				'content' => $content,
			);

			return Starter_Kit()->View->load( '/../view/child_content', $data, true, $shortcode_dir );

		}

	}

}


?>
