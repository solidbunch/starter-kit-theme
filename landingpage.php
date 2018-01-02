<?php
/**
 * Template Name: Landing Page
 */
get_header('simple');
?>
<section id="content" class="container">
	<div class="row">
		<div class="col-md-12">
			<?php the_post(); the_content(); ?>
		</div>
	</div>
</section>
<?php
get_footer('simple');
