<?php
/**
 * The page template file
 */

use StarterKit\Helper\Front;
use StarterKit\Helper\Utils;

get_header();

the_post(); ?>
	
	<div id="content" class="container pt-5">
		
		<?php
		$reversed = '';
		if ( Utils::is_unyson() && function_exists( 'fw_ext_sidebars_get_current_position' ) ) {
			
			$current_position = fw_ext_sidebars_get_current_position();
			$reversed         = $current_position === 'left' ? 'reversed' : '';
		}
		
		?>
		
		<div class="row <?php echo $reversed; ?>">
			
			<article class="<?php echo Front::get_grid_class( 4 ); ?>">
				
				<h1><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
			
			</article>
			
			<?php get_sidebar(); ?>
		
		</div>
	
	</div>

<?php get_footer();