
<header class="header-grid">
  <div class="header-logo">
		<a href="<?php echo home_url(); ?>">Logo</a>
	</div>
  <div class="header-topmenu">
		<?php joints_top_nav(); ?>
	</div>
  <div class="header-user">
		<a href="<?php bp_loggedin_user_link(); ?>" data-toggle="user-dropdown"><?php bp_loggedin_user_avatar( 'type=full' ); ?></a>
		<div class="dropdown-pane" id="user-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
			<ul>
				<li><a href="/wp-admin/">Admin Dashboard</a></li>
				<li><a href="/wp-login.php?action=logout">Logout</a></li>
				<!-- logout doesn't fully work yet -->
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/profile/edit/">Edit My Profile</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/profile/change-avatar/">Change Avatar</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/messages/">Messages</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/compose/">Compose Message</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/">Email/Password Settings</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/notifications/">Notification Settings</a></li>
				<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/profile/">Profile Settings</a></li>
			</ul>
		</div>
	</div>
  <div class="header-submenu">
		<?php get_template_part( 'parts/nav', 'bfc-submenu' ); ?>
	</div>
</header>
