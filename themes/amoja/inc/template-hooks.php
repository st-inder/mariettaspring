<?php
/**
 * =================================================
 * Hook amoja_page
 * =================================================
 */
add_action('amoja_page', 'amoja_page_header', 10);
add_action('amoja_page', 'amoja_page_content', 20);

/**
 * =================================================
 * Hook amoja_single_post_top
 * =================================================
 */
add_action('amoja_single_post_top', 'amoja_post_header', 5);
add_action('amoja_single_post_top', 'amoja_post_thumbnail', 10);

/**
 * =================================================
 * Hook amoja_single_post
 * =================================================
 */
add_action('amoja_single_post', 'amoja_post_content', 30);

/**
 * =================================================
 * Hook amoja_single_post_bottom
 * =================================================
 */
add_action('amoja_single_post_bottom', 'amoja_post_taxonomy', 5);
add_action('amoja_single_post_bottom', 'amoja_single_author', 10);
add_action('amoja_single_post_bottom', 'amoja_post_nav', 15);
add_action('amoja_single_post_bottom', 'amoja_display_comments', 20);

/**
 * =================================================
 * Hook amoja_loop_post
 * =================================================
 */
add_action('amoja_loop_post', 'amoja_post_header', 15);
add_action('amoja_loop_post', 'amoja_post_content', 30);

/**
 * =================================================
 * Hook amoja_footer
 * =================================================
 */
add_action('amoja_footer', 'amoja_footer_default', 20);

/**
 * =================================================
 * Hook amoja_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'amoja_mobile_nav', 1);
add_action('wp_footer', 'render_html_back_to_top', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'amoja_pingback_header', 1);

/**
 * =================================================
 * Hook amoja_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook amoja_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook amoja_content_top
 * =================================================
 */

/**
 * =================================================
 * Hook amoja_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook amoja_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook amoja_sidebar
 * =================================================
 */
add_action('amoja_sidebar', 'amoja_get_sidebar', 10);

/**
 * =================================================
 * Hook amoja_loop_after
 * =================================================
 */
add_action('amoja_loop_after', 'amoja_paging_nav', 10);

/**
 * =================================================
 * Hook amoja_page_after
 * =================================================
 */
add_action('amoja_page_after', 'amoja_display_comments', 10);
