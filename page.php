<?php
	/**
	 * The page template file
	 */
	use StarterKit\Helper\Front;
	use StarterKit\Helper\Utils;

	get_header();
	the_post();
?>

	<!--
		Start layout
	-->
	<?php do_action( 'StarterKit/layout_start'); ?>

		<?php do_action( 'StarterKit/before_single_post'); ?>

		<article <?php post_class(); ?>>

			<!--
				Page title
			-->
			<?php
				do_action( 'StarterKit/before_single_post_title');
				do_action( 'StarterKit/single_post_title');
				do_action( 'StarterKit/after_single_post_title');
			?>

			<!--
				Page content
			-->
			<?php
				do_action( 'StarterKit/before_single_post_content');
				do_action( 'StarterKit/single_post_content');
				do_action( 'StarterKit/after_single_post_content');
			?>

			<!--
				Page comments
			-->
			<?php
				do_action( 'StarterKit/before_single_post_comments');
				do_action( 'StarterKit/single_post_comments');
				do_action( 'StarterKit/after_single_post_comments');
			?>

		</article>

		<?php do_action( 'StarterKit/after_single_post'); ?>

		<!--
			Sidebar
		-->
		<?php get_sidebar(); ?>

	<!--
		End layout
	-->
	<?php do_action( 'StarterKit/layout_end'); ?>

<?php get_footer();
