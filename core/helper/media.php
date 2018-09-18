<?php

namespace ttt\helper;

/**
 * Media helper
 **/
class media {
	
	/**
	 * Generate image tag with srcset for retina
	 * @return string image tag
	 **/
	public static function img( $args = array() ) {
		
		if ( ! class_exists( 'Aq_Resize' ) ) {
			require_once \get_template_directory() . '/vendor/aq_resizer/aq_resizer.php';
		}
		
		$image_atts = array();
		
		$is_queried_post_thumb = (!empty($args['url']) && ( \get_the_post_thumbnail_url( \get_the_ID(), 'full' ) === $args['url']));
		
		$default_args = array(
			'url'    => \ttt\helper\utils::sanitize_uri( \get_the_post_thumbnail_url( \get_the_ID(), 'full' ) ),
			'width'  => 800,
			'height' => 400,
			'crop'   => true,
			'hdmi'   => true,
			'title'  => $is_queried_post_thumb ? \get_the_post_thumbnail_caption( \get_the_ID() ) : '',
			'alt'    => $is_queried_post_thumb ? \get_post_meta( \get_post_thumbnail_id( \get_the_ID() ), '_wp_attachment_image_alt', true ) : '',
			'id'     => '',
			'class'  => '',
			'attachment_id' => $is_queried_post_thumb ? \get_post_thumbnail_id( \get_the_ID() ) : 0
		);
		
		$args = wp_parse_args( $args, $default_args );
		
		// SVG
		$is_svg = \ttt\helper\utils::is_attachment_svg( $args['attachment_id'],  $args['url'] );
				
		$src = \aq_resize( \ttt\helper\utils::sanitize_uri( $args['url'] ), \absint( $args['width'] ), \absint( $args['height'] ), (bool) $args['crop'] );
		
		if ( $src == false || $is_svg ) {
			$image_atts[] = 'src="' . \esc_url( $args['url'] ) . '"';
			$src          = $args['url'];
		} else {
			$image_atts[] = 'src="' . \esc_url( $src ) . '"';
		}
		
		if ( filter_var( $args['hdmi'], FILTER_VALIDATE_BOOLEAN ) && ! $is_svg ) {
			
			$double_height = ! is_null( $args['height'] ) ? \absint( $args['height'] ) * 2 : null;
			
			$src2x = \aq_resize( $args['url'], \absint( $args['width'] ) * 2, $double_height, (bool) $args['crop'] );
			
			if ( $src2x != false ) {
				$image_atts[] = 'srcset="' . \esc_url( $src ) . ' 1x, ' . \esc_url( $src2x ) . ' 2x"';
			}
			
		}
		
		if ( $args['id'] <> '' ) {
			$image_atts[] = 'id="' . \esc_attr( $args['id'] ) . '"';
		}
		
		if ( $args['class'] <> '' ) {
			$image_atts[] = 'class="' . \esc_attr( $args['class'] ) . '"';
		}
		
		if ( $args['title'] <> '' ) {
			$image_atts[] = 'title="' . \esc_attr( $args['title'] ) . '"';
		}
		
		if ( is_numeric( $args['height'] ) ) {
			$image_atts[] = 'height="' . \absint( $args['height'] ) . '"';
		}
		
		$image_atts[] = 'width="' . \absint( $args['width'] ) . '"';
		
		$image_atts[] = 'alt="' . \esc_attr( $args['alt'] ) . '"';
		
		$_img = '<img ' . implode( ' ', $image_atts ) . '>';
		
		if ( ! \TTT()->controller->lazy_load->skip() ) {
			return \TTT()->controller->lazy_load->add_image_placeholders( $_img );
		}
		
		return $_img;
	}
	
	/**
	 * Resize image
	 *
	 * @param $url
	 * @param $width
	 * @param $height
	 * @param bool $crop
	 *
	 * @return string image path
	 */
	public static function img_resize( $url, $width, $height , $crop = true ) {
		if ( ! class_exists( 'Aq_Resize' ) ) {
			require_once \get_template_directory() . '/vendor/aq_resizer/aq_resizer.php';
		}
		
		$src = '';
		
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			$protocol = \is_ssl() ? 'https:' : 'http:';
			if ( $url <> '' ) {
				$url = $protocol . $url;
			}
		}
		
		$src = \aq_resize( $url, $width, $height, $crop );
		
		if ( ! $src ) {
			$src = $url;
		}
		
		return $src;
		
	}
	
	/**
	 * Echo image SRC based on file type
	 *
	 * @param array
	 * @param string
	 **/
	public static function image_src( $image, $fallback = '' ) {
		
		if ( is_array( $image ) && ! empty( $image ) ) {
			
			$file = \get_attached_file( $image['attachment_id'] );
			$info = pathinfo( $file );
			
			if ( $info['extension'] == 'svg' ) {
				echo '<img src="' . \esc_attr( $image['url'] ) . '" class="image-svg" />';
			} else {
				echo '<img src="' . \esc_attr( $image['url'] ) . '" />';
			}
			
		} elseif ( is_numeric( $image ) ) {
			
			$url  = \wp_get_attachment_url( $image );
			$file = \get_attached_file( $image );
			$info = pathinfo( $file );
			
			if ( $info['extension'] == 'svg' ) {
				echo '<img src="' . \esc_attr( $url ) . '" class="image-svg" />';
			} else {
				echo '<img src="' . \esc_attr( $url ) . '" />';
			}
			
		} elseif ( $fallback <> '' ) {
			echo '<img src="' . \esc_attr( $fallback ) . '" class="image-svg" />';
		}
		
	}
	
}
