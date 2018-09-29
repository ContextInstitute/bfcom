<?php if ( bp_nouveau_has_nav() ) : ?>
<nav class="main-navs no-ajax bp-navs single-screen-navs horizontal users-nav buddypress-wrap" id="object-nav" role="navigation" aria-label="User menu">
	
	<ul id="menu-subnav-1" class="medium-horizontal menu dropdown" >

		<?php
		while ( bp_nouveau_nav_items() ) :
			bp_nouveau_nav_item();
		?>

			<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
				<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
					<?php bp_nouveau_nav_link_text(); ?>
				</a>
			</li>

		<?php endwhile; ?>

	</ul>
</nav>
<?php endif; 
// echo ("<br />component: ".bp_current_component());
// echo (", item: ".bp_current_item());
// echo (", action: ".bp_current_action()."<br />");
?>
