<?php
	$with_icon = is_numeric( $atts['image'] );
?>
<div class="benefit <?php echo $with_icon ? 'with-icon' : ''; ?>">

	<?php if( $with_icon ): ?>
		<?php $img = wp_get_attachment_url( $atts['image'] ); ?>
		<div class="image" style="background-image: url(<?php echo esc_attr( $img ); ?>)"></div>
	<?php endif; ?>

	<div class="text">
		<h4><?php echo wp_kses_post( $atts['title'] ); ?></h4>
		<div class="description">
			<?php echo wp_kses_post( $content ); ?>
		</div>
	</div>

</div>