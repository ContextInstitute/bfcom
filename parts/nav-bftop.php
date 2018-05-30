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
          User
        </div>
    </div>
</div>