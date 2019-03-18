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
							<div class="col-md-6 my-auto copyright"><?php echo \StarterKit\Helper\Utils::get_option( 'bottom_bar_text' ); ?></div>
							<nav class="col-md-6 links">

								<?php

									wp_nav_menu(array(
										'menu' => 'bottom_bar_menu',
										'depth' => 1
									));

								?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
