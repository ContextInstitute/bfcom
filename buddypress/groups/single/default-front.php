<?php
/**
 * BP Nouveau Default group's front template.
 *
 * @since 3.0.0
 * @version 3.2.0
 */
?>

<div class="group-front-page">

	<?php if ( bp_nouveau_groups_front_page_description() && bp_nouveau_group_has_meta( 'description' ) ) : ?>
		<div class="group-description">

			<?php bp_group_description(); ?>

		</div><!-- .group-description -->
	<?php endif; ?>
	<div id="bfc-dash-panels" class="bfc-dash-panels">
	<?php if ( is_active_sidebar( 'dash_left_panel' ) ) : ?>
		<div id="bfc-dash-panel-left" class="bfc-dash-panel-left widget-area">
			<?php dynamic_sidebar( 'dash_left_panel' ); ?>
		</div><!-- #bfc-dash-panel-left -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'dash_right_panel' ) ) : ?>
		<div id="bfc-dash-panel-right" class="bfc-dash-panel-right widget-area">
			<?php dynamic_sidebar( 'dash_right_panel' ); ?>
		</div><!-- #bfc-dash-panel-right -->
	<?php endif; ?>
	</div>

	<div id="bfc-dash-accordion" class="bfc-dash-accordion accordion" data-accordion data-allow-all-closed="true">
	<?php if ( is_active_sidebar( 'dash_left_panel' ) ) : ?>
		<div id="bfc-dash-panel-top" class="bfc-dash-panel-top widget-area accordion-item" data-accordion-item>
		<a href="#" class="accordion-title">Latest Updates</a>
		<div class="accordion-content" data-tab-content>
			<?php dynamic_sidebar( 'dash_left_panel' ); ?>
		</div></div><!-- #bfc-dash-panel-top -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'dash_right_panel' ) ) : ?>
		<div id="bfc-dash-panel-bottom" class="bfc-dash-panel-bottom widget-area accordion-item" data-accordion-item>
		<a href="#" class="accordion-title">Forum Posts</a>
		<div class="accordion-content" data-tab-content>
			<?php dynamic_sidebar( 'dash_right_panel' ); ?>
		</div></div><!-- #bfc-dash-panel-bottom -->
	<?php endif; ?>
	</div>
</div>
