<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>


<div <?php bbp_reply_class(); ?>>

	<div class="bbp-reply-author">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
		<span data-toggle="reply-author-dropdown-<?php echo esc_attr( bbp_get_reply_id() ); ?>"><?php bbp_reply_author_avatar( bbp_get_reply_id(),  $size = 80 ); ?></span><br>
		<div class="dropdown-pane" id="reply-author-dropdown-<?php echo esc_attr( bbp_get_reply_id() ); ?>" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="false">
			<a href="/members/<?php echo bp_core_get_username(bp_loggedin_user_id()); ?>/messages/compose/?r=<?php echo bp_core_get_username(bbp_get_reply_author_id()); ?>">Send a message</a><br>
			<br><?php bp_follow_add_follow_button('leader_id=' . bbp_get_reply_author_id()); ?> <br>
			<a href="/members/<?php echo bp_core_get_username(bbp_get_reply_author_id()); ?>">Visit profile</a><br>
			<br>Plus info from profile
		</div>
		<span class="bbp-author-name" rel="nofollow"><?php bbp_reply_author_display_name( bbp_get_reply_id() ); ?></span>
		<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

		<div class="bbp-meta">

		<?php if ( bbp_is_single_user_replies() ) : ?>

			<span class="bbp-header">
				<?php _e( 'in reply to: ', 'bbpress' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>

		<?php endif; ?>

		<!-- <a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a> -->

		<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		<?php bbp_reply_admin_links(); ?>

		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

		</div><!-- .bbp-meta -->

		


	</div><!-- .bbp-reply-content -->

</div><!-- .reply -->
