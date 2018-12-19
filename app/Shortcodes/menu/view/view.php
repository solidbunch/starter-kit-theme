<?php

$desktop_args = $mobile_args = $data['atts'];

$desktop_args['menu_class'] = 'desktop-menu';
$mobile_args['menu_class']  = 'mobile-menu';

?>

<nav id="<?php echo $data['atts']["el_id"]; ?>" class="navigation-menu">

	<div class="d-md-block d-lg-none order-3">
		<?php wp_nav_menu( $mobile_args ); ?>
	</div>

	<div class="w-100 order-3">
		<?php wp_nav_menu( $desktop_args ); ?>
	</div>

	<button class="menu-button" type="button">
		<span class="navbar-toggler-icon"></span>
	</button>

</nav>