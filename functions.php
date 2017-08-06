<?php
//Custom functionality for the BFCom Theme, a child theme of CBOX.
require_once( 'engine/includes/custom.php' );

/**
 * Set this to true to put Infinity into developer mode. Developer mode will refresh the dynamic.css on every page load.
 */

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
};

//remove_filter( 'bbp_get_breadcrumb', '__return_false' );
add_filter( 'bbp_no_breadcrumb', '__return_false', 20 );

function bf_remove_title_prepend($title)
{
	$prepens = array("Private: ", "Protected: ");
	return str_replace($prepens,"",$title);
}
add_filter('the_title', 'bf_remove_title_prepend');
?>