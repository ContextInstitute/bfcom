
<header class="header-grid">
	<div class="header-logo">
		<span data-toggle="logo-dropdown"><img class="logo-img" src="/wp-content/themes/bfcom/assets/images/logo9b.svg" alt="Logo"/><img src="/wp-content/themes/bfcom/assets/images/menuarrow.svg" alt="Menu Arrow"/></span>
		<div class="dropdown-pane" id="logo-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="/about/">About this site</a></li>
				<li><a href="https://www.context.org">Main CI site</a></li>
				<li><a href="/about/contact/">Contact</a></li>
				<li><a href="/about/help/">Help</a></li>
				<li><a href="/about/terms-rules/">Terms of Service</a></li>
				<li><a href="/about/privacy-policy/">Privacy</a></li>
			</ul>
		</div>
	</div>
	<div class="header-topmenu">
    <?php bfc_top_nav(); ?> <!-- this replaces the call to joints_top_nav(); -->
		<!--- <span class="search menu-item-type-post_type menu-item-object-page" data-toggle="search-dropdown"><img src="/wp-content/themes/bfcom/assets/images/search.svg" alt="Trial Search Box"/> <p>Search</p> </span> -->
		<div class="dropdown-pane" id="search-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">	
			<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
 				<div class="input-group">
  					<input type="search" class="search-field input-group-field" placeholder="<?php echo esc_attr_x( 'Search...', 'jointswp' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'jointswp' ) ?>" />
 			 		<input type="submit" class="search-submit button input-group-button" value="<?php echo esc_attr_x( 'Search', 'jointswp' ) ?>" />
 				</div>
			</form>
		</div>
	</div>
	<?php if(! is_user_logged_in() ) : ?>
		<a href="/wp-login.php?action=login">Log in</a>
	<?php else : ?>
		<div class="header-user">
			<span data-toggle="user-dropdown"><img src="/wp-content/themes/bfcom/assets/images/menuarrow.svg" alt="Menu Arrow"/><?php bp_loggedin_user_avatar( 'type=full' ); ?></span>
			<div class="dropdown-pane" id="user-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-auto-focus="true">
				<ul>
					<li><a href="/wp-admin/">Admin Dashboard</a></li>
					<li><a href="<?php echo wp_logout_url(); ?>">Logout</a></li>
					<!-- logout doesn't fully work yet -->
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/profile/edit/">Edit My Profile</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/profile/change-avatar/">Change Avatar</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/messages/">Messages</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/messages/compose/">Compose Message</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/">Email/Password Settings</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/notifications/">Notification Settings</a></li>
					<li><a href="/members/<?php bp_loggedin_user_username(); ?>/settings/profile/">Profile Settings</a></li>
				</ul>
			</div>
		</div>
	<?php endif; ?>
	<div class="header-submenu">
		<?php get_template_part( 'parts/nav', 'bfc-submenu' ); ?>
	</div>
</header>
