
	<nav id="<?php echo $data['atts']['el_id']; ?>" class="shortcode-menu flex-row-reverse navbar navbar-expand-lg navbar-light" role="navigation">
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $data['args']['container_id']; ?>" aria-controls="<?php echo $data['args']['container_id']; ?>" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php wp_nav_menu( $data['args'] ); ?>
	</nav>
