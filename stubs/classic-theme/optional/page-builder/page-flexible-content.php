<?php

/**
 * Template Name: Flexible Content
 */

use StarterKit\Helper\Utils;

defined('ABSPATH') || exit;

get_header();
?>

<main class="site-main">
    <?php while (have_posts()) :
        the_post(); ?>
        <?php
        $sections = Utils::getPostMetaFw(get_the_ID(), SK_PREFIX . 'page_sections', []);

        if (empty($sections)) :
            ?>
            <div class="container py-5">
                <h1><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($sections as $section) : ?>
                <?php
                $type = $section['_type'] ?? '';

                if (! $type || ! locate_template("template-parts/sections/{$type}.php")) {
                    continue;
                }

                get_template_part("template-parts/sections/{$type}", null, ['section' => $section]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();
