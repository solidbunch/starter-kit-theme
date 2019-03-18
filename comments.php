<?php
	/**
	 * The template for displaying Comments.
	 */
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * Comments callback function
 **/
if( !function_exists( 'StarterKit_comments_callback') ) {

	function StarterKit_comments_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
			// Display trackbacks differently than normal comments. ?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'starter-kit' ); ?></span> <?php comment_author_link(); ?></div>
			<?php
			break;
			default:
				?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

				<div class="comment-body">

					<?php
						$comment_author = get_userdata( $comment->user_id );
						$author_name = isset( $comment_author->display_name ) ? $comment_author->display_name : get_comment_author( get_comment_ID() );
					?>

					<?php if ( get_option( 'show_avatars' ) ): ?>
						<div class="comment-avatar">
							<?php echo get_avatar( $comment, 70 ); ?>
						</div>
					<?php endif; ?>

					<div class="comment-text">

						<div class="comment-data">
							<span class="comment-time"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) . " " . esc_html__( 'ago', 'starter-kit' ); ?></span>

							<?php
								comment_reply_link(
									array_merge( $args, [
										'add_below'		=> 'comment',
										'reply_text' 	=> esc_html__( 'Reply', 'starter-kit' ),
										'depth'      	=> $depth,
										'before'			=>	'&middot; ',
										'max_depth'  	=> $args['max_depth']
									] ), get_comment_ID(), get_the_ID()
								);
							?>
						</div>

						<h4 class="author-name">
							<?php echo wp_kses_post( $author_name ); ?>
						</h4>

						<?php comment_text(); ?>

						<div class="clearfix"></div>

					</div>

				</div>

				<?php
				break;
		endswitch;
	}

}

?>
<div class="row">
	<div class="col-md-12">

		<!--
			Comments block
		-->
		<div class="indent <?php echo get_option( 'show_avatars' ) ? 'with-avatars' : 'no-avatars'; ?>" id="comments">

			<?php
				$commenter 		= wp_get_current_commenter();
				$req       		= get_option( 'require_name_email' );
				$aria_req  		= ( $req ? " aria-required='true'" : '' );
				$form_classes = '';

				$comment_form_args = [
					'class_submit' 	=> 'button green',
					'class_form' 		=> 'comment-form ' . $form_classes,
					'title_reply' 	=> esc_html__( 'Leave a comment', 'starter-kit' ),
					'comment_field' => '<div class="row"><div class="form-row col-md-12"><textarea class="input-icon-comment" id="comment" placeholder="' . esc_html__( 'Your Comment *', 'starter-kit' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></div>',
					'fields' => apply_filters( 'comment_form_default_fields', [
						'author' 	=> '<div class="row"><div class="form-row col-md-6"><input class="input-icon-user" id="author" name="author" type="text" placeholder="' . esc_html__( 'Your Name *', 'starter-kit' ) . '" value="' . $commenter['comment_author'] . '" size="30"' . $aria_req . ' /></div>',
						'email' 	=> '<div class="form-row col-md-6"><input id="email" class="input-icon-email" name="email" type="text" placeholder="' . esc_html__( 'Email Address *', 'starter-kit' ) . '" value="' . $commenter['comment_author_email'] . '" size="30"' . $aria_req . ' /></div></div>',
						'url' 		=> ''
					]),
					'comment_notes_after' 	=> '',
					'must_log_in' 					=> '<p>' . wp_kses_post( sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'starter-kit' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) ) . '</p>',
					'logged_in_as' 					=> '',
					'comment_notes_before' 	=> '',
					'label_submit' 					=> esc_html__( 'Submit', 'starter-kit' )
				];
			?>

			<?php if ( comments_open() ): ?>

				<h2 class="comments-title"><?php printf( _nx( '<span>1</span> Comment', '<span>%1$s</span> Comments', get_comments_number(), 'comments title', 'starter-kit' ), number_format_i18n( get_comments_number() ) ); ?></h2>

				<div class="comment-form-wrapper">
					<div class="row">
						<div class="col-12">
							<?php comment_form( $comment_form_args ); ?>
						</div>
					</div>
				</div>

				<?php if ( have_comments() ) : ?>

					<ul class="comments-list">
						<?php
							wp_list_comments(
								[ 'callback' => 'StarterKit_comments_callback' ]
							);
						?>
					</ul><!-- .commentlist -->

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
						<nav id="comments-nav" class="pagination">
							<?php
								paginate_comments_links( [
									'prev_text' => '<i class="fa fa-angle-left"></i>',
									'next_text' => '<i class="fa fa-angle-right"></i>',
								] );
							?>
						</nav>
					<?php endif; ?>

				<?php else: ?>

					<?php if ( is_page() ): ?>
						<p class="no-comments"><?php esc_html_e( 'There are no comments on this page.', 'starter-kit' ); ?></p>
					<?php else: ?>
						<p class="no-comments"><?php esc_html_e( 'There are no comments on this post.', 'starter-kit' ); ?></p>
					<?php endif; ?>

				<?php endif; // have_comments() ?>

			<?php else: ?>

				<?php if ( is_page() ): ?>
					<p class="no-comments comments-disabled"><?php esc_html_e( 'Comments were disabled for this page.', 'starter-kit' ); ?></p>
				<?php else: ?>
					<p class="no-comments comments-disabled"><?php esc_html_e( 'Comments were disabled for this post.', 'starter-kit' ); ?></p>
				<?php endif; ?>

			<?php endif; ?>

		</div><!-- /comments-->

	</div>
</div>
