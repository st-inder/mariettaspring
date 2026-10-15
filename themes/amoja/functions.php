<?php
$theme          = wp_get_theme('amoja');
define( 'AMOJA_VERSION', $theme['Version'] );

if ( ! isset( $content_width ) ) $content_width = 900;

require_once get_theme_file_path('inc/class-tgm-plugin-activation.php');
require_once get_theme_file_path('inc/class-main.php');
require_once get_theme_file_path('inc/functions.php');
require_once get_theme_file_path('inc/template-hooks.php');
require_once get_theme_file_path('inc/template-functions.php');

require_once get_theme_file_path('inc/merlin/vendor/autoload.php');
require_once get_theme_file_path('inc/merlin/class-merlin.php');
require_once get_theme_file_path('inc/merlin-config.php');

require_once get_theme_file_path('inc/class-customize.php');

require_once get_theme_file_path('template-parts/common-development.php');

if (amoja_is_elementor_activated()) {
    require_once get_theme_file_path('inc/elementor/functions-elementor.php');
    require_once get_theme_file_path('inc/elementor/class-elementor.php');
    require_once get_theme_file_path('inc/megamenu/megamenu.php');
    require_once get_theme_file_path('inc/elementor/section-parallax.php');

    require_once get_theme_file_path('inc/elementor/elementor-control/class-elementor-control.php');
    require_once get_theme_file_path('inc/merlin/theme-builder/theme-builder.php');
    if (defined('ELEMENTOR_PRO_VERSION')) {
        require_once get_theme_file_path('inc/elementor/class-elementor-pro.php');
    }

}

if (amoja_is_ba_booking_activated()) {
    require_once get_theme_file_path('inc/booking/class-ba.php');

    require_once get_theme_file_path('inc/booking/ba-template-functions.php');
    require_once get_theme_file_path('inc/booking/ba-template-hooks.php');
}
/**
 * Disable WordPress comments completely
 */
function disable_comments() {

    // Close comments on frontend
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

    // Remove comments menu from admin
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });

    // Redirect comments page
    add_action('admin_init', function () {
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }
    });

    // Remove comments from admin bar
    add_action('init', function () {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });
}
add_action('init', 'disable_comments');


/**
 * Remove comment support from posts/pages
 */
function remove_comment_support() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}
add_action('admin_init', 'remove_comment_support');
if (!is_user_logged_in()) {
    require_once get_theme_file_path('inc/modules/class-login.php');
}else {
    require_once get_theme_file_path('inc/modules/media-custom-field.php');
}