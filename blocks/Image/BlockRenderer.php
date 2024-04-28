<?php

namespace StarterKitBlocks\Image;

defined('ABSPATH') || exit;

use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\NotFoundException;
use StarterKit\Helper\Utils;
use Throwable;
use WPRI\ResponsiveImages\Img;
use WPRI\ResponsiveImages\Resizer;
use WPRI\ResponsiveImages\Size;
use WPRI\ResponsiveImages\SrcsetItem;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class BlockRenderer extends BlockAbstract
{
    /**
     * Block server side render callback
     * Used in register block type from metadata
     *
     * @param array  $attributes
     * @param string $content
     * @param object $block
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public static function blockServerSideCallback(array $attributes, string $content, object $block): string
    {
        $templateData = $attrs = [];

        $imgAlt         = !empty($attributes['altText']) ? esc_attr($attributes['altText']) : '';
        $imageClass     = !empty($attributes['imageClass']) ? esc_attr($attributes['imageClass']) : '';
        $fetchPriority  = !empty($attributes['fetchPriority']) ? esc_attr($attributes['fetchPriority']) : 'auto';
        $lazy           = !empty($attributes['loadingLazy']);
        $editorTemplate = !empty($attributes['editorTemplate']);
        $hidpi          = !empty($attributes['hidpi']);

        $attrs['class']         = $imageClass;
        $attrs['fetchpriority'] = $fetchPriority;

        $mainImageId     = !empty($attributes['mainImage']['id']) ? (int)$attributes['mainImage']['id'] : 0;
        $mainImageUrl    = (string)wp_get_attachment_image_url($mainImageId, 'full');
        $mainImageWidth  = !empty($attributes['mainImage']['width']) ? (int)$attributes['mainImage']['width'] : null;
        $mainImageHeight = !empty($attributes['mainImage']['height']) ? (int)$attributes['mainImage']['height'] : null;

        $mqWithWidth = !empty($attributes['srcSet']) && is_array($attributes['srcSet'])
            ? $attributes['srcSet']
            : [];

        if (!$mainImageUrl) {
            return '';
        }

        $templateData['blockClass'] = self::generateBlockClasses($attributes);

        if (Utils::isRestApiRequest() || (is_admin() && !wp_doing_ajax()) || $editorTemplate) {
            $img = Img::make($mainImageUrl, $imgAlt, $mainImageWidth, $mainImageHeight, [], [], $lazy);

            foreach ($attrs as $attrName => $attrValue) {
                $img->setAttr($attrName, $attrValue);
            }

            $templateData['imgHtml'] = $img->render() ?? '';

            return self::loadBlockView('layout', $templateData);
        }

        try {
            $sizes = $srcset = [];

            foreach ($mqWithWidth as $breakpoint => $bpData) {
                $enabled  = !empty($bpData['enabled']);
                $imageId  = !empty($bpData['id']) ? (int)$bpData['id'] : 0;
                $imageUrl = !empty($imageId) ? (string)wp_get_attachment_image_url($imageId, 'full') : $mainImageUrl;

                $bpViewPort = !empty($bpData['viewPort']) && is_numeric($bpData['viewPort'])
                    ? (int)$bpData['viewPort']
                    : null;

                $widthToResize = !empty($bpData['width']) && is_numeric($bpData['width'])
                    ? (int)$bpData['width']
                    : $bpViewPort;

                $heightToResize = !empty($bpData['height']) && is_numeric($bpData['height'])
                    ? (int)$bpData['height']
                    : null;

                // imageUrl, widthToResize are required
                if (!$enabled || !$imageUrl || !$widthToResize) {
                    continue;
                }

                $resizer = Resizer::makeWithUrl($imageUrl);

                $mediaQuery = $bpViewPort ? "(max-width: {$bpViewPort}px)" : '';

                $sizes[] = Size::make($mediaQuery, "{$widthToResize}px");

                $resizer->setWidth($widthToResize);
                $resizer->setHeight($heightToResize);

                $srcset[] = SrcsetItem::makeWithResize($resizer, "{$widthToResize}w");
            }

            if (!empty($srcset)) {
                // Add the original image after the last breakpoint
                // to display by default on screens larger than the last breakpoint
                $sizes[] = Size::make('', "{$mainImageWidth}px");

                $resizer = Resizer::makeWithUrl($mainImageUrl);

                $resizer->setWidth($mainImageWidth);
                $resizer->setHeight($mainImageHeight);

                $srcset[] = SrcsetItem::makeWithResize($resizer, "{$mainImageWidth}w");

                // Add HiDPI 2x size
                if ($hidpi) {
                    $resizer->setWidth($mainImageWidth * 2);
                    $resizer->setHeight($mainImageHeight * 2);

                    $srcset[] = SrcsetItem::makeWithResize($resizer, ($mainImageWidth * 2) . 'w');
                }
            }

            $img = Img::make($mainImageUrl, $imgAlt, $mainImageWidth, $mainImageHeight, $srcset, $sizes, $lazy);

            foreach ($attrs as $attrName => $attrValue) {
                $img->setAttr($attrName, $attrValue);
            }

            $templateData['imgHtml'] = $img->render() ?? '';
        } catch (\Exception $ex) {
            error_log("\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}\nMessage: {$ex->getMessage()}\n");
        }

        return self::loadBlockView('layout', $templateData);
    }
}
