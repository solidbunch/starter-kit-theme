<?php

/**
 * Page Sections part: "cta"
 *
 * @var array $args Template args from get_template_part(); `$args['section']` is the row from the
 *                   "Page sections" complex field inside `src/Handlers/Meta/PostMeta/
 *                   PageExampleMeta.php`, read via `Repository\PageExampleRepository::getPageSections()`.
 */

defined('ABSPATH') || exit;

// get_template_part() exposes its third argument only as $args, never as the passed key.
$section = $args['section'] ?? [];

$heading    = $section['heading'] ?? '';
$buttonText = $section['button_text'] ?? '';
$buttonUrl  = $section['button_url'] ?? '';

?>
<section class="cta py-5 text-center">
    <div class="container">
        <?php if ($heading) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($buttonText && $buttonUrl) : ?>
            <a href="<?php echo esc_url($buttonUrl); ?>" class="btn btn-primary btn-lg">
                <?php echo esc_html($buttonText); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
