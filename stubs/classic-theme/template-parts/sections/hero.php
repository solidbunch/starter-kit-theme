<?php

/**
 * Page Sections part: "hero"
 *
 * @var array $args Template args from get_template_part(); `$args['section']` is the row from the
 *                   "Page sections" complex field inside `src/Handlers/Meta/PostMeta/
 *                   PageExampleMeta.php`, read via `Repository\PageExampleRepository::getPageSections()`.
 */

defined('ABSPATH') || exit;

// get_template_part() exposes its third argument only as $args, never as the passed key.
$section = $args['section'] ?? [];

$title      = $section['title'] ?? '';
$subtitle   = $section['subtitle'] ?? '';
$image      = $section['image'] ?? null;
$buttonText = $section['button_text'] ?? '';
$buttonUrl  = $section['button_url'] ?? '';

?>
<section class="hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <?php if ($title) : ?>
                    <h1><?php echo esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="lead"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <?php if ($buttonText && $buttonUrl) : ?>
                    <a href="<?php echo esc_url($buttonUrl); ?>" class="btn btn-primary">
                        <?php echo esc_html($buttonText); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($image) : ?>
                <div class="col-12 col-lg-6">
                    <?php echo wp_get_attachment_image((int) $image, 'large', false, ['class' => 'img-fluid']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
