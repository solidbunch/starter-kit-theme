<?php
use StarterKit\Helper\{Utils, Front};
?>
<footer id="footer" class="bg-dark text-white">
	<div class="footer4 b-t spacer pt-3">
		<div class="container">
			<div class="row">

				<?php if (is_active_sidebar( 'sidebar-footer-1' )): ?>
				<div class="col-lg-3 col-md-6 m-b-30">
					<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
				</div>
				<?php endif; ?>

				<?php if (is_active_sidebar( 'sidebar-footer-2' )): ?>
				<div class="col-lg-3 col-md-6 m-b-30">
					<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
				</div>
				<?php endif; ?>

				<?php if (is_active_sidebar( 'sidebar-footer-3' )): ?>
				<div class="col-lg-3 col-md-6 m-b-30">
					<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
				</div>
				<?php endif; ?>

				<?php if (is_active_sidebar( 'sidebar-footer-4' )): ?>
				<div class="col-lg-3 col-md-6">
					<?php dynamic_sidebar( 'sidebar-footer-4' ); ?>
				</div>
				<?php endif; ?>

			</div>
			<div id="bottom-bar" class="f4-bottom-bar">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 my-auto copyright"><?php echo Front::text_copyright_year ( Utils::get_option( 'bottom_bar_text' ) ); ?></div>
							<nav class="col-md-6 navbar navbar-dark bg-dark">
								<?php
									wp_nav_menu( [
										'menu' => 'bottom_bar_menu',
										'depth' => 1,
										'container' => false,
										//startbootstrapmenu
										'menu_class'        => 'nav ml-auto',
										'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
										'walker'            => new WP_Bootstrap_Navwalker(),
										//endbootstrapmenu
									] );
								?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
