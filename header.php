<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header id="top-bar">

	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div class="text">
					<span class="title"><?php echo fw_get_db_settings_option( 'top_bar_call_us_text'); ?></span>
					<span class="phone"><?php echo fw_get_db_settings_option( 'top_bar_phone_number'); ?></span>
				</div>

				<div class="clearfix"></div>

			</div>
		</div>
	</div>

</header>

<div id="header-scroll-space"></div>
<header id="header">

	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php get_template_part('template-parts/logo'); ?>

				<nav id="header-menu">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'header_menu',
							'fallback_cb' => false,
							'container' => ''
						));
					?>

				<button id="mobile-menu-toggler" class="hamburger hamburger--collapse" type="button">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</button>

				</nav>

				<div class="clearfix"></div>

			</div>
		</div>
	</div>

</header>

<?php
	$disable_particles_header = is_page() ? filter_var( fw_get_db_post_option( get_the_ID(), 'disable_particles_header' ), FILTER_VALIDATE_BOOLEAN ) : false;
	if( is_singular('post') ) {
		$disable_particles_header = true;
	}
	if( ! $disable_particles_header ):
?>
<header id="page-header">
	<div class="particles">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if( is_page() || is_singular() ): ?>
						<h1><?php the_title(); ?></h1>
					<?php elseif( is_404() ): ?>
						<h1><?php esc_html_e( 'ERROR 404', 'bvc'); ?></h1>
					<?php elseif( is_search() ): ?>
						<h1><?php esc_html_e( 'SEARCH RESULTS', 'bvc'); ?></h1>
					<?php elseif( is_home() ): ?>
						<h1><?php esc_html_e( 'NEWS', 'bvc'); ?></h1>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</header>
<?php endif; ?>

<?php
	$disable_breadcrumbs = is_page() ? filter_var( fw_get_db_post_option( get_the_ID(), 'disable_breadcrumbs' ), FILTER_VALIDATE_BOOLEAN ) : false;
	if( ! $disable_breadcrumbs && function_exists( 'fw_ext_get_breadcrumbs' ) ):
?>
<header id="breadcrumbs" class="container">
	<div class="row">
		<div class="col-md-12">
			<?php echo fw_ext_get_breadcrumbs( '/'); ?>
		</div>
	</div>
</header>
<?php endif;
