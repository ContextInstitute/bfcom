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
        <div class="cell" style="width: 54px; height: 54px;">
        <a href="<?php bp_loggedin_user_link(); ?>" data-toggle="user-dropdown"><?php bp_loggedin_user_avatar( 'type=full' ); ?></a>
        <div class="dropdown-pane" id="user-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
            <ul>
                <li><a href="/wp-admin/">Admin Dashboard</a></li>
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
    </div>
</div>
