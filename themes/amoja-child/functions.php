<?php
/**
 * Theme functions and definitions.
 */
add_filter('elementor/frontend/container/should_render', function ($render, $element) {

    $settings = $element->get_settings();

    if (isset($settings['element_pack_global_tooltip_width'])) {
        unset($settings['element_pack_global_tooltip_width']);
    }

    return $render;

}, 10, 2);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');