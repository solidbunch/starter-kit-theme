<header id="top">
	<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">

					<div class="navbar-brand">

						<h1 class="text-primary">
							<a href="<?php echo site_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
						</h1>

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


			</nav>

	</nav>

</header>
