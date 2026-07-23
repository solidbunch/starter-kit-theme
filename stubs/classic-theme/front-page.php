<?php

defined('ABSPATH') || exit;

get_header();
?>

<main class="site-main">
    <div class="container py-5">
        <?php
        // Project-specific front page markup goes here — bare skeleton by design.
        while (have_posts()) {
            the_post();
            ?>
            <?php the_content(); ?>
            <?php
        }
        ?>
    </div>
</main>

<?php
get_footer();
