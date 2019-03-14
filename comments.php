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
?>
	
	
	<!--
		Comments block
	-->
	<div class="indent <?php echo get_option( 'show_avatars' ) ? 'with-avatars' : 'no-avatars'; ?>"
		 id="comments">
		
		<h3 class="comments-title"><?php printf( _nx( '<span>1</span> Comment', '<span>%1$s</span> Comments', get_comments_number(), 'comments title', 'starter-kit' ), number_format_i18n( get_comments_number() ) ); ?></h3>
		
		<?php if ( have_comments() ) : ?>
			
			<ul class="comments-list">
				<?php
				wp_list_comments( array( 'callback' => 'StarterKit_comments_callback' ) );
				?>
			</ul><!-- .commentlist -->
			
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comments-nav" class="posts-pagination">
					<?php paginate_comments_links( array(
						'prev_text' => '<i class="fa fa-angle-left"></i>',
						'next_text' => '<i class="fa fa-angle-right"></i>',
					) ); ?>
				</nav>
			<?php endif; // check for comment navigation ?>
		
		<?php else: ?>
			
			<?php if ( is_page() ): ?>
				
				<p class="no-comments"><?php esc_html_e( 'There are not comments on this page.', 'starter-kit' ); ?></p>
			
			<?php else: ?>
				
				<p class="no-comments"><?php esc_html_e( 'There are no comments on this post.', 'starter-kit' ); ?></p>
			
			<?php endif; ?>
		
		<?php endif; // have_comments() ?>
		
		<?php
		
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		
		$form_classes = '';
		
		$col_rtl = is_rtl() ? 'pull-right' : '';
		
		$comment_form_args = array(
			
			'class_submit' => 'button style-blue size-medium',
			
			'class_form' => 'comment-form ' . $form_classes,
			
			'title_reply' => esc_html__( 'Leave a reply', 'starter-kit' ),
			
			'comment_field' => '<textarea class="input-icon-comment" id="comment" placeholder="' . esc_html__( 'Your Comment *', 'starter-kit' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea>',
			
			'fields' => apply_filters( 'comment_form_default_fields', array(
					
					'author' => '<div class="row"><div class="form-row ' . $col_rtl . ' col-md-6"><input class="input-icon-user" id="author" name="author" type="text" placeholder="' . esc_html__( 'Your Name *', 'starter-kit' ) . '" value="' . $commenter['comment_author'] . '" size="30"' . $aria_req . ' /></div>',
					
					'email' => '<div class="form-row col-md-6"><input id="email" class="input-icon-email" name="email" type="text" placeholder="' . esc_html__( 'Email Address *', 'starter-kit' ) . '" value="' . $commenter['comment_author_email'] . '" size="30"' . $aria_req . ' /></div></div>',
					
					'url' => ''
				
				)
			),
			
			'comment_notes_after' => '',
			
			'must_log_in' => '<p>' . wp_kses_post( sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'starter-kit' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) ) . '</p>',
			
			'logged_in_as' => '',
			
			'comment_notes_before' => '',
			
			'label_submit' => esc_html__( 'POST COMMENT', 'starter-kit' )
		
		);
		?>
	
	
	</div><!-- /comments-->


<?php if ( comments_open() ): ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="comment-form-wrapper">
				<?php comment_form( $comment_form_args ); ?>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php
/**
 * Comments callback function
 **/
function StarterKit_comments_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	
	<div class="comment-body">
		
		<?php
		
		$comment_author = get_userdata( $comment->user_id );
		$author_name    = isset( $comment_author->display_name ) ? $comment_author->display_name : get_comment_author( get_comment_ID() );
		
		?>
		
		<?php if ( get_option( 'show_avatars' ) ): ?>
			
			<div class="avatar">
				
				<?php if ( $comment->comment_type === 'pingback' || $comment->comment_type === 'trackback' ) : ?>
					
					<img class="avatar" height="60" width="60" src="<?php echo get_template_directory_uri() . '/assets/images/robot.png'; ?>"
						 alt="<?php echo $comment->comment_type; ?>">
				
				<?php else: ?>
					
					<?php echo get_avatar( $comment, 165, '', get_comment_author() ); ?>
				
				<?php endif; ?>
			
			</div>
		
		<?php endif; ?>
		
		<div class="comment-text">
			
			<h4 class="author-name-mobile">
				<?php echo wp_kses_post( $author_name ); ?>
			</h4>
			
			<div class="comment-time"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) . " " . esc_html__( 'ago', 'starter-kit' ); ?></div>
			
			<div class="comment-contents">
				<?php comment_text(); ?>
			</div>
			
			<?php comment_reply_link( array_merge( $args, array(
				'add_below'  => 'comment',
				'reply_text' => esc_html__( 'Reply', 'starter-kit' ),
				'depth'      => $depth,
				'max_depth'  => $args['max_depth']
			) ), get_comment_ID(), get_the_ID() ); ?>
			
			<div class="clearfix"></div>
		
		</div>
	
	</div>
	
	<?php
	
	
}
