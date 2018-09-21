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

			<div class="row flex">

				<div class="col-sm-8">

					<h1 id="logo">
						<a href="<?php echo site_url( '/' ); ?>"><?php bloginfo('name'); ?></a>
					</h1>

					<small id="sublogo"><?php bloginfo('description'); ?></small>

				</div>

                <?php

				/*<div class="col-sm-2 text-right">
					<a class="login" href="#"><i class="fa fa-key" aria-hidden="true"></i> Login</a>
				</div>
				<div class="col-sm-2 text-right">
					<button class="btn contact-button">Contact me</button>
				</div>*/

				?>

			</div>

		</div>

	</header>

	<div id="nav">

		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-sm-8">

					<?php

						$location = 'header_menu';

						if ( has_nav_menu($location) ) {

							wp_nav_menu(array(
								'menu' => $location,
								'theme_location' => 'header_menu',
								'container' => 'ul',
								'menu_id' => "nav-menu",
								//'depth'           => 4,
							));
						}

					?>

				</div>

				<div class="col-xs-12 col-sm-4 text-right">

					<?php get_template_part( 'template-parts/search-form' ); ?>

				</div>

			</div>

		</div>

	</div>
	
	<header id="composer-header">
		<?php echo TTT()->view->load_composer_layout( 'header' ); ?>
	</header>