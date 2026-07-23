<?php

/**
 * Template Name: Example Page
 * Template Post Type: page
 *
 * ONE template composing both kinds of Carbon Fields data through PageExampleRepository:
 * fixed fields (hero + intro) hand-placed here, then the flexible "Page sections" builder
 * dispatched to template-parts/sections/{type}.php. The template never reads Carbon Fields
 * directly — every value comes from the Repository.
 */

defined('ABSPATH') || exit;

use StarterKit\Repository\PageExampleRepository;

get_header();
the_post();

$postId = get_the_ID();

$heroArgs = [
    'title'    => PageExampleRepository::getHeroTitle($postId),
    'subtitle' => PageExampleRepository::getHeroSubtitle($postId),
];

$intro    = PageExampleRepository::getIntro($postId);
$sections = PageExampleRepository::getPageSections($postId);
?>

<?php get_template_part('template-parts/page-hero', '', $heroArgs); ?>

<?php if ($intro) { ?>
    <section class="section-page-intro">
        <div class="container py-5">
            <div class="entry-content"><?php echo wp_kses_post($intro); ?></div>
        </div>
    </section>
<?php } ?>

<?php
foreach ($sections as $section) {
    $type = $section['_type'] ?? '';

    if ($type === '' || !locate_template("template-parts/sections/{$type}.php")) {
        continue;
    }

    get_template_part("template-parts/sections/{$type}", '', ['section' => $section]);
}
?>

<?php
get_footer();
