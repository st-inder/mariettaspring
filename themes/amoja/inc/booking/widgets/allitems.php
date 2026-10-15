<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Amoja_BABE_Elementor_Allitems_Widget extends Amoja_Base_Widgets_Swiper {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_enqueue_style('babe-admin-elementor-style', plugins_url("css/admin/babe-admin-elementor.css", BABE_PLUGIN));
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-all-items';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('All items', 'amoja');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-archive-posts';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['item', 'items', 'all', 'room', 'book everything'];
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
        return ['amoja-ba-ba-all-items.js', 'amoja-elementor-swiper'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        // Get all terms of categories
        $categories = BABE_Post_types::get_categories_arr();

        $categories[0] = esc_html__('All', 'amoja');

        $item_titles = [0 => esc_html__('All', 'amoja')];

        $items = get_posts([
            'post_type'      => BABE_Post_types::$booking_obj_post_type,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'cache_results'  => false,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);
        if (!empty($items)) {
            foreach ($items as $item) {
                $item_titles[$item->ID] = get_the_title($item->ID);
            }
        }

        $this->start_controls_section(
            'babe_allitems',
            array(
                'label' => esc_html__('Content', 'amoja'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'category_ids',
            array(
                'label'   => esc_html__('Item Category', 'amoja'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $categories,
                'default' => '0',
            )
        );

        $this->add_control(
            'taxonomy_slug',
            array(
                'label'       => esc_html__('Ba Taxonomies', 'amoja'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'multiple'    => true,
                'options'     => $this->get_taxonomies_arr(),
                'label_block' => true,
            )
        );

        $this->render_taxonomy_select();

        $this->add_control(
            'ids',
            array(
                'label'       => esc_html__('Items', 'amoja'),
                'description' => esc_html__('Show selected items only. Input item title to see suggestions', 'amoja'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $item_titles,
                'label_block' => true
            )
        );

        $this->add_control(
            'per_page',
            array(
                'label'       => esc_html__('Per Page', 'amoja'),
                'description' => esc_html__('How much items per page to show (-1 to show all items)', 'amoja'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => '',
                'default'     => '12',
            )
        );

        $this->add_control(
            'sort',
            array(
                'label'       => esc_html__('Order By', 'amoja'),
                'description' => '',
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'rating'     => esc_html__('Rating', 'amoja'),
                    'price_from' => esc_html__('Price from', 'amoja'),
                ),
                'default'     => 'rating',
            )
        );

        $this->add_control(
            'sortby',
            array(
                'label'       => esc_html__('Order', 'amoja'),
                'description' => esc_html__('Designates the ascending or descending order. Default by DESC', 'amoja'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'ASC'  => esc_html__('Ascending', 'amoja'),
                    'DESC' => esc_html__('Descending', 'amoja'),
                ),
                'default'     => 'DESC',
            )
        );

        $this->add_control(
            'date_from',
            array(
                'label'          => esc_html__('Date from', 'amoja'),
                'description'    => esc_html__('Show items which are available from selected date.', 'amoja'),
                'type'           => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'dateFormat' => BABE_Settings::$settings['date_format'],
                    'enableTime' => false,
                ],
            )
        );

        $this->add_control(
            'date_to',
            array(
                'label'          => esc_html__('Date to', 'amoja'),
                'description'    => esc_html__('Show items which are available up to selected date.', 'amoja'),
                'type'           => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'dateFormat' => BABE_Settings::$settings['date_format'],
                    'enableTime' => false,
                ],
            )
        );

        $this->add_control(
            'classes',
            array(
                'label'       => esc_html__('Extra class name', 'amoja'),
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'amoja'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => '',
            )
        );

        $this->add_responsive_control(
            'column',
            [
                'label'           => esc_html__('Columns', 'amoja'),
                'type'            => \Elementor\Controls_Manager::SELECT,
                'desktop_default' => 2,
                'tablet_default'  => 2,
                'mobile_default'  => 1,
                'options'         => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                'selectors'       => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition'       => [
                    'enable_carousel!' => 'yes',
                    'enable_layout!'   => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label'      => esc_html__('Spacing', 'amoja'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 30
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'enable_carousel!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => esc_html__('Style', 'amoja'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    1 => esc_html__('Style 1', 'amoja'),
                    2 => esc_html__('Style 2', 'amoja'),
                    3 => esc_html__('Style 3', 'amoja'),
                    4 => esc_html__('Style 4', 'amoja'),
                ],
            ]
        );

        $this->add_control(
            'enable_layout',
            [
                'label'        => esc_html__('Layout Special', 'amoja'),
                'type'         => Controls_Manager::SWITCHER,
                'condition'    => [
                    'style' => '1',
                ],
                'prefix_class' => 'elementor-layout-special-',
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'amoja'),
                'type'  => Controls_Manager::SWITCHER,

            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label'     => esc_html__('Enable Pagination', 'amoja'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'enable_carousel!' => 'yes'
                ]

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background Color', 'amoja'),
                'type'  => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .babe_all_items_item_inner' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .babe_items .babe_all_items_item_inner',
            ]
        );
        $this->add_control(
            'box_radius',
            [
                'label'      => esc_html__('Border Radius', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items .babe_all_items_item_inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__('Background Color', 'amoja'),
                'type'  => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .babe_items .item_text' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items .item_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label'      => esc_html__('Border Radius', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items .item_text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .item_title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item_title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_space',
            [
                'label'      => esc_html__('Margin', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .item_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'selector' => '{{WRAPPER}} .item-meta',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => esc_html__('Height', 'amoja'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vh', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items .item-thumb' => 'height: {{SIZE}}{{UNIT}}; padding-top: 0',
                ],
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label'      => esc_html__('Border Radius', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items .item-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel(['enable_carousel' => 'yes']);

    }


    protected function render_taxonomy_select() {
        $taxonomies_list = $this->get_taxonomies_arr();

        if ($taxonomies_list) {
            foreach ($taxonomies_list as $key => $name) {
                $taxonomies = $this->get_taxonomy_options($key);

                $this->add_control(
                    $key . '_ids',
                    array(
                        'label'       => $name,
                        'description' => esc_html__('Show selected category of taxonomy. Input item title to see suggestions', 'amoja'),
                        'type'        => \Elementor\Controls_Manager::SELECT2,
                        'multiple'    => true,
                        'options'     => $taxonomies,
                        'label_block' => true,
                        'condition'   => [
                            'taxonomy_slug' => $key,
                        ]
                    )
                );

            }
        }

    }

    protected function get_taxonomy_options($taxonomy_slug) {

        $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        $output   = array();
        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {

            $taxonomies = get_terms(array(
                'taxonomy'   => BABE_Post_types::$attr_tax_pref . $taxonomy->slug,
                'hide_empty' => false
            ));

            if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
                foreach ($taxonomies as $tax_term) {
                    $output[$tax_term->term_id] = $tax_term->name;
                }
            }
        }
        return $output;
    }

    public static function get_taxonomies_arr() {
        $output = array(0 => esc_html__('All', 'amoja'));

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

    /**
     * Create shortcode row
     *
     * @return string
     */
    public function create_shortcode() {

        $settings = $this->get_settings_for_display();

        $args_row = '';

        if ($settings['taxonomy_slug']) {
            $term_ids = $settings['taxonomy_slug'] . '_ids';
            if ($settings[$term_ids]) {
                $args_row .= ' term_ids="' . esc_attr(implode(',', $settings[$term_ids])) . '"';
            }
        }

        $args_row .= $settings['sort'] ? ' sort="' . esc_attr($settings['sort']) . '"' : '';
        $args_row .= $settings['sortby'] ? ' sortby="' . esc_attr($settings['sortby']) . '"' : '';

        $args_row .= absint($settings['category_ids']) ? ' category_ids="' . absint($settings['category_ids']) . '"' : '';

        $args_row .= !empty($settings['ids']) ? ' ids="' . esc_attr(implode(',', $settings['ids'])) . '"' : '';

        $args_row .= absint($settings['per_page']) ? ' per_page="' . intval($settings['per_page']) . '"' : '';

        $args_row .= $settings['date_from'] ? ' date_from="' . esc_attr($settings['date_from']) . '"' : '';

        $args_row .= $settings['date_to'] ? ' date_to="' . esc_attr($settings['date_to']) . '"' : '';

        ///////////////////////

        $args_row .= $settings['classes'] ? ' classes="' . esc_attr($settings['classes']) . '"' : '';


        return '[all-items' . $args_row . '][/all-items]';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {
        $function_to_call = 'remov' . 'e_filter';
        add_filter('babe_shortcode_all_items_html', array($this, 'amoja_babe_shortcode_all_items_html'), 10, 3);
        add_filter('babe_shortcode_all_items_item_html', array($this, 'get_template_items'), 10, 3);
        echo do_shortcode($this->create_shortcode());
        $function_to_call('babe_shortcode_all_items_html', array($this, 'amoja_babe_shortcode_all_items_html'), 10);
        $function_to_call('babe_shortcode_all_items_item_html', array($this, 'get_template_items'), 10);
        $this->render_swiper_pagination_navigation();
    }

    public function get_template_items($content, $post, $babe_post) {
        $settings = $this->get_settings_for_display();
        ob_start();
        include get_theme_file_path('template-parts/booking/block/item-block-' . $settings['style'] . '.php');
        return ob_get_clean();
    }

    public function amoja_babe_shortcode_all_items_html($output, $args, $post_args) {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'babe_shortcode_block_bg_inner');
        $this->add_render_attribute('row', 'class', 'babe_shortcode_block_inner');

        $this->get_data_elementor_columns();
        $pagination = '';
        if ($settings['enable_pagination'] == 'yes' && $settings['enable_carousel'] !== 'yes') {
            $posts_pages = BABE_Post_types::$get_posts_pages;
            $pagination  = BABE_Functions::pager($posts_pages);
        }
        $classes = $args['classes'] ? $args['classes'] : '';
        $output  = '
            <div class="babe_shortcode_block sc_all_items ' . $classes . ' all-items-' . esc_attr($settings['style']) . '">
                <div ' . $this->get_render_attribute_string('wrapper') . '>
                    <div ' . $this->get_render_attribute_string('row') . '>
                        ' . BABE_shortcodes::get_posts_tile_view($post_args) . '
                    </div>' . $pagination . '
                </div>
            </div>
			';
        return $output;
    }
}

$widgets_manager->register(new Amoja_BABE_Elementor_Allitems_Widget());