<?php
	use StarterKit\Helper\Front;
	use StarterKit\Helper\Media;

	get_header();
	the_post();
?>

	<!--
		Start layout
	-->
	<?php do_action( 'StarterKit/layout_start'); ?>

		<?php do_action( 'StarterKit/before_single_post'); ?>

		<article <?php post_class( 'single-article'); ?>>

			<!--
				Post thumbnail
			-->
			<?php
				do_action( 'StarterKit/before_single_post_thumbnail');
				do_action( 'StarterKit/single_post_thumbnail');
				do_action( 'StarterKit/after_single_post_thumbnail');
			?>

			<!--
				Post title
			-->
			<?php
				do_action( 'StarterKit/before_single_post_title');
				do_action( 'StarterKit/single_post_title');
				do_action( 'StarterKit/after_single_post_title');
			?>

			<!--
				Post content
			-->
			<?php
				do_action( 'StarterKit/before_single_post_content');
				do_action( 'StarterKit/single_post_content');
				do_action( 'StarterKit/after_single_post_content');
			?>

		</article>

		<!--
			Post comments
		-->
		<?php
			do_action( 'StarterKit/before_single_post_comments');
			do_action( 'StarterKit/single_post_comments');
			do_action( 'StarterKit/after_single_post_comments');
		?>

		<?php do_action( 'StarterKit/after_single_post'); ?>

		<!--
			Sidebar
		-->
		<?php get_sidebar(); ?>

	<!--
		End layout
	-->
	<?php do_action( 'StarterKit/layout_end'); ?>

<?php get_footer(); ?>
