<?php

use ttt\helper\front;
use ttt\helper\media;

get_header();
the_post(); ?>
	
	<section id="content" class="container">
		
		<div class="row">

			<div id="posts" class="<?php echo front::get_grid_class(); ?>">

				<div class="row">

					<article <?php post_class('col-md-12'); ?>>
						
						<h1><?php the_title(); ?></h1>
						
						<?php get_template_part( 'template-parts/post-data' ); ?>
						
						<?php if ( has_post_thumbnail() ): ?>
							<div class="thumb">
								<a href="<?php the_permalink(); ?>">
		<!--							<img src="--><?php //echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?><!--" >-->
									<?php
									$thumb_args = array(
										'url'    => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
										'width'  => 800,
										'height' => 400,
										'crop'   => true,
										'hdmi'   => true,
										'title'  => get_the_post_thumbnail_caption( get_the_ID() ),
										'alt'    => get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true ),
										'id'     => '',
										'class'  => '',
										'attachment_id' => get_post_thumbnail_id( get_the_ID() )
									);
									
									echo media::img( $thumb_args );
									?>
								</a>
							</div>
						<?php endif; ?>
						
						<?php
							the_content();
						
							wp_link_pages( array(
								'before'      => '<div class="page-links">' . __( 'Pages:', 'tttextdomain' ),
								'after'       => '</div>',
								'link_before' => '<span class="page-number">',
								'link_after'  => '</span>',
							) );
						?>
						
						<div class="clearfix"></div>
						
						<?php get_template_part( 'template-parts/related-posts' ); ?>
						
						<!--
							Comments
						-->
						
						<?php if ( ! post_password_required() ): ?>
							<div id="comments-block">
								<?php comments_template( '', true ); ?>
							</div>
						<?php endif; ?>
					
					</article>
					

				</div>

			</div>
			
			<?php get_sidebar(); ?>
		
		</div>
	</section>

<?php get_footer();
