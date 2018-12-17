<?php

// All of the bfcom-specific functions

function replace_core_jquery_version() {
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.3.1.min.js", array(), '3.3.1' );
	wp_deregister_script( 'jquery-migrate' );
	wp_register_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.0.1.min.js", array(), '3.0.1' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );

define('BP_DEFAULT_COMPONENT', 'profile' );

// Remove the Toolbar for all users
add_filter('show_admin_bar','__return_false');

// This is based on https://codex.buddypress.org/developer/navigation-api/
function bfc_nav_configure() {
	global $bp;
	if( bp_is_group() ) {
		$bp->groups->nav->edit_nav( array( 'name' => __( 'G-Dash', 'buddypress' )), 'home', bp_current_item() );
	}
}
add_action( 'bp_actions', 'bfc_nav_configure' );


/**
 * This function, bfc_nouveau_has_nav(), is based on bp_nouveau_has_nav() in /wp-content/plugins/buddypress/bp-templates/bp-nouveau/includes/template-tags.php
 *
 * Init the Navigation Loop and check it has items.
 *
 * @since 3.0.0
 *
 * @param array $args {
 *     Array of arguments.
 *
 *     @type string $type                    The type of Nav to get (primary or secondary)
 *                                           Default 'primary'. Required.
 *     @type string $object                  The object to get the nav for (eg: 'directory', 'group_manage',
 *                                           or any custom object). Default ''. Optional
 *     @type bool   $user_has_access         Used by the secondary member's & group's nav. Default true. Optional.
 *     @type bool   $show_for_displayed_user Used by the primary member's nav. Default true. Optional.
 * }
 *
 * @return bool True if the Nav contains items. False otherwise.
 */


function bfc_nouveau_has_nav( $args = array() ) {
	$bp_nouveau = bp_nouveau();
	$n = bp_parse_args(
		$args,
		array(
			'type'                    => 'primary',
			'object'                  => '',
			'user_has_access'         => true,
			'show_for_displayed_user' => true,
		),
		'nouveau_has_nav'
	);
	if ( empty( $n['type'] ) ) {
		return false;
	}
	$nav                       = array();
	$bp_nouveau->displayed_nav = '';
	$bp_nouveau->object_nav    = $n['object'];
	if ( bp_is_directory() || 'directory' === $bp_nouveau->object_nav ) {
		$bp_nouveau->displayed_nav = 'directory';
		$nav                       = $bp_nouveau->directory_nav->get_primary();
	// So far it's only possible to build a Group nav when displaying it.
	} elseif ( bp_is_group() ) {
		$bp_nouveau->displayed_nav = 'groups';
		$parent_slug               = bp_get_current_group_slug();
		$group_nav                 = buddypress()->groups->nav;
		if ( 'group_manage' === $bp_nouveau->object_nav && bp_is_group_admin_page() ) {
			$parent_slug .= '_manage';
		/**
		 * If it's not the Admin tabs, reorder the Group's nav according to the
		 * following list.
		 */
		} else {
			bp_nouveau_set_nav_item_order( $group_nav, array('home','forum','members','docs','activity','admin'), $parent_slug );
		}
		$nav = $group_nav->get_secondary(
			array(
				'parent_slug'     => $parent_slug,
				'user_has_access' => (bool) $n['user_has_access'],
			)
		);
	// Build the nav for the displayed user
	} elseif ( bp_is_user() ) {
		$bp_nouveau->displayed_nav = 'personal';
		$user_nav                  = buddypress()->members->nav;
		if ( 'secondary' === $n['type'] ) {
			$nav = $user_nav->get_secondary(
				array(
					'parent_slug'     => bp_current_component(),
					'user_has_access' => (bool) $n['user_has_access'],
				)
			);
		} else {
			$args = array();
			if ( true === (bool) $n['show_for_displayed_user'] && ! bp_is_my_profile() ) {
				$args = array( 'show_for_displayed_user' => true );
			}
			// Reorder the user's primary nav according to the customizer setting.
			bp_nouveau_set_nav_item_order( $user_nav, array('profile','notifications','messages','groups','docs','activity','settings'));
			$nav = $user_nav->get_primary( $args );
		}
	} elseif ( ! empty( $bp_nouveau->object_nav ) ) {
		$bp_nouveau->displayed_nav = $bp_nouveau->object_nav;
		/**
		 * Use the filter to use your specific Navigation.
		 * Use the $n param to check for your custom object.
		 *
		 * @since 3.0.0
		 *
		 * @param array $nav The list of item navigations generated by the BP_Core_Nav API.
		 * @param array $n   The arguments of the Navigation loop.
		 */
		$nav = apply_filters( 'bp_nouveau_get_nav', $nav, $n );
	}
	// The navigation can be empty.
	if ( $nav === false ) {
		$nav = array();
	}
	$bp_nouveau->sorted_nav = array_values( $nav );
	if ( 0 === count( $bp_nouveau->sorted_nav ) || ! $bp_nouveau->displayed_nav ) {
		unset( $bp_nouveau->sorted_nav, $bp_nouveau->displayed_nav, $bp_nouveau->object_nav );
		return false;
	}
	$bp_nouveau->current_nav_index = 0;
	return true;
}

/* Main Nav Menu */
function bfc_top_nav_menu_builder() {
	$menuitemarray = array (
		array (
			'id' => 'bfc-topnav-home', // menu item id
			'classes' => 'menu-item-home menu-item-type-custom menu-item-object-custom current-menu-item current_page_item', // any unique classes for menu item
			'parent_nav' => 'home', // parent top nav to highlight
			'link_url' => '/', // page, use relative urls
			'icon_url' => '/wp-content/themes/bfcom/assets/images/home.svg', // menu item icon
			'text' => 'Home' // menu item text
		),
		array (
			'id' => 'bfc-topnav-members',
			'classes' => 'members menu-item-type-post_type menu-item-object-page',
			'parent_nav' => 'members',
			'link_url' => '/members/',
			'icon_url' => '/wp-content/themes/bfcom/assets/images/members.svg',
			'text' => 'People'
		),
		array (
			'id' => 'bfc-topnav-groups',
			'classes' => 'groups menu-item-type-post_type menu-item-object-page',
			'parent_nav' => 'groups',
			'link_url' => '/groups/',
			'icon_url' => '/wp-content/themes/bfcom/assets/images/groups.svg',
			'text' => 'Groups'
		),
		array (
			'id' => 'bfc-topnav-resources',
			'classes' => 'resources menu-item-type-post_type menu-item-object-page',
			'parent_nav' => 'resources',
			'link_url' => '/wiki/',
			'icon_url' => '/wp-content/themes/bfcom/assets/images/resources.svg',
			'text' => 'Resources'
		),
		array (
			'id' => 'bfc-topnav-blogs',
			'classes' => 'blogs menu-item-type-post_type menu-item-object-page',
			'parent_nav' => 'blogs',
			'link_url' => '/sites/',
			'icon_url' => '/wp-content/themes/bfcom/assets/images/blog.svg',
			'text' => 'Blogs'
		),
		array (
			'id' => 'bfc-topnav-search',
			'classes' => 'search menu-item-type-post_type menu-item-object-page',
			'parent_nav' => 'search',
			'link_url' => '/activity/',
			'icon_url' => '/wp-content/themes/bfcom/assets/images/search.svg',
			'text' => 'Search'
		)
	);
	return $menuitemarray;
}

function bfc_top_nav() {
	// Build collection for this template method
	$menuitemarray = bfc_top_nav_menu_builder();

	// set $topnav to its initial value
	$topnav = '<ul id="bfc-topmenu" class="medium-horizontal menu">'; //start with the opening ul and its selectors

	// loop through each menu item in the collection to build topnav html
	foreach ($menuitemarray as $menuitem) {
		$thismenuitem =  '<li ';
		$thismenuitem .= 'id="';
		$thismenuitem .= $menuitem['id'];
		$thismenuitem .= '" class="menu-item ';
		$thismenuitem .= $menuitem['classes'];

		if (bfc_top_nav_is_active($menuitem['parent_nav'])) {
			$thismenuitem .= ' active';
		}
		$thismenuitem .= '" role="menuitem"><a href="';
		$thismenuitem .= $menuitem['link_url'];
		$thismenuitem .= '">';
		$thismenuitem .= '<img src="';
		$thismenuitem .= $menuitem['icon_url'];
		$thismenuitem .= '">';
		$thismenuitem .= $menuitem['text'];
		$thismenuitem .= '</a></li>';

		$topnav .= $thismenuitem;
	}
	$topnav .= '</ul>';

	echo $topnav;
}

// determine which of the top menu items should be highlighted
function bfc_top_nav_is_active($topmenuparent) {
	if ($topmenuparent == 'home' && is_front_page()) {
		return true;
	} elseif ($topmenuparent == 'members' && (is_page('members') || bp_is_user())) {
		return true;
	} elseif ($topmenuparent == 'groups' && (is_page('groups') || bp_is_group())) {
		return true;
	} elseif ($topmenuparent == 'resources' && bp_docs_is_bp_docs_page()) {
		return true;
	} elseif ($topmenuparent == 'blogs' && is_page('sites')) {
		return true;
	} elseif ($topmenuparent == 'search' && is_page('activity')) {
		return true;
	} else {
		return false;
	}
}

/* Update post actions menu by removing Spam item */
function bfc_change_topic_admin_links ($r) {
	$r['links'] = apply_filters( 'bfc_topic_admin_links', array(
		'edit' => bbp_get_topic_edit_link ( $r ),
		'close' => bbp_get_topic_close_link( $r ),
		'stick' => bbp_get_topic_stick_link( $r ),
		'merge' => bbp_get_topic_merge_link( $r ),
		'trash' => bbp_get_topic_trash_link( $r ),
		'reply' => bbp_get_topic_reply_link( $r )
		), $r['id'] );
	return $r['links'] ;
}
add_filter ('bbp_topic_admin_links', 'bfc_change_topic_admin_links' ) ;

/* Replace post actions menu text with icons, add title to show up as tooltips */
function bfc_filter_bbp_actions_topic_links( $array, $r_id ) {

	$array = str_replace('>Edit<', 'title="Edit this item"><img src="/wp-content/themes/bfcom/assets/images/edit.svg"><', $array);
	$array = str_replace('>Close<', 'title="Close this item"><img src="/wp-content/themes/bfcom/assets/images/close.svg"><', $array);
	$array = str_replace('>Stick<', 'title="Stick this item"><img src="/wp-content/themes/bfcom/assets/images/stick.svg"><', $array);
	$array = str_replace('>Merge<', 'title="Merge this item"><img src="/wp-content/themes/bfcom/assets/images/merge.svg"><', $array);
	$array = str_replace('>Trash<', 'title="Trash this item"><img src="/wp-content/themes/bfcom/assets/images/trash.svg"><', $array);
	$array = str_replace('>Reply<', 'title="Reply to this item"><img src="/wp-content/themes/bfcom/assets/images/reply.svg"><', $array);

	return $array;
};

// add the filter
add_filter( 'bbp_get_topic_admin_links', 'bfc_filter_bbp_actions_topic_links', 10, 2 );

/* Update post reply menu by removing Spam item */
function bfc_change_admin_links ($r) {
	$r['links'] = apply_filters( 'bfc_reply_admin_links', array(
		'edit'  => bbp_get_reply_edit_link ( $r ),
		'move'  => bbp_get_reply_move_link ( $r ),
		'split' => bbp_get_topic_split_link( $r ),
		'trash' => bbp_get_reply_trash_link( $r ),
		'reply' => bbp_get_reply_to_link   ( $r )
		), $r['id'] );
	return $r['links'] ;
}
add_filter ('bbp_reply_admin_links', 'bfc_change_admin_links' ) ;

/* Replace post replies menu text with icons, add title to show up as tooltips */
function bfc_filter_bbp_reply_admin_links( $array, $r_id ) {

	// add title to anchor to show up as tooltips for reply menu icons
	$array = str_replace('>Edit<', 'title="Edit this item"><img src="/wp-content/themes/bfcom/assets/images/edit.svg"><', $array);
	$array = str_replace('>Move<', 'title="Move this item"><img src="/wp-content/themes/bfcom/assets/images/move.svg"><', $array);
	$array = str_replace('>Split<', 'title="Split this item"><img src="/wp-content/themes/bfcom/assets/images/split.svg"><', $array);
	$array = str_replace('>Trash<', 'title="Trash this item"><img src="/wp-content/themes/bfcom/assets/images/trash.svg"><', $array);
	$array = str_replace('>Reply<', 'title="Reply to this item"><img src="/wp-content/themes/bfcom/assets/images/reply.svg"><', $array);

	return $array;
};

// add the filter
add_filter( 'bbp_get_reply_admin_links', 'bfc_filter_bbp_reply_admin_links', 10, 2 );

//removes 'private' and protected prefix for forums
function remove_private_title($title) {
	return '%s';
}

function remove_protected_title($title) {
	return '%s';
}

add_filter('protected_title_format', 'remove_protected_title');
add_filter('private_title_format', 'remove_private_title');

// Adds the Forum after the group name as the title of the forum index page
function bfc_add_forum_to_title ($title){
	$forum_id = bbp_get_forum_id( $forum_id = 0 );
	$title = get_the_title( $forum_id );
	$title .= " Forum";
	return $title;
}

add_filter('bbp_get_forum_title', 'bfc_add_forum_to_title', 10, 2);

/**
 * Register our sidebars and widgetized areas.
 *
 */
function bfc_widgets_init() {

	register_sidebar( array(
		'name'          => 'User Home Left Panel',
		'id'            => 'user_left_panel',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'User Home Center Panel',
		'id'            => 'user_center_panel',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'User Home Right Panel',
		'id'            => 'user_right_panel',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Group Dash Left Panel',
		'id'            => 'dash_left_panel',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Group Dash Right Panel',
		'id'            => 'dash_right_panel',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'bfc_widgets_init' );
