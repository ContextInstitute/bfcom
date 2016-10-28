<?php
	if ( post_password_required() ) :
		echo '<h3 class="comments-header">' . __('Password Protected', 'buddypress') . '</h3>';
		echo '<p class="alert password-protected">' . __('Enter the password to view comments.', 'buddypress') . '</p>';
		return;
	endif;

	if ( is_page() && !have_comments() && !comments_open() && !pings_open() )
		return;
?>

<div class="activity single-group">

	<?php if ( bp_has_activities ( 'object=groups&primary_id=' . bp_get_groupblog_id() .'&secondary_id=' . get_the_ID() . '&action=new_blog_post' ) ) : ?>
	
		<ul id="blog-stream" class="activity-list item-list">
		
		<?php while ( bp_activities() ) : bp_the_activity(); ?>
	
			<?php do_action( 'groupblog_before_activity_entry' ) ?>
			
			<li class="<?php bp_activity_css_class() ?>" id="activity-<?php bp_activity_id() ?>">
			
				<div class="activity-post">
				
					<p class="postmetadata">										
						<?php if ( is_user_logged_in() && bp_activity_can_comment() ) : ?>
							<a href="<?php bp_activity_comment_link() ?>" class="acomment-reply" id="acomment-comment-<?php bp_activity_id() ?>"><?php _e( 'Reply', 'buddypress' ) ?> (<span><?php bp_activity_comment_count() ?></span>)</a>
						<?php else : ?>	
							 <?php _e( 'Comments', 'buddypress' ) ?> (<span><?php bp_activity_comment_count() ?></span>)
						<?php endif; ?>
			
						<?php if ( is_user_logged_in() ) : ?>
							<?php if ( !bp_get_activity_is_favorite() ) : ?>
								<a href="<?php bp_activity_favorite_link() ?>" class="fav" title="<?php _e( 'Mark as Favorite', 'buddypress' ) ?>"><?php _e( 'Favorite', 'buddypress' ) ?></a>
							<?php else : ?>
								<a href="<?php bp_activity_unfavorite_link() ?>" class="unfav" title="<?php _e( 'Remove Favorite', 'buddypress' ) ?>"><?php _e( 'Remove Favorite', 'buddypress' ) ?></a>
							<?php endif; ?>
						<?php endif;?>
			
						<?php do_action( 'bp_activity_entry_meta' ) ?>
		
						<span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span>
					</p>
					
					<?php if ( 'activity_comment' == bp_get_activity_type() ) : ?>
						<div class="activity-inreplyto">
							<strong><?php _e( 'In reply to', 'buddypress' ) ?></strong> - <?php bp_activity_parent_content() ?> &middot;
							<a href="<?php bp_activity_thread_permalink() ?>" class="view" title="<?php _e( 'View Thread / Permalink', 'buddypress' ) ?>"><?php _e( 'View', 'buddypress' ) ?></a>
						</div>
					<?php endif; ?>
				
					<?php do_action( 'bp_before_activity_entry_comments' ) ?>
		
					<?php if ( bp_activity_can_comment() ) : ?>
						<div class="activity-comments">
							<?php bp_activity_comments() ?>
				
							<?php if ( is_user_logged_in() ) : ?>
							<form action="<?php bp_activity_comment_form_action() ?>" method="post" id="ac-form-<?php bp_activity_id() ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display() ?>>
								<div class="ac-reply-avatar"><?php bp_loggedin_user_avatar( 'width=25&height=25' ) ?></div>
								<div class="ac-reply-content">
									<div class="ac-textarea">
										<textarea id="ac-input-<?php bp_activity_id() ?>" class="ac-input" name="ac_input_<?php bp_activity_id() ?>"></textarea>
									</div>
									<input type="submit" name="ac_form_submit" value="<?php _e( 'Post', 'buddypress' ) ?> &rarr;" /> &nbsp; <?php _e( 'or press esc to cancel.', 'buddypress' ) ?>
									<input type="hidden" name="comment_form_id" value="<?php bp_activity_id() ?>" />
								</div>
								<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ) ?>
							</form>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				
					<?php do_action( 'bp_after_activity_entry_comments' ) ?>
							
				</div>			
			
			</li>
			
			<?php do_action( 'groupblog_after_activity_entry' ) ?>
	
		<?php endwhile; ?>
		
		</ul>
		
	 <?php endif; ?>

</div>	 