<?php
/**
 * Social Login View
 *
 *
 **/

$atts = $data['atts'];

$displayed_icons = array(
	'facebook' => \StarterKit\Helper\Utils::get_option( 'facebook_app_id' ) <> '',
	'twitter'  => \StarterKit\Helper\Utils::get_option( 'twitter_consumer_key' ) <> '',
	'google'   => \StarterKit\Helper\Utils::get_option( 'google_client_id' ) <> '',
);

?>
<div class="shortcode-social-login">

	<?php if ( $displayed_icons['facebook'] ): ?>

		<a href="<?php echo esc_attr( add_query_arg( array(
			'oauth'            => 'facebook',
			'oauth-return-url' => add_query_arg( 'oauth-callback', 'facebook', get_permalink( get_the_ID() ) )
		), site_url( '/' ) ) ); ?>" class="facebook"><i class="fa fa-facebook-official"></i></a>

	<?php endif; ?>

	<?php if ( $displayed_icons['twitter'] ): ?>

		<a href="<?php echo esc_attr( add_query_arg( array(
			'oauth'            => 'twitter',
			'oauth-return-url' => add_query_arg( 'oauth-callback', 'twitter', get_permalink( get_the_ID() ) )
		), site_url( '/' ) ) ); ?>" class="twitter"><i class="fa fa-twitter"></i></a>

	<?php endif; ?>

	<?php if ( $displayed_icons['google'] ): ?>

		<a href="<?php echo esc_attr( add_query_arg( array(
			'oauth' => 'google'
		), site_url( '/' ) ) ); ?>" class="google"><i class="fa fa-google"></i></a>

	<?php endif; ?>

</div>