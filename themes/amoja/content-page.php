<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to amoja_page action
	 *
	 * @see amoja_page_header          - 10
	 * @see amoja_page_content         - 20
	 *
	 */
	do_action( 'amoja_page' );
	?>
</article><!-- #post-## -->
