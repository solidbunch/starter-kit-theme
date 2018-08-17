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
	
	<header id="header">
		<div class="container">
			<div class="row align-items-center">
				
				<div class="col-lg-3 header-logo-container">
					<a class="logo" href="<?php echo site_url( '/' ); ?>">
						<!-- Logo Image Here -->
						Logo
					</a>

					<!--
						Mobile Menu Hamburger Link
					-->
					<a href="javascript:;" id="mobile-menu-toggler" class="hamburger">
						<div class="hamburger-box">
							<div class="hamburger-inner"></div>
						</div>
					</a>

				</div>
				
				<div class="col-lg-9 header-menu-container">
					
					<?php
					
						wp_nav_menu( array(
							'menu'            => 'header_menu',
							'theme_location'  => 'header_menu',
							'container'       => 'div',
							'menu_id'         => false,
							//'depth'           => 4,
						) );
					
					?>

				</div>
			
			</div>
		</div>
	
	</header>
	
	<header id="composer-header">
		<?php echo FFBLANK()->view->load_composer_layout( 'header' ); ?>
	</header>