<?php

	/**
	 * Media helper
	 **/
	class fruitfulblankprefix_media {

		/**
		 * Resize image
		 * @return string image path
		 **/
		public static function img_resize( $url, $width, $height ) {
			if( ! class_exists( 'Aq_Resize' )) {
				require_once get_template_directory() . '/core/library/aq_resizer/aq_resizer.php';
			}

			$src = '';

			if ( filter_var( $url, FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $url <> '' ) {
					$url = $protocol . $url;
				}
			}

			$src = aq_resize( $url, $width, $height, true );

			if( !$src ) {
				$src = $url;
			}

			return $src;

		}

		/**
		 * Echo image SRC based on file type
		 * @param array
		 * @param string
		 **/
		public static function image_src( $image, $fallback = '' ) {

			if( is_array( $image ) && !empty( $image ) ) {

				$file = get_attached_file( $image['attachment_id'] );
				$info = pathinfo( $file );

				if( $info['extension'] == 'svg' ) {
					echo '<img src="' . esc_attr( $image['url'] ) . '" class="image-svg" alt="" />';
				} else {
					echo '<img src="' . esc_attr( $image['url'] ) . '" alt="" />';
				}

			} elseif( is_numeric( $image )) {

				$url = wp_get_attachment_url( $image );
				$file = get_attached_file( $image );
				$info = pathinfo( $file );

				if( $info['extension'] == 'svg' ) {
					echo '<img src="' . esc_attr( $url ) . '" class="image-svg" alt="" />';
				} else {
					echo '<img src="' . esc_attr( $url ) . '" alt="" />';
				}

			} elseif( $fallback <> '' ) {
				echo '<img src="' . esc_attr( $fallback ) . '" class="image-svg" alt="" />';
			}

		}

	}
