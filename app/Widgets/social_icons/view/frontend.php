<?php
$args     = $data['args'];
$instance = $data['instance'];

echo wp_kses_post( $args['before_widget'] );
?>

	<!-- widget title -->
<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

	<?php echo wp_kses_post( $args['before_title'] ); ?>

	<?php echo wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ); ?>

	<?php echo wp_kses_post( $args['after_title'] ); ?>

<?php endif; ?>

	<!-- widget content -->
	<div class="round-social light">

		<?php foreach ( Starter_Kit()->config['social_profiles'] as $k => $v ):
			$link_url = \StarterKit\Helper\Utils::get_option( $k );
			$class_name = str_replace( '_', '-', str_replace( '_url', '', $k ) );
			if ( $link_url <> '' ):
				?>
				<a rel="nofollow" class="link <?php echo esc_attr( $class_name ); ?>" target="_blank"
				   href="<?php echo esc_attr( $link_url ); ?>"><i
						class="<?php echo esc_attr( Starter_Kit()->config['social_icons'][ $k ] ); ?>"></i></a>
			<?php endif; endforeach; ?>

	</div>

<?php
echo wp_kses_post( $args['after_widget'] );
