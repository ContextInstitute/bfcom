<?php
/**
 * Group Members Loop template
 *
 * @since 3.0.0
 * @version 3.2.0
 */
?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php bp_nouveau_group_hook( 'before', 'members_content' ); ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<?php bp_nouveau_group_hook( 'before', 'members_list' ); ?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

		<?php
		while ( bp_group_members() ) :
			bp_group_the_member();
		?>
			<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php echo esc_attr( bp_get_group_member_id() ); ?>" data-bp-item-component="members">
				<div class="list-wrap">

					<div class="item-avatar">
						<span data-toggle="gmem-dropdown-<?php echo esc_attr( bp_get_group_member_id() ); ?>"><?php bp_group_member_avatar(); ?></span><br>
						<span class="list-title member-name"><?php bp_member_name(); ?></span>
						<div class="dropdown-pane" id="gmem-dropdown-<?php echo esc_attr( bp_get_group_member_id() ); ?>" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
							<a href="/members/<?php echo bp_core_get_username(bp_loggedin_user_id()); ?>/messages/compose/?r=<?php echo bp_core_get_username(bp_get_group_member_id()); ?>">Send a message</a><br>
							<?php bp_follow_add_follow_button('leader_id=' . bp_get_group_member_id()); ?> <br>
							<a href="/members/<?php echo bp_core_get_username(bp_get_group_member_id()); ?>">Visit profile</a><br>
							Plus info from profile
						</div>
					</div>
					<div class="item-intro">
						<?php
						$args = array('field' => 8, 'user_id' => bp_get_group_member_id());
						$intro = bp_get_profile_field_data($args);
						if ($intro) {
							echo wpautop($intro);
						}
						?>
					</div>
				</div><!-- // .list-wrap -->
			</li>
		<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_group_hook( 'after', 'members_list' ); ?>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

	<?php bp_nouveau_group_hook( 'after', 'members_content' ); ?>

	<script>
		jQuery(document).foundation();
	</script>

<?php else :

	bp_nouveau_user_feedback( 'group-members-none' );

endif;
