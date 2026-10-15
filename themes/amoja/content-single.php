<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to amoja_single_post_top action
         *
         * @see amoja_post_header         - 5
         * @see amoja_post_thumbnail        - 10
         */
        do_action('amoja_single_post_top');

        /**
         * Functions hooked in to amoja_single_post action
         * @see amoja_post_content        - 30
         */
        do_action('amoja_single_post');

        /**
         * Functions hooked in to amoja_single_post_bottom action
         *
         * @see amoja_post_taxonomy      - 5
         * @see amoja_single_author      - 10
         * @see amoja_post_nav            - 15
         * @see amoja_display_comments    - 20
         */
        do_action('amoja_single_post_bottom');
        ?>

    </div>

</article><!-- #post-## -->
