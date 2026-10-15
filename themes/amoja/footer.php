
		</div><!-- .col-fluid -->
	</div><!-- #content -->

	<?php do_action( 'amoja_before_footer' );
    if (amoja_is_elementor_activated() &&  (etb_footer_enabled() || etb_is_before_footer_enabled())) {
        do_action('etb_footer');
    } else {
        ?>

        <footer id="colophon" class="site-footer" role="contentinfo">
            <?php
            /**
             * Functions hooked in to amoja_footer action
             *
             * @see amoja_footer_default - 20
             *
             *
             */
            do_action('amoja_footer');

            ?>

        </footer><!-- #colophon -->

        <?php
    }

		/**
		 * Functions hooked in to amoja_after_footer action
		 *
		 */
		do_action( 'amoja_after_footer' );
	?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see amoja_mobile_nav - 1
 * @see render_html_back_to_top - 1
 *
 */

wp_footer();
?>
</body>
</html>
