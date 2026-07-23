<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Helper\Utils;

/**
 * "Repository of one page" for the Example Page classic template — the ONLY place its Carbon Fields
 * data is read (see WpPostRepositoryAbstract::getOne()'s docblock "Mainly used in repository of one
 * page"). Exposes typed getters for both the fixed fields (getHeroTitle/getHeroSubtitle/getIntro)
 * and the flexible builder (getPageSections) — same Repository, both kinds of field, so the
 * template never calls Utils:: directly. Paired with Handlers\Meta\PostMeta\PageExampleMeta, which
 * registers the fields this reads back.
 *
 * @package    Starter Kit
 */
class PageExampleRepository extends WpPostRepositoryAbstract
{
    protected static string $metaPrefix = SK_PREFIX . 'page_example__';

    public static function getPostTypeKey(): string
    {
        return 'page';
    }

    // ================== Fixed fields ===================

    public static function getHeroTitle(int $postId): string
    {
        return (string)Utils::getPostMetaFw($postId, static::$metaPrefix . 'hero_title', '');
    }

    public static function getHeroSubtitle(int $postId): string
    {
        return (string)Utils::getPostMetaFw($postId, static::$metaPrefix . 'hero_subtitle', '');
    }

    public static function getIntro(int $postId): string
    {
        return static::getRichTextField($postId, static::$metaPrefix . 'intro');
    }

    // ================== Flexible builder ===================

    /**
     * Raw "Page sections" builder rows. Each row is an assoc array with a `_type` key
     * (hero|text|cta) plus that section type's own fields — see PageExampleMeta.
     *
     * @param int $postId
     *
     * @return array
     */
    public static function getPageSections(int $postId): array
    {
        return (array)Utils::getPostMetaFw($postId, static::$metaPrefix . 'sections', []);
    }
}
