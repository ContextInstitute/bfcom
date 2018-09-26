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
            <li>Edit My Profile (/members/[username]/profile/edit/). This is currently linked to the user avatar, the user's real name and then the Edit My Profile link. We don't need the user's real name or username since your hopefully know what your name is!</li>
            <li>Change Avatar (/members/[username]/profile/change-avatar/). This can be a text link and perhaps also the link from the current avatar picture.</li>
            <li>Messages (/members/[username]/messages/)</li>
            <li>Compose Message (/members/[username]/compose/)</li>
            <li>Email/Password Settings (/members/[username]/settings</li>
            <li>Notification Settings (/members/[username]/settings/notifications/</li>
            <li>Profile Settings (/members/[username]/settings/profile/)</li>
            <li>Log Out (looks like this is a dynamic link)</li>
        </ul>
        </div>
      </div>
    </div>
</div>
