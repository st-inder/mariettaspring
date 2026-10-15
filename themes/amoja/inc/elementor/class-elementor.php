<?php

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Amoja_Elementor')) :

    /**
     * The Amoja Elementor Integration class
     */
    class Amoja_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('elementor/widgets/register', array($this, 'customs_widgets'));
            add_action('elementor/widgets/register', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native']);
            add_action('elementor/controls/controls_registered', [$this, 'add_icons']);

            if (!amoja_is_elementor_pro_activated()) {
                require trailingslashit(get_template_directory()) . 'inc/elementor/custom-css.php';
                require trailingslashit(get_template_directory()) . 'inc/elementor/sticky-section.php';
                if (is_admin()) {
                    add_action('manage_elementor_library_posts_columns', [$this, 'admin_columns_headers']);
                    add_action('manage_elementor_library_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);
                }
                require get_theme_file_path('inc/elementor/motion-fx/controls-group.php');
                require get_theme_file_path('inc/elementor/motion-fx/module.php');
            }

            require get_theme_file_path('inc/elementor/modules/page-settings.php');
            require get_theme_file_path('inc/elementor/modules/header-settings.php');


            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);
            add_action('wp_enqueue_scripts', [$this, 'elementor_kit']);
        }

        public function elementor_kit() {
            $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
            Elementor\Plugin::$instance->kits_manager->frontend_before_enqueue_styles();
            $myvals = get_post_meta($active_kit_id, '_elementor_page_settings', true);
            if (!empty($myvals)) {
                $css = '';
                foreach ($myvals['system_colors'] as $key => $value) {
                    $css .= $value['color'] !== '' ? '--' . $value['_id'] . ':' . $value['color'] . ';' : '';
                }

                $var = "body{{$css}}";
                wp_add_inline_style('amoja-style', $var);
            }
        }

        public function additional_fonts($fonts) {
            $fonts['Ortica Linear'] = 'system';
            return $fonts;
        }

        public function admin_columns_headers($defaults) {
            $defaults['shortcode'] = esc_html__('Shortcode', 'amoja');

            return $defaults;
        }

        public function admin_columns_content($column_name, $post_id) {
            if ('shortcode' === $column_name) {
                ob_start();
                ?>
                <input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="[etb_template id='<?php echo esc_attr($post_id); ?>']"/>
                <?php
                ob_get_contents();
            }
        }

        public function add_js() {

            wp_enqueue_script('amoja-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), [], AMOJA_VERSION);
        }

        public function add_style_editor() {

            wp_enqueue_style('amoja-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], AMOJA_VERSION);
        }

        public function add_scripts() {

            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_enqueue_style('amoja-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', AMOJA_VERSION);
            wp_style_add_data('amoja-elementor', 'rtl', 'replace');

            // Add Scripts
            wp_enqueue_style('e-swiper');
            $e_swiper_latest     = Plugin::$instance->experiments->is_feature_active('e_swiper_latest');
            $e_swiper_asset_path = $e_swiper_latest ? 'assets/lib/swiper/v8/' : 'assets/lib/swiper/';
            $e_swiper_version    = $e_swiper_latest ? '8.4.5' : '5.3.6';
            wp_register_script(
                'swiper',
                plugins_url('elementor/' . $e_swiper_asset_path . 'swiper.js', 'elementor'),
                [],
                $e_swiper_version,
                true
            );
        }

        public function register_auto_scripts_frontend() {
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_register_script('amoja-elementor-swiper', get_theme_file_uri('/assets/js/elementor-swiper' . $suffix . '.js'), array('jquery', 'elementor-frontend'), AMOJA_VERSION, true);
            // Register auto scripts frontend

            $files = glob(get_theme_file_path('/assets/js/elementor/*' . $suffix . '.js'));
            foreach ($files as $file) {
                $file_name = wp_basename($file);
                $handle    = str_replace($suffix . ".js", '', $file_name);
                $scr       = get_theme_file_uri('/assets/js/elementor/' . $file_name);
                if (file_exists($file)) {
                    wp_register_script('amoja-elementor-' . $handle, $scr, ['jquery', 'elementor-frontend'], AMOJA_VERSION, true);
                }
            }
        }

        public function register_widget_category($this_cat) {
            $this_cat->add_category(
                'amoja-addons',
                [
                    'title' => esc_html__('Amoja Addons', 'amoja'),
                    'icon'  => 'fa fa-plug',
                ]
            );
            return $this_cat;
        }

        public function add_animations_scroll($animations) {
            $animations['Amoja Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        public function customs_widgets() {
            $files = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            require 'base-swiper-widget.php';
            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }


        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"amoja-icon-24h":"24h","amoja-icon-ambassador":"ambassador","amoja-icon-angle-down":"angle-down","amoja-icon-angle-left":"angle-left","amoja-icon-angle-right":"angle-right","amoja-icon-angle-up":"angle-up","amoja-icon-arrow-down":"arrow-down","amoja-icon-arrow-left":"arrow-left","amoja-icon-arrow-right":"arrow-right","amoja-icon-arrow-small-left":"arrow-small-left","amoja-icon-arrow-small-right":"arrow-small-right","amoja-icon-arrow-small-up":"arrow-small-up","amoja-icon-arrow-up":"arrow-up","amoja-icon-barbell":"barbell","amoja-icon-bed":"bed","amoja-icon-bell":"bell","amoja-icon-calendar-1":"calendar-1","amoja-icon-calendar-bold":"calendar-bold","amoja-icon-calendar":"calendar","amoja-icon-check-verified":"check-verified","amoja-icon-check":"check","amoja-icon-checkbox-circle-fill":"checkbox-circle-fill","amoja-icon-cinema":"cinema","amoja-icon-clock-time":"clock-time","amoja-icon-coffee":"coffee","amoja-icon-compass":"compass","amoja-icon-contacts-book":"contacts-book","amoja-icon-coupon":"coupon","amoja-icon-credit-check":"credit-check","amoja-icon-dining":"dining","amoja-icon-double-bed":"double-bed","amoja-icon-double-bed1":"double-bed1","amoja-icon-dryer":"dryer","amoja-icon-email-2":"email-2","amoja-icon-email":"email","amoja-icon-encil-ruler":"encil-ruler","amoja-icon-envelope-fill":"envelope-fill","amoja-icon-file-list":"file-list","amoja-icon-flag":"flag","amoja-icon-flower":"flower","amoja-icon-globe":"globe","amoja-icon-headphone-line":"headphone-line","amoja-icon-heart":"heart","amoja-icon-home-smile":"home-smile","amoja-icon-hot-air":"hot-air","amoja-icon-hotel-2":"hotel-2","amoja-icon-hotel":"hotel","amoja-icon-image":"image","amoja-icon-location-1":"location-1","amoja-icon-location":"location","amoja-icon-lotus":"lotus","amoja-icon-mail":"mail","amoja-icon-map-pin-line":"map-pin-line","amoja-icon-map-pin":"map-pin","amoja-icon-maximize":"maximize","amoja-icon-menu":"menu","amoja-icon-parking-area":"parking-area","amoja-icon-phone-1":"phone-1","amoja-icon-phone-call":"phone-call","amoja-icon-phone":"phone","amoja-icon-plane":"plane","amoja-icon-play-fill":"play-fill","amoja-icon-plus-slim":"plus-slim","amoja-icon-quote-1":"quote-1","amoja-icon-quote":"quote","amoja-icon-safebox":"safebox","amoja-icon-serving-cart":"serving-cart","amoja-icon-share":"share","amoja-icon-star-1":"star-1","amoja-icon-suitcase-1":"suitcase-1","amoja-icon-suitcase":"suitcase","amoja-icon-sunrise":"sunrise","amoja-icon-swimming":"swimming","amoja-icon-telephone":"telephone","amoja-icon-towel-rack":"towel-rack","amoja-icon-turndown":"turndown","amoja-icon-user-check":"user-check","amoja-icon-user-circle":"user-circle","amoja-icon-users":"users","amoja-icon-users1":"users1","amoja-icon-wifi":"wifi","amoja-icon-360":"360","amoja-icon-bars":"bars","amoja-icon-calendar-alt":"calendar-alt","amoja-icon-cart-empty":"cart-empty","amoja-icon-check-square":"check-square","amoja-icon-circle":"circle","amoja-icon-cloud-download-alt":"cloud-download-alt","amoja-icon-comment":"comment","amoja-icon-comments":"comments","amoja-icon-contact":"contact","amoja-icon-credit-card":"credit-card","amoja-icon-dot-circle":"dot-circle","amoja-icon-edit":"edit","amoja-icon-envelope":"envelope","amoja-icon-expand-alt":"expand-alt","amoja-icon-external-link-alt":"external-link-alt","amoja-icon-file-alt":"file-alt","amoja-icon-file-archive":"file-archive","amoja-icon-folder-open":"folder-open","amoja-icon-folder":"folder","amoja-icon-frown":"frown","amoja-icon-gift":"gift","amoja-icon-grid":"grid","amoja-icon-grip-horizontal":"grip-horizontal","amoja-icon-heart-fill":"heart-fill","amoja-icon-history":"history","amoja-icon-home":"home","amoja-icon-info-circle":"info-circle","amoja-icon-instagram":"instagram","amoja-icon-level-up-alt":"level-up-alt","amoja-icon-list":"list","amoja-icon-map-marker-check":"map-marker-check","amoja-icon-meh":"meh","amoja-icon-minus-circle":"minus-circle","amoja-icon-minus":"minus","amoja-icon-mobile-android-alt":"mobile-android-alt","amoja-icon-money-bill":"money-bill","amoja-icon-pencil-alt":"pencil-alt","amoja-icon-plus-circle":"plus-circle","amoja-icon-plus":"plus","amoja-icon-random":"random","amoja-icon-reply-all":"reply-all","amoja-icon-reply":"reply","amoja-icon-search":"search","amoja-icon-shield-check":"shield-check","amoja-icon-shopping-basket":"shopping-basket","amoja-icon-shopping-cart":"shopping-cart","amoja-icon-sign-out-alt":"sign-out-alt","amoja-icon-smile":"smile","amoja-icon-spinner":"spinner","amoja-icon-square":"square","amoja-icon-star":"star","amoja-icon-store":"store","amoja-icon-sync":"sync","amoja-icon-tachometer-alt":"tachometer-alt","amoja-icon-th-list":"th-list","amoja-icon-thumbtack":"thumbtack","amoja-icon-ticket":"ticket","amoja-icon-times-circle":"times-circle","amoja-icon-times-square":"times-square","amoja-icon-times":"times","amoja-icon-trophy-alt":"trophy-alt","amoja-icon-truck":"truck","amoja-icon-unlock":"unlock","amoja-icon-video":"video","amoja-icon-wishlist-empty":"wishlist-empty","amoja-icon-adobe":"adobe","amoja-icon-amazon":"amazon","amoja-icon-android":"android","amoja-icon-angular":"angular","amoja-icon-apper":"apper","amoja-icon-apple":"apple","amoja-icon-atlassian":"atlassian","amoja-icon-behance":"behance","amoja-icon-bitbucket":"bitbucket","amoja-icon-bitcoin":"bitcoin","amoja-icon-bity":"bity","amoja-icon-bluetooth":"bluetooth","amoja-icon-btc":"btc","amoja-icon-centos":"centos","amoja-icon-chrome":"chrome","amoja-icon-codepen":"codepen","amoja-icon-cpanel":"cpanel","amoja-icon-discord":"discord","amoja-icon-dochub":"dochub","amoja-icon-docker":"docker","amoja-icon-dribbble":"dribbble","amoja-icon-dropbox":"dropbox","amoja-icon-drupal":"drupal","amoja-icon-ebay":"ebay","amoja-icon-facebook-f":"facebook-f","amoja-icon-facebook":"facebook","amoja-icon-figma":"figma","amoja-icon-firefox":"firefox","amoja-icon-google-plus":"google-plus","amoja-icon-google":"google","amoja-icon-grunt":"grunt","amoja-icon-gulp":"gulp","amoja-icon-html5":"html5","amoja-icon-joomla":"joomla","amoja-icon-link-brand":"link-brand","amoja-icon-linkedin":"linkedin","amoja-icon-mailchimp":"mailchimp","amoja-icon-opencart":"opencart","amoja-icon-paypal":"paypal","amoja-icon-pinterest-p":"pinterest-p","amoja-icon-pinterest-r":"pinterest-r","amoja-icon-reddit":"reddit","amoja-icon-skype":"skype","amoja-icon-slack":"slack","amoja-icon-snapchat":"snapchat","amoja-icon-spotify":"spotify","amoja-icon-trello":"trello","amoja-icon-twitter-x":"twitter-x","amoja-icon-twitter":"twitter","amoja-icon-vimeo":"vimeo","amoja-icon-whatsapp":"whatsapp","amoja-icon-wordpress":"wordpress","amoja-icon-yoast":"yoast","amoja-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {

            $tabs['opal-custom'] = [
                'name'          => 'amoja-icon',
                'label'         => esc_html__('Amoja Icon', 'amoja'),
                'prefix'        => 'amoja-icon-',
                'displayPrefix' => 'amoja-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => AMOJA_VERSION,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];

            return $tabs;
        }
    }

endif;

return new Amoja_Elementor();
