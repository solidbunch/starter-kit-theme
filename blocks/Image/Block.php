<?php

namespace StarterKitBlocks\Image;

defined('ABSPATH') || exit;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Handlers\Errors\ErrorHandler;
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
class Block extends BlockAbstract
{
    /**
     * Block assets for editor and frontend
     *
     * @var array
     */
    protected array $blockAssets
        = [
            'editor_script' => [
                'file' => 'index.js',
                'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
            ],
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ],
            'style' => [
                'file' => 'style.css',
                'dependencies' => [],
            ]
        ];

    /**
     * Register block additional arguments including server side render callback
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
        $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
    }

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
    public function blockServerSideCallback(array $attributes, string $content, object $block): string
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

        // Main Image id or Main image url is strongly mandatory
        $mainImageId = !empty($attributes['mainImage']['id']) ? (int)$attributes['mainImage']['id'] : 0;

        if (!empty($mainImageId)) {
            $mainImageUrl = (string)wp_get_attachment_image_url($mainImageId, 'full');
        } else {
            $mainImageUrl = !empty($attributes['mainImage']['url'])
                ? (string)$attributes['mainImage']['url']
                : '';
        }

        $mainImageStartWidth = !empty($attributes['mainImage']['startWidth'])
            ? (int)$attributes['mainImage']['startWidth']
            : null;

        $mainImageWidth = !empty($attributes['mainImage']['width'])
            ? (int)$attributes['mainImage']['width']
            : $mainImageStartWidth;

        $mainImageHeight = !empty($attributes['mainImage']['height'])
            ? (int)$attributes['mainImage']['height']
            : null;

        $mainImageRatio = !empty($attributes['mainImage']['ratio'])
            ? (float)$attributes['mainImage']['ratio']
            : null;

        // Check $mainImageHeight is empty and recalculate it by ratio
        $mainImageHeight = empty(($mainImageHeight)) && !empty($mainImageRatio)
            ? $mainImageWidth / $mainImageRatio
            : $mainImageHeight;

        $mqWithWidth = !empty($attributes['srcSet']) && is_array($attributes['srcSet'])
            ? $attributes['srcSet']
            : [];

        if (!$mainImageUrl) {
            return '';
        }

        $link = !empty($attributes['link']) && is_array($attributes['link'])
            ? $attributes['link']
            : [];

        $templateData['blockClass'] = $this->generateBlockClasses($attributes);
        $templateData['link']       = $link;

        // Show image without SrcSet
        if ((Utils::isRestApiRequest() || (is_admin() && !wp_doing_ajax()) || $editorTemplate) || empty($mainImageId)) {
            $templateData['imgHtml'] = $this->showSimpleImage(
                $mainImageUrl,
                $imgAlt,
                $mainImageWidth,
                $mainImageHeight,
                $lazy,
                $attrs
            );

            return $this->loadBlockView('layout', $templateData);
        }

        // Making resize
        $templateData['imgHtml'] = $this->showImageWithSrcSet(
            $mainImageUrl,
            $imgAlt,
            $mainImageWidth,
            $mainImageHeight,
            $mqWithWidth,
            $hidpi,
            $lazy,
            $attrs
        );

        return $this->loadBlockView('layout', $templateData);
    }

    /**
     * Show image without SrcSet
     * Used for Editor, SVG images, external images added by url
     *
     * @param $mainImageUrl
     * @param $imgAlt
     * @param $mainImageWidth
     * @param $mainImageHeight
     * @param $lazy
     * @param $attrs
     *
     * @return string
     *
     * @throws Throwable
     */
    private static function showSimpleImage(
        $mainImageUrl,
        $imgAlt,
        $mainImageWidth,
        $mainImageHeight,
        $lazy,
        $attrs
    ): string {
        try {
            $img = Img::make($mainImageUrl, $imgAlt, $mainImageWidth, $mainImageHeight, [], [], $lazy);

            foreach ($attrs as $attrName => $attrValue) {
                $img->setAttr($attrName, $attrValue);
            }

            return $img->render() ?? '';
        } catch (Exception $ex) {
            ErrorHandler::handleThrowable($ex);
        }

        return '';
    }

    /**
     * Show image with SrcSet and with full resize options
     *
     * @param $mainImageUrl
     * @param $imgAlt
     * @param $mainImageWidth
     * @param $mainImageHeight
     * @param $mqWithWidth
     * @param $hidpi
     * @param $lazy
     * @param $attrs
     *
     * @return string
     *
     * @throws Throwable
     */
    private function showImageWithSrcSet(
        $mainImageUrl,
        $imgAlt,
        $mainImageWidth,
        $mainImageHeight,
        $mqWithWidth,
        $hidpi,
        $lazy,
        $attrs
    ): string {
        try {
            $sizes = $srcset = [];

            foreach ($mqWithWidth as $bpData) {
                $enabled  = !empty($bpData['enabled']);
                $imageId  = !empty($bpData['id']) ? (int)$bpData['id'] : 0;
                $imageUrl = !empty($imageId) ? (string)wp_get_attachment_image_url($imageId, 'full') : $mainImageUrl;

                $bpViewPort = !empty($bpData['viewPort']) && is_numeric($bpData['viewPort'])
                    ? (int)$bpData['viewPort']
                    : null;

                $bpStartWidth = !empty($bpData['startWidth']) && is_numeric($bpData['startWidth'])
                    ? (int)$bpData['startWidth']
                    : $bpViewPort;

                $widthToResize = !empty($bpData['width']) && is_numeric($bpData['width'])
                    ? (int)$bpData['width']
                    : $bpStartWidth;

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

            // Additional SrcSet options
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

            return $img->render() ?? '';
        } catch (Exception $ex) {
            ErrorHandler::handleThrowable($ex);
        }

        return '';
    }

    /**
     * Register rest api endpoints
     * Runs by abstract constructor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockRestApiEndpoints(): void
    {
    }
}
