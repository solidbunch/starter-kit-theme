<?php

use StarterKit\Helper\Utils;

$args     = $data['args'];
$instance = $data['instance'];

echo wp_kses_post( $args['before_widget'] );
?>
	
	<!-- widget title -->
<?php if ( isset( $instance['title'] ) && $instance['title'] !== '' ) : ?>
	
	<?php echo wp_kses_post( $args['before_title'] ); ?>
	
	<?php echo wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ); ?>
	
	<?php echo wp_kses_post( $args['after_title'] ); ?>

<?php endif; ?>
	
	<!-- widget content -->
	<div class="round-social light">
		
		<?php foreach ( Starter_Kit()->config['social_profiles'] as $option_name => $label ):
			$link_url = Utils::get_option( $option_name );
			$class_name = str_replace( [ '_url', '_' ], [ '', '-' ], $option_name );
			if ( $link_url !== '' ):
				?>
				<a rel="nofollow" class="link <?php echo esc_attr( $class_name ); ?>" target="_blank"
				   href="<?php echo esc_attr( $link_url ); ?>">
					<i class="<?php echo esc_attr( Starter_Kit()->config['social_icons'][ $option_name ] ); ?>"> </i>
				</a>
			<?php endif; endforeach; ?>
	
	</div>

<?php
echo wp_kses_post( $args['after_widget'] );
