<?php
// Item Block
add_filter('babe_shortcode_all_items_item_html', 'amoja_ba_item_block', 10, 3);
// Item Block related
add_filter('babe_post_related_item_html', 'amoja_ba_item_block', 10, 3);

add_filter('babe_shortcode_all_items_html', 'amoja_babe_shortcode_all_items_html', 10, 3);

add_filter('babe_pager_args', 'amoja_babe_pager_args', 10);

add_filter('babe_get_rate_units', function ($output) {
    $output = str_replace("/", esc_html__('per', 'amoja'), $output);
    return $output;
}, 10);