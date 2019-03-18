<?php get_header(); ?>

	<?php do_action( 'StarterKit/layout_start'); ?>

		<?php
			do_action( 'StarterKit/before_page_404_content');
			do_action( 'StarterKit/page_404_content');
			do_action( 'StarterKit/after_page_404_content');
		?>

	<?php do_action( 'StarterKit/layout_end'); ?>

<?php get_footer(); ?>
