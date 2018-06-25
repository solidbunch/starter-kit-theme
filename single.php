<?php use ffblank\helper\front;

get_header();
the_post(); ?>
	
	<section id="content" class="container">
		<div class="row">
			<article class="<?php echo front::get_grid_class(); ?>">
				
				<h1><?php the_title(); ?></h1>
				
				<?php get_template_part( 'template-parts/post-data' ); ?>
				
				<?php if ( has_post_thumbnail() ): ?>
					<div class="thumb">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="">
						</a>
					</div>
				<?php endif; ?>
				
				<?php the_content(); ?>
				
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
			
			<?php get_sidebar(); ?>
		
		</div>
	</section>

<?php get_footer();
