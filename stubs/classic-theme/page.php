<?php

defined('ABSPATH') || exit;

get_header();
?>

<main class="site-main">
    <?php while (have_posts()) :
        the_post(); ?>
        <div class="container py-5">
            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php
get_footer();
