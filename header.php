<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="main-wrapper">

	<header id="top">

		<div class="container">

			<nav class="navbar">

				<div class="navbar-collapse w-100 order-1 order-md-0 dual-collapse2">

					<div class="navbar-brand">

						<a href="<?php echo site_url( '/' ); ?>">
							<h1><?php bloginfo('name'); ?></h1>
						</a>

						<small><?php bloginfo('description'); ?></small>

					</div>

				</div>

			</nav>

		</div>

	</header>

	<section class="bg-dark">

		<div class="container">

			<nav id="navigation" class="navbar navbar-expand-md">

				<div class="mx-auto order-0">

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
						<span class="navbar-toggler-icon"></span>
					</button>

				</div>

				<div class="navbar-collapse collapse w-100 order-3 dual-collapse2 row">

					<?php

					$location = 'header_menu';

					if ( has_nav_menu($location) ) {

						wp_nav_menu(array(
							'menu' => $location,
							'theme_location' => 'header_menu',
							'container' => 'ul',
							'menu_id' => "nav-menu",
							'menu_class' => '',
							'items_wrap' => '<div class="col-sm-9"><ul id="%1$s" class="navbar-nav %2$s">%3$s</ul></div>',
							'walker' => new \ffblank\controller\walker_bootstrap()
							//'depth'           => 4,
						));
					}

					?>

					<div class="col-sm-3">

						<?php get_template_part( 'template-parts/search-form' ); ?>

					</div>

				</div>

			</nav>

		</div>

	</section>
	
	<section id="composer-header">
		<?php echo FFBLANK()->view->load_composer_layout( 'header' ); ?>
	</section>