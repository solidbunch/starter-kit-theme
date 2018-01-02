<?php
	$with_icon = is_numeric( $atts['image'] );
?>
<div class="benefit-v2 <?php echo $with_icon ? 'with-icon' : ''; ?>">

	<?php if( $with_icon ): ?>
		<div class="image">
		<?php $img = wp_get_attachment_url( $atts['image'] ); ?>
		<img src="<?php echo esc_attr( $img ); ?>" alt="" />
		</div>
	<?php endif; ?>

	<div class="text">
		<?php if( $atts['title'] <> '' ): ?>
			<h4><?php echo wp_kses_post( $atts['title'] ); ?></h4>
		<?php endif; ?>
		<div class="description">
			<?php echo wp_kses_post( $content ); ?>
		</div>
	</div>

</div>
