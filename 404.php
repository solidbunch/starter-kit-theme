<?php get_header(); ?>

	<?php do_action( 'starter-kit/layout_start'); ?>

		<?php
			do_action( 'starter-kit/before_page_404_content');
			do_action( 'starter-kit/page_404_content');
			do_action( 'starter-kit/after_page_404_content');
		?>

	<?php do_action( 'starter-kit/layout_end'); ?>

<?php get_footer(); ?>
