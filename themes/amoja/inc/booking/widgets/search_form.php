<?php

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Amoja_BABE_Elementor_Searchform_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-search-form';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('BA Search form', 'amoja');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-site-search';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['search'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }


    public function get_script_depends() {
        return ['amoja-ba-search-form.js'];
    }


    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'taxonomy_slug',
            array(
                'label'       => esc_html__('Ba Taxonomies', 'amoja'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'multiple'    => true,
                'options'     => $this->get_taxonomies_arr(),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'taxonomy_title',
            [
                'label'       => esc_html__('Taxonomy Title', 'amoja'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Title Item', 'amoja'),
                'default'     => esc_html__('Title Item', 'amoja'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        // Get all terms of categories
        $this->start_controls_section(
            'babe_taxonomies',
            array(
                'label' => esc_html__('Content', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'sort',
            [
                'label'   => esc_html__('Filter by', 'amoja'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'title'  => esc_html__('Title', 'amoja'),
                    'price'  => esc_html__('Price', 'amoja'),
                    'rating' => esc_html__('Rating', 'amoja'),
                ],
            ]
        );

        $this->add_control(
            'sort_by',
            [
                'label'   => esc_html__('Sort by', 'amoja'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'amoja'),
                    'desc' => esc_html__('DESC', 'amoja'),
                ],
            ]
        );

        $this->add_control(
            'enable_title',
            array(
                'label'       => esc_html__('Show Title', 'amoja'),
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'render_type' => 'template',
                'label_on'    => 'Show',
                'label_off'   => 'Hide',
            )
        );

        $this->add_control(
            'view',
            [
                'label'        => esc_html__('Layout', 'amoja'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'inline',
                'render_type'  => 'template',
                'options'      => [
                    'traditional' => [
                        'title' => esc_html__('Default', 'amoja'),
                        'icon'  => 'eicon-editor-list-ul',
                    ],
                    'inline'      => [
                        'title' => esc_html__('Inline', 'amoja'),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                ],
                'prefix_class' => 'taxonomies-search-layout-',
            ]
        );

        $this->add_control(
            'drop_position',
            [
                'label'        => esc_html__('Dropdown Position', 'amoja'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'bottom',
                'render_type'  => 'template',
                'options'      => [
                    'top'    => [
                        'title' => esc_html__('Top', 'amoja'),
                        'icon'  => 'eicon-align-end-v',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'amoja'),
                        'icon'  => 'eicon-align-start-v',
                    ],
                ],
                'prefix_class' => 'taxonomies-search-dropdown-',
            ]
        );


        $this->add_control(
            'taxonomy_search',
            [
                'label'  => esc_html__('Taxonomy Search', 'amoja'),
                'type'   => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        /// Date Config//
        $this->start_controls_section(
            'babe_date_from',
            [
                'label' => esc_html__('Date From', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'date_from',
            [
                'label'     => esc_html__('Show Date', 'amoja'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide'
            ]
        );

        $this->add_control(
            'date_from_title',
            [
                'label'     => esc_html__('Date title', 'amoja'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Check in', 'amoja'),
                'condition' => [
                    'date_from' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'babe_date_to',
            [
                'label' => esc_html__('Date To', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'date_to',
            [
                'label'     => esc_html__('Show Date', 'amoja'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide'
            ]
        );

        $this->add_control(
            'date_to_title',
            [
                'label'     => esc_html__('Date title', 'amoja'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Check out', 'amoja'),
                'condition' => [
                    'date_to' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        /// Guests Config//
        $this->start_controls_section(
            'babe_guests',
            array(
                'label' => esc_html__('Guests', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'guests',
            array(
                'label'     => esc_html__('Show Guests', 'amoja'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide'
            )
        );

        $this->add_control(
            'guests_title',
            array(
                'label'     => esc_html__('Guests title', 'amoja'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Guests', 'amoja'),
                'condition' => [
                    'guests' => 'yes',
                ]
            )
        );


        $this->end_controls_section();

        /// Search Config//
        $this->start_controls_section(
            'babe_search',
            array(
                'label' => esc_html__('Search button', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'search_title',
            array(
                'label'   => esc_html__('Search title', 'amoja'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Check Rates', 'amoja'),
            )
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'style_content',
            [
                'label' => esc_html__('Content ', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #search_form .field-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label'     => esc_html__('Value Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #search_form  .search_guests_title_value,{{WRAPPER}} #search_form .add_ids_title_value,{{WRAPPER}} #search_form .input-group input,{{WRAPPER}} #search_form i.js-amoja-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #search_form .field-group-inner' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wrap_border_color',
            [
                'label'     => esc_html__('Border Wrap Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #search_form .search-form-inner' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function render() {

        $settings = $this->get_settings_for_display();

        $action = BABE_Settings::get_search_result_page_url();

        $count = 0;

        $search_tax = '';

        if (!empty($settings['taxonomy_search']) && is_array($settings['taxonomy_search'])) {
            foreach ($settings['taxonomy_search'] as $taxonomy_search) {
                if ($taxonomy_result = $this->show_taxonomy_search($taxonomy_search)) {
                    $search_tax .= $taxonomy_result;
                    $count++;
                }
            }
        }

        if ($date_from = $this->show_date_from()) {
            $count++;
        }

        if ($date_to = $this->show_date_to()) {
            $count++;
        }

        if ($guest = $this->show_guest()) {
            $count++;
        }

        $search_title = ($settings['search_title'] && !empty($settings['search_title'])) ? $settings['search_title'] : esc_html__('Search', 'amoja');

        $sort_by = $settings['sort'] . '_' . $settings['sort_by'];

        $selected_terms = isset($_GET['terms']) ? (array)$_GET['terms'] : array();

        ?>

        <div id="amoja-search-box" class="babe-search-box <?php if ($settings['enable_title'] == 'yes') { ?> taxonomies-search-enable-title-yes <?php } ?>">
            <form name="search_form" action="<?php echo esc_url($action); ?>" method="get" id="search_form" class="babe-search-form">
                <div class="search-form-inner">
                    <div class="input-group col-<?php echo esc_attr($count); ?>">
                        <?php
                        if (!empty($search_tax)) {
                            printf('%s', $search_tax);
                        }
                        if (!empty($date_from)) {
                            printf('<div class="field-search-group">%s</div>', $date_from);
                        }

                        if (!empty($date_to)) {
                            printf('<div class="field-search-group">%s</div>', $date_to);
                        }
                        if (!empty($guest)) {
                            printf('<div class="field-search-group">%s</div>', $guest);
                        }
                        ?>
                    </div>
                    <div class="submit">
                        <button name="submit" class="btn button btn-primary btn-search" value="1">
                            <?php echo '<span>' . esc_html($search_title) . '</span><i class="amoja-icon-arrow-right"></i>'; ?>
                        </button>
                    </div>
                    <input type="hidden" name="request_search_results" value="1">
                    <input type="hidden" name="search_results_sort_by" value="<?php echo esc_attr($sort_by); ?>">
                    <?php if ($selected_terms): ?>
                        <?php foreach ($selected_terms as $term): ?>
                            <input type="hidden" name="terms[<?php echo esc_attr($term); ?>]" value="<?php echo esc_attr($term); ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </form>
        </div>
        <?php

        return;

    }

    private function show_taxonomy_search($taxonomy_search) {
        $settings     = $this->get_settings_for_display();
        $layout       = $settings['view'];
        $enable_title = $settings['enable_title'];
        $results      = '';

        if ($taxonomy_search['taxonomy_slug']) {

            $title = ($taxonomy_search['taxonomy_title'] && !empty($taxonomy_search['taxonomy_title'])) ? $taxonomy_search['taxonomy_title'] : esc_html__('Title Search', 'amoja');

            $taxonomy_name = $this->get_taxonomy_slug($taxonomy_search['taxonomy_slug']);

            $selected = isset($_GET['add_ids_' . $taxonomy_name]) ? (int)$_GET['add_ids_' . $taxonomy_name] : 0;
            if ($selected) {
                $taxonomy_selected_arr[$selected] = $selected;
            }

            $taxonomy = get_taxonomy($taxonomy_name);

            if (!is_wp_error($taxonomy) && !empty($taxonomy)) {

                $selected_term_name = $title;

                if ($selected) {

                    $selected_term = get_term_by('id', $selected, $taxonomy_name);
                    if (!empty($selected_term) && !is_wp_error($selected_term)) {
                        $selected_term_name = $selected_term->name;
                    }

                }

                $args    = array(
                    'taxonomy'            => $taxonomy_name,
                    'parent_term_id'      => 0,
                    'view'                => 'list', // 'select', 'multicheck' or 'list'
                    'add_count'           => '',
                    'option_all'          => 1,
                    'level'               => 0,
                    'option_all_value'    => 0,
                    'option_all_title'    => sprintf(esc_html__('All %s', 'amoja'), $this->get_taxonomy_name($taxonomy_search['taxonomy_slug'])),
                    'id'                  => 'add_ids_list_' . $taxonomy_name,
                    'class'               => 'add_ids_list',
                    'class_item'          => 'term_item',
                    'class_item_selected' => 'term_item_selected',
                    'name'                => '',
                    'prefix_char'         => ' ',
                    'term_id_name'        => 'term_id',
                );
                $results .= '<div class="field-search-group"><div class="field-group-inner">';
                $results .= '<div class="field-search">';
                if (!empty($title) && $enable_title == 'yes') {
                    $results .= '<div class="field-title advanced-header">' . $title . '</div>';
                }
                $results .= '<div class="add_input_field is-active" data-tax="' . $taxonomy_name . '" tabindex="0"><div class="add_ids_title">';
                $results .= '<div class="add_ids_title_value search_title_value">' . esc_html($selected_term_name) . '</div>';
                $results .= BABE_Post_types::get_terms_children_hierarchy($args, array($selected));
                $results .= '<input type="hidden" class="input_select_input_value " name="add_ids_' . $taxonomy_name . '" value="' . esc_attr($selected) . '"><i class="js-amoja-icon amoja-icon amoja-icon-arrow-down"></i>';
                $results .= '</div></div></div></div></div>';

                return $results;
            }

        }

        return $results;

    }


    private function show_date_from() {
        $settings              = $this->get_settings_for_display();
        $layout                = $settings['view'];
        $enable_title          = $settings['enable_title'];
        $date_from_title       = ($settings['date_from_title'] && !empty($settings['date_from_title'])) ? esc_attr($settings['date_from_title']) : esc_attr__('Check in', 'amoja');
        $date_from_placeholder = $date_from_title;
        $date_from             = '';
        $date_from_value       = isset($_GET['date_from']) ? $_GET['date_from'] : '';
        if ($settings['date_from']) {
            $date_from .= '<div class="field-group-inner date-block">';
            $date_from .= '<div class="field-search">';
            if (!empty($date_from_title) && $enable_title == 'yes') {
                $date_from             .= '<div class="field-title advanced-header">' . $date_from_title . '</div>';
                $date_from_placeholder = esc_html__('Select Date', 'amoja');
            }
            $date_from .= '<div class="search_date_wrapper search_date_wrapper_date_from">';
            $date_from .= '<input type="text" class="search_date search_title_value" id="date_from" name="date_from" value="' . $date_from_value . '" placeholder="' . $date_from_placeholder . '"><i class="js-amoja-icon amoja-icon amoja-icon-arrow-down"></i>';
            $date_from .= '</div></div></div>';
        }

        return $date_from;
    }

    private function show_date_to() {
        $settings            = $this->get_settings_for_display();
        $layout              = $settings['view'];
        $enable_title        = $settings['enable_title'];
        $date_to_title       = ($settings['date_to_title'] && !empty($settings['date_to_title'])) ? esc_attr($settings['date_to_title']) : esc_attr__('Check out', 'amoja');
        $date_to_placeholder = $date_to_title;
        $date_to             = '';
        $date_to_value       = isset($_GET['date_to']) ? $_GET['date_to'] : '';
        if ($settings['date_to']) {
            $date_to .= '<div class="field-group-inner"><div class="field-search">';
            if (!empty($date_to_title) && $enable_title == 'yes') {
                $date_to             .= '<div class="field-title advanced-header">' . $date_to_title . '</div>';
                $date_to_placeholder = esc_html__('Select Date', 'amoja');
            }
            $date_to .= '<div class="search_date_wrapper search_date_wrapper_date_to" data-active-0="1">';
            $date_to .= '<input type="text" class="search_date search_title_value" id="date_to" name="date_to" value="' . $date_to_value . '" placeholder="' . $date_to_placeholder . '"><i class="js-amoja-icon amoja-icon amoja-icon-arrow-down"></i>';
            $date_to .= '</div></div></div>';
        }

        return $date_to;
    }

    private function show_guest() {

        $settings          = $this->get_settings_for_display();
        $layout            = $settings['view'];
        $enable_title      = $settings['enable_title'];
        $guest             = '';
        $output_guests_div = '';

        ///// guests selection
        $ages_arr = BABE_Post_types::get_ages_arr();

        if ($settings['guests']) {

            $guest_title  = ($settings['guests_title'] && !empty($settings['guests_title'])) ? $settings['guests_title'] : esc_html__('Guests', 'amoja');
            $guest_value  = $guest_title;
            $guest_totals = 0;
            if (!empty($ages_arr)) {

                foreach ($ages_arr as $age_term) {
                    $age_selected_value = isset($_GET['guests'][$age_term['age_id']]) ? absint($_GET['guests'][$age_term['age_id']]) : 0;
                    $guest_totals       += $age_selected_value;
                    $output_guests_div  .= ' <div class="input_select_field input_select_field_guests" data-name="guests[' . $age_term['age_id'] . ']">
                              
                              <span class="select_guests_title">' . esc_html($age_term['name']) . '</span>
                              <span class="search_guests_minus btn-search-guests-change btn btn-secondary-outlined" tabindex="0"><i class="fas fa-minus"></i></span>
                              <span class="select_guests_value">' . esc_html($age_selected_value) . '</span>
                              <span class="search_guests_plus btn-search-guests-change btn btn-secondary-outlined" tabindex="0"><i class="fas fa-plus"></i></span>
                              <input type="hidden" class="select_guests_input_value" name="guests[' . $age_term['age_id'] . ']" value="' . esc_attr($age_selected_value) . '">
                           </div>';
                }
            }

            if ($output_guests_div) {
                $guest .= '<div class="field-group-inner">';
                $guest .= '<div class="field-search">';
                if (!empty($guest_title) && $enable_title == 'yes') {
                    $guest       .= '<div class="field-title advanced-header">' . esc_html($guest_title) . '</div>';
                    $guest_value = 0;
                }
                if ($guest_totals != 0) {
                    $guest_value = $guest_totals;
                }
                $guest .= '<div class="guest-block search_guests_field "> <span class="search_guests_title_value search_title_value search_guests_title">' . esc_html($guest_value) . '<i class="js-amoja-icon amoja-icon amoja-icon-arrow-down"></i></span>
                                        <div class="search_guests_select_wrapper close_by_apply_btn">
                                            ' . $output_guests_div . '
                                        </div>
                                       </div>
                                    </div>
                                </div>';
            }

        }

        return $guest;
    }


    public static function get_taxonomies_arr() {
        $output = array();

        $taxonomies = get_terms(array(
            'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;

    }

    private function get_taxonomy_name($taxonomy_slug) {

        $default_lang = BABE_Functions::get_default_language();
        $current_lang = BABE_Functions::get_current_language();
        if (BABE_Functions::is_wpml_active() && $current_lang !== $default_lang) {
            do_action('wpml_switch_language', $default_lang);
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
            do_action('wpml_switch_language', $current_lang);
        } else {
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        }

        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            return $taxonomy->name;
        }

        return false;
    }

    private function get_taxonomy_slug($taxonomy_slug) {

        $default_lang = BABE_Functions::get_default_language();
        $current_lang = BABE_Functions::get_current_language();
        if (BABE_Functions::is_wpml_active() && $current_lang !== $default_lang) {
            do_action('wpml_switch_language', $default_lang);
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
            do_action('wpml_switch_language', $current_lang);
        } else {
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        }

        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            return BABE_Post_types::$attr_tax_pref . $taxonomy->slug;
        }

        return false;
    }

}

$widgets_manager->register(new Amoja_BABE_Elementor_Searchform_Widget());