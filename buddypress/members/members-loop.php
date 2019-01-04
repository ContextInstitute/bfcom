<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 3.0.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
			<div class="list-wrap">
			
				<div class="item-avatar">
					<span data-toggle="member-dropdown-<?php bp_member_user_id() ; ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></span><br>
					<span class="list-title member-name"><?php bp_member_name(); ?></span>
					<div class="dropdown-pane" id="member-dropdown-<?php bp_member_user_id(); ?>" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
							<a href="/members/<?php echo bp_core_get_username(bp_loggedin_user_id()); ?>/messages/compose/?r=<?php echo bp_core_get_username(bp_get_member_user_id()); ?>">Send a message</a><br>
							<?php bp_follow_add_follow_button('leader_id=' . bp_get_member_user_id()); ?> <br>
							<a href="/members/<?php echo bp_core_get_username(bp_get_member_user_id()); ?>">Visit profile</a><br>
							Plus info from profile
					</div>
				</div>
			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php
else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;
?>

<?php bp_nouveau_after_loop(); ?>

<script>
		jQuery(document).foundation();
	</script>
