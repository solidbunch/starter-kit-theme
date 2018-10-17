<?php

$args = $data['atts'];

extract( shortcode_atts( array(
	'css' => ''
), $args ) );

$desktop_args = $mobile_args = $args;

$desktop_args['menu_class'] = 'desktop-menu';
$mobile_args['menu_class']  = 'mobile-menu';

?>

<nav id="<?php echo $args["el_id"]; ?>" class="header-menu">

	<button class="menu-button" type="button">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="d-md-block d-lg-none order-3 header-menu">

		<?php

		if ( has_nav_menu( $args['menu_location'] ) ) {

			wp_nav_menu( $mobile_args );
		}

		?>

	</div>

	<div class="w-100 order-3 header-menu">

		<?php

		if ( has_nav_menu( $args['menu_location'] ) ) {

			wp_nav_menu( $desktop_args );
		}

		?>

	</div>

</nav>