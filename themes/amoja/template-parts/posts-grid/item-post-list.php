<div class="post-inner blog-list">
    <?php amoja_post_thumbnail('amoja-post-grid'); ?>
    <div class="post-content">
        <div class="entry-header">
            <?php
                $categories_list = get_the_category_list(' ');
                if ($categories_list) {
                    echo '<div class="categories-link">' . $categories_list . '</div>';
                }
                the_title('<h3 class="omega entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
            ?>
        </div>
        <div class="entry-content">
            <div class="entry-excerpt"><?php the_excerpt(); ?></div>
        </div>

        <div class="entry-footer">
            <div class="entry-meta">
                <?php amoja_post_meta(['show_cat' => false, 'show_date' => true, 'show_author' => true, 'show_comment' => false]); ?>
            </div>
        </div>
    </div>
</div>