<?php

defined('ABSPATH') || exit;

get_header();
?>

<main class="site-main container py-5">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) :
            the_post(); ?>
            <?php get_template_part('template-parts/content'); ?>
        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Nothing found.', 'starter-kit'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
