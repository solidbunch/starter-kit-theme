<?php

defined('ABSPATH') || exit;

/**
 * Reusable hero + breadcrumbs partial for dedicated page templates.
 *
 * Shared by any page-{slug}.php / Template Name: template that needs the same title +
 * breadcrumbs header — call it as get_template_part('template-parts/page-hero', '', $args)
 * with $args built from that page's own Repository getters, never fetched here directly.
 *
 * @var array $args {
 *     @type string $title
 *     @type string $subtitle
 * }
 */

$title    = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
?>
<section class="section-page-hero">
    <div class="container py-5">
        <?php if (function_exists('yoast_breadcrumb')) { ?>
            <div class="page-hero-breadcrumbs">
                <?php yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>'); ?>
            </div>
        <?php } ?>

        <?php if ($title) { ?>
            <h1 class="page-hero-title"><?php echo esc_html($title); ?></h1>
        <?php } ?>

        <?php if ($subtitle) { ?>
            <div class="page-hero-subtitle"><?php echo wp_kses_post($subtitle); ?></div>
        <?php } ?>
    </div>
</section>
