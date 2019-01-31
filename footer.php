<?php
/**
 * The template for displaying the footer.
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
 ?>
				<footer class="footer" role="contentinfo">
					<nav role="navigation">
                		<?php bfc_bottom_nav(); // replaces joints_footer_links(); ?>
					</nav>
				</footer> <!-- end .footer -->

		<?php wp_footer(); ?>

	</body>
</html> <!-- end page -->
