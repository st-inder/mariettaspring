<?php

get_header();

if (amoja_is_elementor_activated() && etb_single_enabled()) {
    do_action('etb_single');
}else{

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'amoja_single_post_before' );

			get_template_part( 'content', 'single' );

			do_action( 'amoja_single_post_after' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
    do_action( 'amoja_sidebar' );
}
get_footer();
