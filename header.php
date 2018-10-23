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

						<h1 class="text-primary">
							<a href="<?php echo site_url( '/' ); ?>"><?php bloginfo('name'); ?></a>
						</h1>

						<small><?php bloginfo('description'); ?></small>

					</div>

				</div>

			</nav>

		</div>

	</header>

	<section id="composer-header" class="bg-dark">
		<div class="container">
			<?php echo FFBLANK()->view->load_composer_layout( 'header' ); ?>
		</div>
	</section>
