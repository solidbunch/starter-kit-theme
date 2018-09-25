<?php get_header(); ?>
	
	<section id="content" class="container">
		<div class="row">
			<article class="col-12">
				
				<h1><?php esc_html_e( 'Unfortunately, we can not find requested page.', 'fruitfulblanktextdomain' ); ?></h1>
				
				<h4><?php esc_html_e( 'Try to find something else using a form below.', 'fruitfulblanktextdomain' ); ?></h4>
				
				<?php get_search_form(); ?>
			
			</article>
		
		</div>
	</section>

<?php get_footer();
