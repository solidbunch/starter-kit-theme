<?php get_header(); ?>

<section id="content" class="container">
	<div class="row">
		<article class="<?php echo bvc_front::get_grid_class(); ?>">

			<h2 class="align-center">
				<?php esc_html_e( 'Unfortunately, we can not find requested page.', 'bvc'); ?>
				<br/>
				<?php esc_html_e( 'Try to find something else using a form below.', 'bvc'); ?>
			</h2>

			<?php get_search_form(); ?>

		</article>

	</div>
</section>

<?php get_footer();