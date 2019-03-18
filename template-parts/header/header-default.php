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
							'menu_class'     => 'mobile-menu'
						)
					);
					?>
				</div>

				<div class="w-100 order-3">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'menu_class'     => 'desktop-menu'
						)
					);
					?>
				</div>

				<button class="menu-button" type="button">
					<span class="navbar-toggler-icon"></span>
				</button>

			</nav>

		</div>

	<?php endif; ?>

</section>
