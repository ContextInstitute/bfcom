<?php
/**
 * BuddyPress - Groups Home
 *
 * @since 3.0.0
 * @version 3.0.0
 */

if ( bp_has_groups() ) :
	while ( bp_groups() ) :
		bp_the_group();
	?>

		<?php bp_nouveau_group_hook( 'before', 'home_content' ); ?>


		<div class="bp-wrap">


			<div id="item-body" class="item-body">

				<?php bp_nouveau_group_template_part(); ?>

			</div><!-- #item-body -->

		</div><!-- // .bp-wrap -->

		<?php bp_nouveau_group_hook( 'after', 'home_content' ); ?>

	<?php endwhile; ?>

<?php
endif;
