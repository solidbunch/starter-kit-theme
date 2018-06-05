<div class="accordion">

	<?php
		global $_theme_toggle_shortcode_count;
		$_theme_toggle_shortcode_count = 0;
		echo do_shortcode( $data['content'] );
		unset( $_theme_toggle_shortcode_count );
	?>

</div>