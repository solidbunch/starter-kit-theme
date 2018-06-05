<?php
	$args = $data['args'];
	$instance = $data['instance'];

	echo $args['before_widget'];
?>

	<!-- widget title -->
	<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

		<?php echo $args['before_title']; ?>

			<?php echo apply_filters( 'widget_title', $instance['title'] ); ?>

		<?php echo $args['after_title']; ?>

	<?php endif; ?>

	<!-- widget content -->
	<div class="round-social light">

		<?php foreach( FFBLANK()->config['social_profiles'] as $k=>$v ):
			$link_url = \ffblank\helper\utils::get_option( $k );
			$class_name = str_replace( '_', '-', str_replace( '_url', '', $k ) );
			if( $link_url <> '' ):
		?>
		<a rel="nofollow" class="link <?php echo esc_attr( $class_name ); ?>" target="_blank" href="<?php echo esc_attr( $link_url ); ?>"><i class="<?php echo esc_attr( FFBLANK()->config['social_icons'][ $k ] ); ?>"></i></a>
		<?php endif; endforeach; ?>

	</div>

<?php
	echo $args['after_widget'];