<?php
	/**
	 * Media helper
	 **/
	class fruitfulblankprefix_media {

		/**
		 * Generate an image
		 **/
		public static function img( $instance = array() ) {
			if( ! class_exists( 'Aq_Resize' )) {
				require_once get_template_directory() . '/core/library/aq_resizer/aq_resizer.php';
			}

			$src = $src2x = $hd_str = $prefix = $suffix = '';

			$instance = wp_parse_args( (array) $instance, array(
				'url' => '',
				'url_hd' => '',
				'id' => null,
				'width' => null,
				'height' => null,
				'crop' => true,
				'hd' => true,
				'lazy' => false,
				'classes' => array(),
				'atts' => array()
			));

			if( empty( $instance['atts'] ) ) {
				$instance['atts'][] = 'alt=""';
			}

			if ( filter_var( $instance['url'], FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $instance['url'] <> '' ) {
					$instance['url'] = $protocol . $instance['url'];
				}
			}

			if ( filter_var( $instance['hd'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $instance['url_hd'], FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $instance['url_hd'] <> '' ) {
					$instance['url_hd'] = $protocol . $instance['url_hd'];
				}
			}

			if( !is_null( $instance['width'] ) || !is_null( $instance['height'] ) ) {

				$src = aq_resize( $instance['url'], $instance['width'], $instance['height'], $instance['crop'] );

				if( !$src ) {
					$src = $instance['url'];
				} else {

					$instance['atts'][] = 'width="' . $instance['width'] . '"';
					if( $instance['height'] <> '' ) {
						$instance['atts'][] = 'height="' . $instance['height'] . '"';
					}
					
				}

				if( $instance['hd'] ) {
					$hd_width = $instance['width'] * 2;
					$hd_height = $instance['height'] != null ? $instance['height'] * 2 : null;
					$src2x = aq_resize( $instance['url_hd'], $hd_width, $hd_height, $instance['crop'] );
					if( !$src2x ) {
						$src2x = $instance['url_hd'];
					} else {
						$hd_str = $instance['url_hd'];
					}
				}

			} else {

				$src = $instance['url'];
				$src2x = '';
				if( $src != $instance['url_hd'] ) {
					$src2x = $instance['url_hd'];
				}

			}

			$src = str_replace( 'https://', '//', str_replace( 'http://', '//', $src ) );
			$src2x = str_replace( 'https://', '//', str_replace( 'http://', '//', $src2x ) );

			$instance['atts'][] = 'data-src="' . esc_attr( $instance['url'] ) . '"';

			if( $instance['lazy'] ) {

				$prefix = '<span class="img-preloader">';
				$suffix = '</span>';

				$instance['classes'][] = 'b-lazy';
				$src = $instance['hd'] && $hd_str <> '' ? $src . '|' . $src2x : $src;
				$instance['atts'][] = 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="';
				$instance['atts'][] = 'data-lazy-src="' . esc_attr( $src ) . '"';

			} else {
				$instance['atts'][] = 'src="' . esc_attr( $src ) . '"';
				if( $instance['hd'] && $src2x <> '' ) {
					$instance['atts'][] = 'data-at2x="' . esc_attr( $src2x ) . '"';
				} else {
					$instance['atts'][] = 'data-no-retina';
				}

			}

			if( is_numeric( $instance['id'] ) ) {
				$instance['atts'][] = 'srcset="' . wp_get_attachment_image_srcset( $instance['id'], 'full' ) . '"';
			}

			return $prefix . '<img class="' . implode( ' ', $instance['classes'] ) . '" ' . implode( ' ', $instance['atts'] ) . ' />' . $suffix;

		}

		/**
		 * Resize image
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
