<?php
/**
 * The page template file
 */

use ffblank\helper\front;
use ffblank\helper\utils;

get_header();

the_post(); ?>
	
	<div id="content" class="container">

        <?php

        if ( utils::is_unyson() && function_exists( 'fw_ext_sidebars_get_current_position' ) ) {

            $current_position = fw_ext_sidebars_get_current_position();
            $reversed = $current_position === 'left' ? 'reversed' : '';
        }

        ?>

		<div class="row <?php echo $reversed; ?>">

            <article class="<?php echo front::get_grid_class(4); ?>">

                <h1><?php the_title(); ?></h1>

                <?php the_content(); ?>

            </article>

            <?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer();