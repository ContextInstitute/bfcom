<?php
/*
Template Name: Home
*/

get_header(); ?>
	
	<div class="content">
	
		<div class="inner-content grid-x grid-margin-x grid-padding-x">
	
			<main class="main small-12 medium-12 large-12 cell" role="main">
				
			<div class="user-home-page">

			<div id="bfc-user-panels" class="bfc-user-panels">
			<?php if ( is_active_sidebar( 'user_left_panel' ) ) : ?>
				<div id="bfc-user-panel-left" class="bfc-user-panel-left widget-area">
					<?php dynamic_sidebar( 'user_left_panel' ); ?>
				</div><!-- #bfc-user-panel-left -->

			<?php endif; ?>
			<?php if ( is_active_sidebar( 'user_center_panel' ) ) : ?>
				<div id="bfc-user-panel-center" class="bfc-user-panel-center widget-area">
					<?php dynamic_sidebar( 'user_center_panel' ); ?>
				</div><!-- #bfc-user-panel-center -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'user_right_panel' ) ) : ?>
				<div id="bfc-user-panel-right" class="bfc-user-panel-right widget-area">
					<?php dynamic_sidebar( 'user_right_panel' ); ?>
				</div><!-- #bfc-user-panel-right -->
			<?php endif; ?>
			</div>

			<div id="bfc-user-accordion" class="bfc-user-accordion accordion" data-accordion data-allow-all-closed="true">
			<?php if ( is_active_sidebar( 'user_left_panel' ) ) : ?>
				<div id="bfc-user-panel-top" class="bfc-user-panel-top widget-area" data-accordion-item>
				<a href="#" class="accordion-title">Latest Updates</a>
				<div class="accordion-content" data-tab-content>
					<?php dynamic_sidebar( 'user_left_panel' ); ?>
				</div></div><!-- #bfc-user-panel-le-top -->

			<?php endif; ?>
			<?php if ( is_active_sidebar( 'user_center_panel' ) ) : ?>
				<div id="bfc-user-panel-middle" class="bfc-user-panel-middle widget-area" data-accordion-item>
				<a href="#" class="accordion-title">Forum Posts</a>
				<div class="accordion-content" data-tab-content>
					<?php dynamic_sidebar( 'user_center_panel' ); ?>
				</div></div><!-- #bfc-user-panel-middle -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'user_right_panel' ) ) : ?>
				<div id="bfc-user-panel-bottom" class="bfc-user-panel-bottom widget-area" data-accordion-item>
				<a href="#" class="accordion-title">Blog Posts</a>
				<div class="accordion-content" data-tab-content>
					<?php dynamic_sidebar( 'user_right_panel' ); ?>
				</div></div><!-- #bfc-user-panel-bottom -->
			<?php endif; ?>
			</div>

			</div>
								
			</main> <!-- end #main -->
			
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
