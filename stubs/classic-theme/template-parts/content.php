<?php

defined('ABSPATH') || exit;

?>
<article <?php post_class('mb-4'); ?>>
    <h1><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()) : ?>
        <div class="mb-3">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
