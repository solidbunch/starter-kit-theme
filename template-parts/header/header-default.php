<header id="top" class="bg-light">
	<div class="container">
	<nav class="navbar navbar-expand-lg navbar-light bg-light pl-0 pr-0" role="navigation">

					<div class="navbar-brand">

						<a class="text-primary" href="<?php echo site_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
						<small><?php bloginfo( 'description' ); ?></small>

					</div>

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
						'menu_class'        => 'nav navbar-nav ml-auto',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
					) );
					?>

		<?php
/*		wp_nav_menu([
			'theme_location'  => 'header_menu',
			'container'       => 'div',
			'container_id'    => 'bs-header-navbar-collapse',
			'container_class' => 'collapse navbar-collapse',
			'menu_id'         => false,
			'menu_class'      => 'navbar-nav mr-auto',
			'depth'           => 3,
			'fallback_cb'     => 'bs4navwalker::fallback',
			'walker'          => new bs4navwalker()
		]);*/
		?>


			</nav>

	</nav>
	</div>

</header>
