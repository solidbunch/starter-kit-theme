<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="main-wrapper">

		<header id="header" class="header1 po-relative bg-dark">
			<div class="container">
				<nav class="navbar navbar-expand-lg h2-nav">

					<a class="navbar-brand" href="<?php echo site_url('/'); ?>">
						<!-- Logo Image Here -->
					</a>

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header_menu" aria-controls="header_menu" aria-expanded="false" aria-label="<?php _e('Toggle navigation', 'fruitfulblanktextdomain'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<?php 

						require_once get_template_directory() . '/library/bs4navwalker/bs4navwalker.php';

						wp_nav_menu( array(
							'menu'							=> 'header_menu',
							'theme_location'		=> 'header_menu',
							'container'					=> 'div',
							'container_id'			=> 'header_menu',
							'container_class'		=> 'collapse navbar-collapse',
							'menu_id'						=> false,
							'menu_class'				=> 'navbar-nav ml-auto mt-2 mt-lg-0',
							'depth'							=> 2,
							'fallback_cb'				=> 'bs4navwalker::fallback',
							'walker'						=> new bs4navwalker()
						)); 

					?>

				</nav>
			</div>

		</header>

		<header id="composer-header">
			<?php echo FFBLANK()->view->load_composer_layout( 'header'); ?>
		</header>