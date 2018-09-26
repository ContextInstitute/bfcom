<div class="grid-container fluid">
    <div class="grid-x">
        <div class="cell" style="width: 54px; height: 54px;"> 
            <a href="<?php echo home_url(); ?>">Logo</a>
        </div>
        <div class="grid-y medium-auto">
            <div class="cell medium-auto" style="margin: 0 auto;">
                <?php joints_top_nav(); ?>
            </div>
            <div class="cell medium-auto" style="margin: 0 auto;">
				<?php get_template_part( 'parts/nav', 'bfsubmenu' ); ?>
            </div>
		</div>
		<!-- The following uses Foundation's dropdown menu component -->
		<div class="cell" style="width: 70px; height: 54px; z-index: 100;">
		<!-- The width is bigger than the height to accommodate the dropdown triangle -->
        	<ul class="dropdown menu" data-dropdown-menu>
				  <li><a href="<?php bp_loggedin_user_link(); ?>"><?php bp_loggedin_user_avatar( 'type=full' ); ?></a>
				  <!-- check buddypress.wp-a2z.org for details on these functions. The parameters for ..._avatar are under bp_core_fetch_avatar() -->
					<ul class="menu">
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
				</li>
			</ul>
        </div>
    </div>
</div>
