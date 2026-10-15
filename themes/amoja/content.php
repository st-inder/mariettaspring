<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <div class="post-inner">
        <?php amoja_post_thumbnail('post-thumbnail'); ?>
        <div class="post-content">
            <?php
            /**
             * Functions hooked in to amoja_loop_post action.
             *
             * @see amoja_post_header          - 15
             * @see amoja_post_content         - 30
             */
            do_action('amoja_loop_post');
            ?>
        </div>
    </div>
</article><!-- #post-## -->