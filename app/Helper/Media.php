<?php
namespace StarterKit\Helper;

/**
 * Media Helper
 *
 * Helper functions for work with media objects
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Media {

	/**
	 * Generate image tag with srcset for retina
	 *
	 * @param array $args
	 *
	 * @return string image tag
	 */


	/**
	 * Generate image tag with srcset for retina
	 * @return string image tag
	 **/
	public static function the_img( $image_atts = array(), $func_atts = array() ) {

		$is_queried_post_thumb = false;

		$func_dafault_atts = array(
			'attachment_id' => 0,
			'hdmi' => true,
			'size' => 'full',
			'crop' => false,
			'single' => true,
			'upscale' => false,
		);

		$func_atts = wp_parse_args( $func_atts, $func_dafault_atts );

		if ( ! class_exists( 'Aq_Resize' )) {
			require_once get_template_directory() . '/vendor/aq_resizer/aq_resizer.php';
		}

		if ( ( empty($image_atts['src']) && empty($func_atts['attachment_id']) ) or ( !empty($image_atts['src']) &&  $image_atts['src'] ===  get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) ) {

			$is_queried_post_thumb = true;
			$func_atts['attachment_id'] = get_post_thumbnail_id( get_the_ID() );
		}

		$attachment_data['url'] = wp_get_attachment_image_url( $func_atts['attachment_id'], $func_atts['size'] );

		$attachment_data['alt'] = get_post_meta( $func_atts['attachment_id'], '_wp_attachment_image_alt', true ) ? get_post_meta( $func_atts['attachment_id'], '_wp_attachment_image_alt', true ) : '';

		$default_attrs = array(
			'src'    => $attachment_data['url'] ? $attachment_data['url'] : '',
			'width'  => 0,
			'height' => 0,
			'title'  => '',
			'alt'    => $is_queried_post_thumb ? strip_tags( get_the_title() ) : $attachment_data['alt'],
			'id'     => '',
			'class'  => '',
		);

		$image_atts = wp_parse_args( $image_atts, $default_attrs );


		if (empty($image_atts['src'])) {
			return;
		}

		$orig_src = $image_atts['src'];
		// SVG
		$is_svg = utils::is_attachment_svg( $func_atts['attachment_id'],  $image_atts['src'] );

		if ( !empty($image_atts['data-width']) && !empty($image_atts['data-height']) ) {
			$src = aq_resize( $image_atts['src'] , absint( $image_atts['data-width'] ), absint( $image_atts['data-height'] ), $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );
		} else {
			$src = aq_resize( $image_atts['src'] , absint( $image_atts['width'] ), absint( $image_atts['height'] ), $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );
		}


		if ( empty($src) || $is_svg ) {
			$image_atts['src'] = esc_url( $image_atts['src'] );
		} else {
			$image_atts['src'] = esc_url( $src );
		}

		if ( filter_var( $func_atts['hdmi'], FILTER_VALIDATE_BOOLEAN ) && ! $is_svg ) {

			if ( !empty($image_atts['data-width']) && !empty($image_atts['data-height']) ) {
				$double_width = ! is_null( $image_atts['data-width'] ) ? absint( $image_atts['data-width'] ) * 2 : null;
				$double_height = ! is_null( $image_atts['data-height'] ) ? absint( $image_atts['data-height'] ) * 2 : null;
			} else {
				$double_width = ! is_null( $image_atts['width'] ) ? absint( $image_atts['width'] ) * 2 : null;
				$double_height = ! is_null( $image_atts['height'] ) ? absint( $image_atts['height'] ) * 2 : null;
			}

			$src2x = aq_resize( $orig_src, $double_width, $double_height, $func_atts['crop'], (bool) $func_atts['single'], (bool) $func_atts['upscale'] );

			if ( $src2x != false ) {
				$image_atts['srcset'] = esc_url( $src ) . ' 1x, ' . esc_url( $src2x ) . ' 2x';
			}
		}

		$image_atts['width'] = absint( $image_atts['width'] );
		$image_atts['height'] = absint( $image_atts['height'] );

		//Add filter to atts
		$image_atts = apply_filters( 'ff_media_img_html', $image_atts );

		$image_html = '<img ';

		foreach ( $image_atts as $att_name => $image_att ) {
			if (!empty($image_att) || $att_name === 'alt') {
				$image_html .= $att_name . '="' . esc_attr( $image_att ) . '" ';
			}

		}

		$image_html .= '/>';

		echo $image_html;
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
	public static function img_resize( $url, $width, $height, $crop = true ) {
		if ( ! class_exists( 'Aq_Resize' ) ) {
			require_once \get_template_directory() . '/vendor/aq_resizer/aq_resizer.php';
		}

		if ( strpos( $url, 'http' ) !== 0 ) {
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
