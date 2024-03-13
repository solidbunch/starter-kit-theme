<?php

namespace StarterKitBlocks\Image;

defined( 'ABSPATH' ) || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Utils;
use WPRI\ResponsiveImages\Img;
use WPRI\ResponsiveImages\Resizer;
use WPRI\ResponsiveImages\Size;
use WPRI\ResponsiveImages\SrcsetItem;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class BlockRenderer extends BlockAbstract {
    /**
     * Block server side render callback
     * Used in register block type from metadata
     *
     * @param $attributes
     * @param $content
     * @param $block
     *
     * @return string
     */
    public static function blockServerSideCallback( $attributes, $content, $block ): string {
        $imgAlt        = ! empty( $attributes['altText'] ) ? esc_attr( $attributes['altText'] ) : '';
        $className     = ! empty( $attributes['className'] ) ? esc_attr( $attributes['className'] ) : '';
        $fetchPriority = ! empty( $attributes['fetchPriority'] ) ? esc_attr( $attributes['fetchPriority'] ) : 'auto';
        $lazy          = ! empty( $attributes['loadingLazy'] ) ? true : false;

        $attrs['class']         = $className;
        $attrs['fetchpriority'] = $fetchPriority;

        $mainImageId     = ! empty( $attributes['mainImage']['id'] ) ? (int) $attributes['mainImage']['id'] : 0;
        $mainImageUrl    = (string) wp_get_attachment_image_url( $mainImageId, 'full' );
        $mainImageWidth  = ! empty( $attributes['mainImage']['width'] ) ? (int) $attributes['mainImage']['width'] : null;
        $mainImageHeight = ! empty( $attributes['mainImage']['height'] ) ? (int) $attributes['mainImage']['height'] : null;

        $mqWithWidth = ! empty( $attributes['srcSet'] ) && is_array( $attributes['srcSet'] )
            ? $attributes['srcSet']
            : [];

        $pixelRatio2x = false;

        if ( ! $mainImageUrl ) {
            return '';
        }

        if ( Utils::isRestApiRequest( 'POST' ) || ( is_admin() && ! wp_doing_ajax() ) ) {
            return "<figure><img src='{$mainImageUrl}' alt=''></img></figure>";
        }

        $imgHtml = '';

        try {
            $sizes = $srcset = [];

            foreach ( $mqWithWidth as $breakpoint => $bpData ) {
                $imageId  = ! empty( $bpData['id'] ) ? (int) $bpData['id'] : 0;
                $imageUrl = (string) wp_get_attachment_image_url( $imageId, 'full' );

                $bp = is_numeric( $bpData['viewPort'] ) && ! empty( $bpData['viewPort'] )
                    ? (int) $bpData['viewPort']
                    : null;

                $widthToResize = is_numeric( $bpData['width'] ) && ! empty( $bpData['width'] )
                    ? (int) $bpData['width']
                    : null;

                $heightToResize = is_numeric( $bpData['height'] ) && ! empty( $bpData['height'] )
                    ? (int) $bpData['height']
                    : null;

                // imageUrl, widthToResize are required
                if ( ! $imageUrl || ! $widthToResize ) {
                    continue;
                }

                $resizer = Resizer::makeWithUrl( $imageUrl );

                $mediaQuery = $bp ? "(max-width: {$bp}px)" : '';

                $sizes[] = Size::make( $mediaQuery, "{$widthToResize}px" );

                $resizer->setWidth( $widthToResize );
                $resizer->setHeight( $heightToResize );

                $srcset[] = SrcsetItem::makeWithResize( $resizer, "{$widthToResize}w" );

                if ( $pixelRatio2x ) {
                    $resizer->setWidth( $widthToResize * 2 );
                    $resizer->setHeight( $heightToResize * 2 );

                    $srcset[] = SrcsetItem::makeWithResize( $resizer, ( $widthToResize * 2 ) . 'w' );
                }
            }

            $img = Img::make( $mainImageUrl, $imgAlt, $mainImageWidth, $mainImageHeight, $srcset, $sizes, $lazy );

            foreach ( $attrs as $attrName => $attrValue ) {
                $img->setAttr( $attrName, $attrValue );
            }

            $imgHtml = $img->render();
        } catch ( \Exception $ex ) {
            error_log( "\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n" );
        }

        $html = $imgHtml ? "<figure>{$imgHtml}</figure>" : '';

        return $html;
    }
}
