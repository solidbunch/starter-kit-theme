<?php
use StarterKit\Helper\Utils;
?>
<header id="header" class="bg-light">
	<div class="container">
		<nav class="header-menu navbar navbar-expand-lg navbar-light bg-light <?php if ( Utils::get_option( 'fixed_header' ) ) { ?> fixed-top<?php } else {?> pl-0 pr-0<?php } ?>">

			<div class="navbar-brand">

				<a class="text-primary" href="<?php echo site_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
				<small><?php bloginfo( 'description' ); ?></small>

			</div>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#bs-header-navbar-collapse" aria-controls="bs-header-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<?php
			wp_nav_menu( [
				'theme_location'    => 'header_menu',
				'depth'             => 4,
				'container'         => 'div',
				//startbootstrapmenu
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'bs-header-navbar-collapse',
				'menu_class'        => 'nav navbar-nav ml-auto',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker(),
				//endbootstrapmenu
			] );
			?>
		</nav>
	</div>
</header>
