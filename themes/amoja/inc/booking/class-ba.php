<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amoja_BA_Booking')) :
    class Amoja_BA_Booking {

        public static $icons
            = array(
                'dashboard'            => 'amoja-icon-home',
                'profile'              => 'amoja-icon-user',
                'edit-profile'         => 'amoja-icon-edit',
                'company-profile'      => 'amoja-icon-home',
                'edit-company-profile' => 'amoja-icon-edit',
                'change-password'      => 'amoja-icon-unlock',
                'activity'             => 'amoja-icon-home',
                'my-bookings'          => 'amoja-icon-shopping-cart',
                'my-orders'            => 'amoja-icon-shopping-cart',
                'logout'               => 'amoja-icon-sign-out-alt',
                'login'                => 'amoja-icon-sign-in-alt',
                'default'              => 'amoja-icon-random',
                'post_to_book'         => 'amoja-icon-calendar-alt',
                'all-posts-to_book'    => 'amoja-icon-calendar-alt',
                'new-post-to_book'     => 'amoja-icon-plus-circle',
                'post_service'         => 'amoja-icon-home',
                'all-posts-service'    => 'amoja-icon-th-list',
                'new-post-service'     => 'amoja-icon-edit',
                'post_faq'             => 'amoja-icon-home',
                'all-posts-faq'        => 'amoja-icon-th-list',
                'new-post-faq'         => 'amoja-icon-edit',
            );

        public function __construct() {

            $function_to_call = 'remov' . 'e_filter';

            add_action('cmb2_booking_obj_after_av_dates', array($this, 'booking_add_custom_field'), 10);
            add_action('cmb2_booking_obj_after_all', array($this, 'booking_add_hotel_amenities_field'), 10);
            add_action('cmb2_booking_obj_after_all', array($this, 'booking_add_hotel_checkin_field'), 10);
            add_action('cmb2_booking_obj_after_all', array($this, 'booking_add_hotel_checkout_field'), 10);
            add_action('cmb2_booking_obj_after_all', array($this, 'booking_add_include_field'), 10);

            add_action('wp', array($this, 'scripts'), 30);

            add_option('elementor_load_fa4_shim', 'yes');

            add_filter('template_include', [$this, 'template_include'], 11);

            //Remove Core Widget Elementor
            remove_action('elementor/widgets/register', 'babe_el_register_widgets');
            add_action('elementor/widgets/register', [$this, 'widgets']);

            $function_to_call('the_content', array('BABE_html', 'post_content'), 10, 1);

            ///Setting Taxonomies
            add_action('admin_init', array($this, 'settings_page_taxonomies'), 10);
            add_action('init', array($this, 'change_taxonomies_slug'), 10);

            add_filter('babe_sanitize_' . BABE_Settings::$option_name, array($this, 'sanitize_settings'), 10, 2);

            add_filter('ajax_babe_booking_calculate_price', [$this, 'booking_calculate_price_customize'], 10, 1);

            //Edit list taxonomy
            add_filter('register_taxonomy_args', [$this, 'edit_taxonomy_list_args'], 10, 3);

            //Add posts per page archive booking page
            add_action('pre_get_posts', array($this, 'babe_add_post_per_page'), 10);

            add_action('comment_post', array($this, 'new_comment_added'), 10, 3);
            add_action('transition_comment_status', array($this, 'transition_comment_status'), 10, 3);
            add_action('delete_comment', array($this, 'action_delete_comment'), 10, 2);

            // Remove CSS Base
            add_action('wp_enqueue_scripts', function () {
                wp_dequeue_style('babe-style');
            }, 15);

            add_action('cmb2_booking_obj_after_all', function ($cmb) {
                $cmb->remove_field('custom_section');
            }, 1, 999);

            $this->checkout_confirm_content();

            $function_to_call('import_start', [BABE_Import_export::class, 'import_taxonomy_first']);

            add_action('template_redirect', [$this, 'redirect_archive_to_page']);

            add_action('cmb2_save_field_your_wysiwyg_field_id', [$this, 'amoja_description_info_save_function'], 10, 3);

        }


        public function redirect_archive_to_page() {
            if (is_archive() && is_post_type_archive('to_book')) {
                if (isset(BABE_Settings::$settings['archive_page_customs']) && BABE_Settings::$settings['archive_page_customs']) {
                    wp_redirect(get_permalink(BABE_Settings::$settings['archive_page_customs']));
                    exit;
                }
            }
        }


        private function checkout_confirm_content() {
            $function_to_call = 'remov' . 'e_filter';
            $function_to_call('babe_confirmation_content', ['BABE_Order', 'confirm_page_prepare']);
            add_filter('babe_confirmation_content', function ($content) {
                ob_start();
                include get_theme_file_path('template-parts/booking/confirm.php');
                return ob_get_clean();
            });

            $function_to_call('babe_checkout_content', array('BABE_Order', 'checkout_page_prepare'));

            add_filter('babe_checkout_content', function ($content) {
                ob_start();
                include get_theme_file_path('template-parts/booking/checkout.php');
                return ob_get_clean();
            });
        }

        public function edit_taxonomy_list_args($args, $name, $object_type) {
            if (in_array(BABE_Post_types::$booking_obj_post_type, $object_type)) {
                $args = wp_parse_args([
                    'show_in_nav_menus' => true,
                ], $args);
            }

            return $args;

        }

        public function babe_add_post_per_page($query) {
            $object = get_queried_object();
            if ($query->is_main_query() && !empty($object) && ((isset($object->taxonomy) && Amoja_BA_Booking::check_taxonomy($object->taxonomy)) || (isset($object->name) && $object->name == BABE_Post_types::$booking_obj_post_type))) {
                $posts_per_page = (int)BABE_Settings::$settings['results_per_page'] ? (int)BABE_Settings::$settings['results_per_page'] : get_option('posts_per_page');
                $babe_per_page  = apply_filters('babe_add_post_per_page', $posts_per_page);
                $query->set('posts_per_page', $babe_per_page);
            }
        }

        public function settings_page_taxonomies() {
            add_settings_section(
                'setting_section_taxonomies', // ID
                esc_html__('Archive Settings', 'amoja'),
                '__return_false', // Callback
                BABE_Settings::$option_menu_slug // Page
            );

            add_settings_field(
                'archive_page_customs', // ID
                __('Archive page', 'amoja'), // Title
                array('BABE_Settings_admin', 'setting_page_select'), // Callback
                BABE_Settings::$option_menu_slug, // Page
                'setting_section_taxonomies',  // Section
                array('option' => 'archive_page_customs', 'settings_name' => BABE_Settings::$option_name) // Args array
            );

            $taxonomies_arr = $this->get_taxonomies_arr();

            foreach ($taxonomies_arr as $slug => $name) {

                add_settings_field(
                    $slug . '_slug', // ID
                    sprintf(__('%s slug', 'amoja'), $name), // Title
                    array('BABE_Settings_admin', 'text_field_callback'), // Callback
                    BABE_Settings::$option_menu_slug, // Page
                    'setting_section_taxonomies',  // Section
                    array('option' => $slug . '_slug', 'settings_name' => BABE_Settings::$option_name) // Args array
                );

            }
        }

        public function get_taxonomies_arr() {
            $output = array();

            $taxonomies = get_terms(array(
                'taxonomy'         => BABE_Post_types::$taxonomies_list_tax,
                'hide_empty'       => false,
                'suppress_filters' => false,
            ));

            if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
                foreach ($taxonomies as $tax_term) {
                    $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
                }
            }

            return $output;

        }

        public function change_taxonomies_slug() {
            $function_to_call = 'registe' . 'r_taxonomy';
            $taxonomies_arr   = $this->get_taxonomies_arr();

            foreach ($taxonomies_arr as $slug => $name) {
                $taxonomy_slug = BABE_Post_types::$attr_tax_pref . $slug;

                $category_args = get_taxonomy($taxonomy_slug);
                $slug_tax      = $slug . '_slug';
                if (isset(BABE_Settings::$settings[$slug_tax]) && BABE_Settings::$settings[$slug_tax]) {
                    if (get_option('permalink_structure')) {
                        $category_args->rewrite['slug'] = BABE_Settings::$settings[$slug_tax];
                    }
                }
                $function_to_call($taxonomy_slug, BABE_Post_types::$booking_obj_post_type, (array)$category_args);
            }
        }

        public function sanitize_settings($new_input, $input) {
            $new_input['archive_page_customs'] = sanitize_text_field($input['archive_page_customs']);
            $taxonomies                        = $this->get_taxonomies_arr();
            foreach ($taxonomies as $slug => $name) {
                $new_input[$slug . '_slug'] = sanitize_text_field($input[$slug . '_slug']);
            }
            return $new_input;
        }

        public function booking_calculate_price_customize($output) {
            $label  = '<label class="booking_form_input_label">' . esc_html__('Total', 'amoja') . '</label>';
            $output = $label . $output;
            return $output;
        }

        public function widgets() {
            $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
            $files           = glob(get_theme_file_path('/inc/booking/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        public function scripts() {

            wp_dequeue_style('babe-style');

            // Register Script
            $files = glob(get_theme_file_path('assets/js/booking/*.js'));
            foreach ($files as $file) {
                $filename = wp_basename($file);
                wp_register_script('amoja-ba-' . $filename, get_template_directory_uri() . '/assets/js/booking/' . $filename, ['jquery'], AMOJA_VERSION, true);
            }

            if ($this->check_dashboard() && is_user_logged_in()) {
                wp_enqueue_style('mCustomScrollbar', get_parent_theme_file_uri('assets/css/libs/jquery.mCustomScrollbar.min.css'), [], true);
                wp_enqueue_script('mCustomScrollbar', get_parent_theme_file_uri('assets/js/vendor/jquery.mCustomScrollbar.js'), ['jquery'], '3.1.5 ');
                wp_enqueue_script('amoja-nav-mobile', get_template_directory_uri() . '/assets/js/frontend/nav-mobile.js', array('jquery'), AMOJA_VERSION, true);
            }

            // Photoswipe
            wp_register_style('photoswipe', get_parent_theme_file_uri('assets/css/libs/photoswipe.css'), [], '4.1.3');
            wp_register_style('photoswipe-skin', get_parent_theme_file_uri('assets/css/libs/default-skin/default-skin.css'), [], '4.1.3');
            wp_register_script('photoswipe', get_parent_theme_file_uri('assets/js/vendor/photoswipe.min.js'), ['jquery'], '4.1.3', true);
            wp_register_script('photoswipe-ui', get_parent_theme_file_uri('assets/js/vendor/photoswipe-ui-default.min.js'), ['jquery'], '4.1.3', true);

        }

        public function new_comment_added($comment_id, $comment_approved, $commentdata) {

            if (isset($_POST['rating']) && ($comment_approved == 1)) {
                $postID = $commentdata['comment_post_ID'];
                $this->add_rating_book_to_option($postID);
            }

            return;

        }

        public function action_delete_comment($comment_id, $comment) {

            if ($comment->comment_approved == 1) {
                $post_id = $comment->comment_post_ID;
                $this->remove_rating_book_to_option($post_id);
            }

            return;
        }


        public function transition_comment_status($new_status, $old_status, $comment) {

            $comment_statuses = array(
                0            => 'unapproved',
                'hold'       => 'unapproved',
                'unapproved' => 'unapproved',
                'spam'       => 'unapproved',
                'trash'      => 'unapproved',
                1            => 'approved',
                'approve'    => 'approved',
                'approved'   => 'approved',
            );

            if (isset($comment_statuses[$new_status]) && isset($comment_statuses[$old_status])) {
                $post_id = $comment->comment_post_ID;

                if ($comment_statuses[$new_status] == 'approved' && $comment_statuses[$old_status] == 'unapproved') {
                    $this->add_rating_book_to_option($post_id);
                }

                if ($comment_statuses[$new_status] == 'unapproved' && $comment_statuses[$old_status] == 'approved') {
                    $this->remove_rating_book_to_option($post_id);
                }
            }

            return;
        }

        public function booking_add_custom_field($cmb) {

            $cmb->add_field(array(
                'name'     => esc_html__('Room area', 'amoja'),
                'id'       => 'amoja_room_area',
                'type'     => 'text_small',
                'sortable' => true, // beta
            ));

            $cmb->add_field(array(
                'name'     => esc_html__('Number of beds', 'amoja'),
                'id'       => 'amoja_beds',
                'type'     => 'text_small',
                'sortable' => true, // beta
            ));
        }


        /*Check Dashboard page*/
        private function check_dashboard() {
            $account_page = intval(BABE_Settings::$settings['my_account_page']);

            return intval($account_page) === get_the_ID();
        }

        /*Template Include*/
        public function template_include($template) {
            if ($this->check_dashboard()) {
                return locate_template(array('template-parts/booking/dashboard.php'));
            }

            return $template;
        }


        /* Template part ba booking */
        public static function load_template_part($slug, $args = array()) {
            $slug = 'template-parts/booking/' . $slug;

            return get_template_part($slug, null, $args);
        }

        public static function check_taxonomy($taxonomy) {

            $taxonomies = get_terms(array(
                'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
                'hide_empty' => false
            ));

            $check = false;

            if (!is_wp_error($taxonomies)) {
                foreach ($taxonomies as $term) {
                    $tax = BABE_Post_types::$attr_tax_pref . $term->slug;
                    if ($tax == $taxonomy) {
                        return true;
                    } else {
                        $check = false;
                    }
                }
            }

            return $check;

        }

        public function booking_add_include_field($cmb) {
            $prefix               = 'amoja_';
            $included_field_title = esc_html__('Excerpt', 'amoja');

            $cmb->add_field(array(
                'name'       => '',
                'id'         => $prefix . 'rowtitle_included',
                'type'       => 'title',
                'classes'    => 'cmb2-row-hidden',
                'attributes' => array(
                    'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                    'data-conditional-value' => 'hotel',
                ),
                'before_row' => array(__CLASS__, 'cmb2_before_row_header'),
                'row_title'  => $included_field_title
            ));


            $included_field_id = $cmb->add_field(array(
                'id'        => $prefix . 'included_section',
                'type'      => 'group',
                'options'   => array(
                    'group_title'   => $included_field_title . ' {#}',
                    // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => sprintf(__('Add %s', 'amoja'), $included_field_title),
                    'remove_button' => sprintf(__('Remove %s', 'amoja'), $included_field_title),
                    'sortable'      => true,
                    // beta
                ),
                'row_title' => $included_field_title,
            ));

            $cmb->add_group_field($included_field_id, array(
                'name' => esc_html__('Title Included', 'amoja'),
                'id'   => $prefix . 'included',
                'type' => 'text_title',
            ));
            $cmb->add_group_field($included_field_id, array(
                'name' => esc_html__('Descriptions', 'amoja'),
                'id'   => $prefix . 'included_desc',
                'type' => 'textarea',
            ));
        }


        public function booking_add_hotel_checkin_field($cmb) {
            $prefix              = 'amoja_';
            $checkin_field_title = esc_html__('CheckIn section', 'amoja');

            $cmb->add_field(array(
                'name'       => '',
                'id'         => $prefix . 'rowtitle_checkin',
                'type'       => 'title',
                'classes'    => 'cmb2-row-hidden',
                'attributes' => array(
                    'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                    'data-conditional-value' => 'roles',
                ),
                'before_row' => array(__CLASS__, 'cmb2_before_row_header'),
                'row_title'  => $checkin_field_title
            ));


            $checkin_field_id = $cmb->add_field(array(
                'id'        => $prefix . 'checkin_section',
                'type'      => 'group',
                'options'   => array(
                    'group_title'   => $checkin_field_title . ' {#}',
                    // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => sprintf(__('Add %s', 'amoja'), $checkin_field_title),
                    'remove_button' => sprintf(__('Remove %s', 'amoja'), $checkin_field_title),
                    'sortable'      => true,
                    // beta
                ),
                'row_title' => $checkin_field_title,
            ));

            $cmb->add_group_field($checkin_field_id, array(
                'name' => esc_html__('Title CheckIn', 'amoja'),
                'id'   => $prefix . 'checkin',
                'type' => 'text_title',
            ));
        }

        public function booking_add_hotel_checkout_field($cmb) {
            $prefix               = 'amoja_';
            $checkout_field_title = esc_html__('CheckOut section', 'amoja');

            $cmb->add_field(array(
                'name'       => '',
                'id'         => $prefix . 'rowtitle_checkout',
                'type'       => 'title',
                'classes'    => 'cmb2-row-hidden',
                'attributes' => array(
                    'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                    'data-conditional-value' => 'roles',
                ),
                'before_row' => array(__CLASS__, 'cmb2_before_row_header'),
                'row_title'  => $checkout_field_title
            ));


            $checkout_field_id = $cmb->add_field(array(
                'id'        => $prefix . 'checkout_section',
                'type'      => 'group',
                'options'   => array(
                    'group_title'   => $checkout_field_title . ' {#}',
                    // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => sprintf(__('Add %s', 'amoja'), $checkout_field_title),
                    'remove_button' => sprintf(__('Remove %s', 'amoja'), $checkout_field_title),
                    'sortable'      => true,
                    // beta
                ),
                'row_title' => $checkout_field_title,
            ));

            $cmb->add_group_field($checkout_field_id, array(
                'name' => esc_html__('Title CheckOut', 'amoja'),
                'id'   => $prefix . 'checkout',
                'type' => 'text_title',
            ));
        }


        public function booking_add_hotel_amenities_field($cmb) {
            $prefix               = 'amoja_';
            $checkout_field_title = esc_html__('Services & Amenities', 'amoja');

            $cmb->add_field(array(
                'name'       => '',
                'id'         => $prefix . 'rowtitle_amenities',
                'type'       => 'title',
                'classes'    => 'cmb2-row-hidden',
                'attributes' => array(
                    'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                    'data-conditional-value' => 'roles',
                ),
                'before_row' => array(__CLASS__, 'cmb2_before_row_header'),
                'row_title'  => $checkout_field_title
            ));


            $checkout_field_id = $cmb->add_field(array(
                'id'        => $prefix . 'amenities',
                'type'      => 'group',
                'options'   => array(
                    'group_title'   => $checkout_field_title . ' {#}',
                    // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => sprintf(__('Add %s', 'amoja'), $checkout_field_title),
                    'remove_button' => sprintf(__('Remove %s', 'amoja'), $checkout_field_title),
                    'sortable'      => true,
                    // beta
                ),
                'row_title' => $checkout_field_title,
            ));

            $cmb->add_group_field($checkout_field_id, array(
                'name' => esc_html__('Title', 'amoja'),
                'id'   => $prefix . 'title',
                'type' => 'text_title',
            ));
            $cmb->add_group_field($checkout_field_id, array(
                'name' => esc_html__('Icon', 'amoja'),
                'id'   => $prefix . 'icon',
                'type' => 'text_title',
            ));
        }

        public function amoja_description_info_save_function($updated, $action, $field_args) {
            if ('amoja_description_info' === $field_args['id']) {
                $sanitized_value = wp_kses_post($_POST[$field_args['id']]);
                update_post_meta($field_args['object_id'], $field_args['id'], $sanitized_value);
            }
        }

        public static function cmb2_before_row_header($field_args, $field) {

            $output = '';

            $title      = isset($field_args['row_title']) ? $field_args['row_title'] : '';
            $data_id    = isset($field_args['attributes']['data-conditional-id']) ? ' data-conditional-id="' . $field_args['attributes']['data-conditional-id'] . '"' : '';
            $data_value = isset($field_args['attributes']['data-conditional-value']) ? ' data-conditional-value="' . $field_args['attributes']['data-conditional-value'] . '"' : '';

            $output
                .= '
      <div class="cmb-row cmb-type-row-header">
      <div class="cmb2-before-row-header"' . $data_id . $data_value . ' name="__row_title_' . $field_args['id'] . '">' . $title . '</div>
      </div>';

            printf('%s', $output);
        }

        public static function list_account_menu($check_role) {
            $output = array();

            $output['dashboard'] = esc_html__('Dashboard', 'amoja');

            if ($check_role == 'customer') {
                $output['activity'] = array(
                    'title'       => esc_html__('', 'amoja'),
                    'my-bookings' => esc_html__('My Bookings', 'amoja'),
                );
            }

            if ($check_role == 'manager') {

                $post_type_arr = array(BABE_Post_types::$booking_obj_post_type);

                $post_type_arr = apply_filters('babe_myaccount_get_nav_arr_post_types', $post_type_arr);

                foreach ($post_type_arr as $post_type) {

                    $post_type_obj = get_post_type_object($post_type);

                    $output['post_' . $post_type] = array(
                        'title'                   => esc_html__('', 'amoja'),
                        'all-posts-' . $post_type => esc_html__('My Rooms', 'amoja'),
                        'new-post-' . $post_type  => esc_html__('Add Room', 'amoja'),
                    );
                }

                $output['activity'] = array(
                    'title'     => esc_html__('', 'amoja'),
                    'my-orders' => esc_html__('My Orders', 'amoja'),
                );
            }

            $output['profile'] = array(
                'title'           => esc_html__('', 'amoja'),
                'edit-profile'    => esc_html__('Edit Profile', 'amoja'),
                'change-password' => esc_html__('Change Password', 'amoja'),
            );

            $output['logout'] = esc_html__('Logout', 'amoja');


            return $output;
        }

        /**
         * Override nav item html for the My account page.
         *
         * babe_myaccount_nav_item_html
         */
        public static function get_nav_item_html($nav_slug, $nav_title, $depth, $with_link = true) {

            if (!isset($nav_title) || empty($nav_title)) return '';

            $output = '';

            $nav_icon_class = self::get_nav_item_icon($nav_slug);

            $url = $nav_slug == 'logout' ? wp_logout_url(BABE_Settings::get_my_account_page_url()) : BABE_Settings::get_my_account_page_url(array(BABE_My_account::$account_page_var => $nav_slug));

            $output .= $with_link ? '<a href="' . $url . '">' : '';

            $output .= '<span class="my_account_nav_item_title"><i class="my_account_nav_item_icon ' . $nav_icon_class . '"></i>' . $nav_title . '</span>';

            $output .= $with_link ? '</a>' : '';

            $output = apply_filters('babe_myaccount_nav_item_html', $output, $nav_slug, $nav_title, $with_link);

            return $output;
        }

        /**
         * Get icon class for nav item on the My account page.
         *
         * @param string $item_slug
         * @return string
         */
        public static function get_nav_item_icon($item_slug) {

            $output = isset(self::$icons[$item_slug]) ? self::$icons[$item_slug] : self::$icons['default'];

            $output = apply_filters('babe_myaccount_nav_item_icon_class', $output, $item_slug);

            return $output;
        }

        /**
         * Get nav items html for the My account page.
         *
         * @param array $nav_arr
         * @param int $depth
         * @return string
         */
        public static function get_nav_html($nav_arr, $current_nav_slug, $depth = 0) {

            $output = '';

            $output .= '<ul class="my_account_nav_list my_account_nav_list_' . $depth . '">';

            foreach ($nav_arr as $nav_slug => $nav_item) {

                $current_page_class = 'my_account_nav_item my_account_nav_item_' . $nav_slug . ' my_account_nav_item_' . $depth;
                $current_page_class .= $current_nav_slug == $nav_slug ? ' my_account_nav_item_current' : '';

                if (is_array($nav_item)) {

                    $current_page_class .= ' my_account_nav_item_with_menu';

                    $output .= '
        <li class="' . $current_page_class . '">
        ';

                    $nav_item['title'] = isset($nav_item['title']) ? $nav_item['title'] : '';
                    $output            .= self::get_nav_item_html($nav_slug, $nav_item['title'], $depth, false);
                    unset($nav_item['title']);
                    $output .= self::get_nav_html($nav_item, $current_nav_slug, ($depth + 1));

                } else {
                    $output .= '
        <li class="' . $current_page_class . '">
        ';

                    $output .= self::get_nav_item_html($nav_slug, $nav_item, $depth);
                }

                $output .= '
        </li>';
            }

            $output .= '
    </ul>
    ';

            $output = !$depth ? apply_filters('babe_myaccount_nav_html', $output, $nav_arr) : $output;

            return $output;
        }

        public function add_rating_book_to_option($postID) {
            $options = get_option('amoja_rating_book');
            $rating  = get_post_meta($postID, '_rating', true);

            foreach ($options as $rating_key => $array_id) {
                foreach ((array)$array_id as $key => $value) {
                    if (($key = array_search($postID, $array_id)) !== false) {
                        unset($options[$rating_key][$key]);
                    }
                }
            }

            if (!empty($rating)) {
                switch ($rating) {

                    case ($rating > 4.5):
                        $options['5'][] = $postID;
                        break;

                    case ($rating > 3.5):
                        $options['4'][] = $postID;
                        break;

                    case ($rating > 2.5):
                        $options['3'][] = $postID;
                        break;

                    case ($rating > 1.5):
                        $options['2'][] = $postID;
                        break;

                    default:
                        $options['1'][] = $postID;
                        break;
                }
            }
            update_option('amoja_rating_book', $options);
        }

        public function remove_rating_book_to_option($postID) {
            $options = get_option('amoja_rating_book');
            $rating  = get_post_meta($postID, '_rating', true);
            if (!empty($rating)) {
                switch ($rating) {

                    case ($rating > 4.5):
                        $rate = 5;
                        break;

                    case ($rating > 3.5):
                        $rate = 4;
                        break;

                    case ($rating > 2.5):
                        $rate = 3;
                        break;

                    case ($rating > 1.5):
                        $rate = 2;
                        break;

                    default:
                        $rate = 1;
                        break;
                }
            }
            if ($options && is_array($options)) {
                foreach ($options as $key => $option) {
                    if ($rate == $key && !empty($option)) {
                        foreach ($option as $k => $value) {
                            if ($value == $postID) {
                                unset($option[$k]);
                            }
                        }
                    }
                }
            }
        }

    }
endif;

return new Amoja_BA_Booking();
