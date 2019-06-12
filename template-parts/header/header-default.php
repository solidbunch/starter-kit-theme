<header id="top">

	<div class="container">

		<nav class="navbar">

			<div class="navbar-collapse w-100 order-1 order-md-0 dual-collapse2">

				<div class="navbar-brand">

					<h1 class="text-primary">
						<a href="<?php echo site_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
					</h1>

					<small><?php bloginfo( 'description' ); ?></small>

				</div>

			</div>

		</nav>

	</div>

</header>

<section class="bg-light">

	<?php if ( has_nav_menu( 'header_menu' ) ) : ?>

		<div class="container">

			<nav id="main-nav" class="navigation-menu">

				<div class="d-md-block d-lg-none order-3">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'menu_class'     => 'mobile-menu',
							'walker'          => new wp_bootstrap_navwalker()
						)
					);
					?>
				</div>

				<div class="w-100 order-3">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'menu_class'     => 'desktop-menu',
							'walker'          => new wp_bootstrap_navwalker()
						)
					);
					?>
				</div>

				<button class="menu-button" type="button">
					<span class="navbar-toggler-icon"></span>
				</button>

			</nav>

			<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-header-navbar-collapse" aria-controls="bs-header-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'header_menu',
						'depth'             => 3,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-header-navbar-collapse',
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
					) );
					?>
			</nav>

		</div>

	<?php endif; ?>

</section>
