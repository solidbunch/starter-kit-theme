<?php

/**
 * Page Sections part: "text"
 *
 * @var array $args Template args from get_template_part(); `$args['section']` is the row from the
 *                   "Page sections" complex field inside `src/Handlers/Meta/PostMeta/
 *                   PageExampleMeta.php`, read via `Repository\PageExampleRepository::getPageSections()`.
 */

defined('ABSPATH') || exit;

// get_template_part() exposes its third argument only as $args, never as the passed key.
$section = $args['section'] ?? [];

$heading = $section['heading'] ?? '';
$content = $section['content'] ?? '';

?>
<section class="text-section py-5">
    <div class="container">
        <?php if ($heading) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($content) : ?>
            <div class="entry-content"><?php echo wp_kses_post($content); ?></div>
        <?php endif; ?>
    </div>
</section>
