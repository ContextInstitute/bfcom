<?php
/**
 * Infinity Theme: Header Content
 *
 * This template contains the Header Content. Fork this in your Child THeme
 * if you want to change the markup but don't want to mess around doctypes/meta etc!
 *
 * @author Bowe Frankema <bowe@presscrew.com>
 * @link http://infinity.presscrew.com/
 * @copyright Copyright (C) 2010-2011 Bowe Frankema
 * @license http://www.gnu.org/licenses/gpl.html GPLv2 or later
 * @package Infinity
 * @subpackage templates
 * @since 1.0
 */
?>
<div class="top-wrap row <?php do_action( 'top_wrap_class' ); ?>">
    <header class="bf-header" role="banner">
	    <?php
        $bf_images = get_stylesheet_directory_uri() . '/assets/images/'; ?>
        <div class="bf-logo"><a href="/"><img src="<?php echo $bf_images . 'cilogoS.svg'; ?>"></a></div>
        <div class="bf-middle">
            <div class="bf-middlerow">
                <div class="bf-mainmenu">
	                <?php
	                $user_id = get_current_user_id();
                    $avatar = get_avatar_url( $user_id );

                    if ( current_user_can( 'read' ) ) {
		                $profile_url = get_edit_profile_url( $user_id );
	                } else {
		                $profile_url = false;
	                }
	                // Load Top Menu only if it's enabled
	                if ( current_theme_supports( 'infinity-top-menu-setup' ) ) :
		                infinity_get_template_part( 'templates/parts/top-menu', 'header' );
	                endif;
	                ?>
                </div>
                <div class="bf-searchgroup">
                    <div class="bf-menuicon"><img src="<?php echo $bf_images . 'burger.svg'; ?>"></div>
                    <div class="bf-search" style="text-align:center">Search</div>
                    <div class="bf-user-small"><a href="<?php echo $profile_url;?>"><img src="<?php echo $avatar;?>"></a></div>
                </div>
            </div>
            <div class="bf-middlerow">
<!--	            --><?php //if(function_exists('bcn_display'))
//	            {
//		            $bf_breadcrumbs = bcn_display('true');
//		            $bf_bcdisplay = "";
//		            if($bf_breadcrumbs=="")
//		            {
//		                $bf_bcdisplay = 'style ="'.'display: none"';
//		            }
//		            $bf_token = 1;
//	            }?>
                <div class="bf-breadcrumbs">
                    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                        <?php if(function_exists('bcn_display')) {
	                        bcn_display();
                        }
                        ?>
                    </div>
                </div>
                <div class="bf-submenu" style="text-align:center">Submenu</div>
            </div>
        </div>
        <div class="bf-user-big"><a href="<?php echo $profile_url;?>"><img src="<?php echo $avatar;?>"></a>
        </div>
    </header><!-- end header -->
</div><!-- end top wrap -->
