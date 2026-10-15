<?php

use Elementor\Controls_Manager;

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Amoja_BABE_Elementor_Itemslideshow_Widget extends Amoja_Base_Widgets_Swiper
{

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'babe-item-slideshow';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Detail slideshow', 'amoja');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-slides';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['slideshow'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['book-everything-elements'];
    }

    public function get_style_depends()
    {
        return ['magnific-popup'];
    }

    public function get_script_depends()
    {
        return ['amoja-ba-slideshow.js', 'amoja-elementor-swiper', 'magnific-popup'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'amoja'),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'image_min_height',
            [
                'label' => esc_html__('Height', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vh', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-item img' => 'height: {{SIZE}}{{UNIT}}; object-fit:cover; width: 100%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'amoja'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__('Columns', 'amoja'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'desktop_default' => 2,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__('Spacing', 'amoja'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'amoja'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('gallery_button', [
            'label' => esc_html__('Gallery Button', 'amoja'),
            'tab' => Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control(
            'enable_gallery_button',
            [
                'label' => esc_html__('Enable Button Gallery', 'amoja'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'button_popup_vertical',
            [
                'label' => esc_html__('Button Vertical', 'amoja'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'amoja'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'amoja'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'condition' => [
                    'enable_gallery_button' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_popup_vertical_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-popup' => 'top: unset; bottom: unset; {{button_popup_vertical.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_gallery_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_button_popup',
            [
                'label' => esc_html__('Button Horizontal', 'amoja'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'amoja'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'amoja'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'enable_gallery_button' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_popup_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-popup' => 'left: unset; right: unset;{{arrows_button_popup.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_gallery_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel(['enable_carousel' => 'yes']);
    }

    /**
     * Render widget output on the frontend.
     * Written in PHP and used to generate the final HTML.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            $post_id = amoja_ba_get_default_single_id();
        } else {
            $post_id = get_the_ID();
        }
        $booking_post = get_post($post_id);
        $this->add_render_attribute('wrapper', 'class', 'elementor-item-slideshow-wrapper');
        $this->get_data_elementor_columns();
        if (is_single() && $booking_post->post_type == BABE_Post_types::$booking_obj_post_type) {
            $babe_post = BABE_Post_types::get_post($booking_post->ID);
            $gallery_items = isset($babe_post['images']) ? $babe_post['images'] : array();
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div <?php $this->print_render_attribute_string('row'); ?>>
                <?php
                if (isset($gallery_items) && !empty($gallery_items)) {
                    foreach ($gallery_items as $key => $gallery) {
                        $gallery['url'] = $gallery['image'];
                        $link_key = 'link_' . $key;
                        $this->add_link_attributes($link_key, $gallery);
                        $this->add_lightbox_data_attributes($link_key, $gallery['image_id'], 'yes', $this->get_id());
                        ?>
                        <div <?php $this->print_render_attribute_string('item'); ?>>
                            <a <?php $this->print_render_attribute_string($link_key); ?>>
                                <?php echo wp_get_attachment_image($gallery['image_id'], 'full'); ?>
                            </a>
                        </div>
                    <?php }
                }else {
                    $this->add_render_attribute('thumbnail_link','href',get_the_post_thumbnail_url());
                    $this->add_lightbox_data_attributes('thumbnail_link',0, 'yes', $this->get_id());
                    ?>
                        <div class="item-slideshow-thumbnail">
                            <a <?php $this->print_render_attribute_string('thumbnail_link'); ?>>
                                <?php echo get_the_post_thumbnail(get_the_ID(),'full'); ?>
                            </a>
                        </div>
                        <?php
                }

                ?>
            </div>
            <?php
            if (isset($gallery_items) && !empty($gallery_items)) {
                if ($settings['enable_gallery_button'] == 'yes'): ?>
                    <a class="gallery-popup" href="#">
                        <span class="gallery-text"><?php esc_html_e('view gallery', 'amoja') ?></span> <i
                                class="amoja-icon-image"></i>
                    </a>
                <?php endif;
            } ?>
        </div>

        <?php
        if (isset($gallery_items) && !empty($gallery_items)) {
        $this->render_swiper_pagination_navigation();
        }
    }

}

$widgets_manager->register(new Amoja_BABE_Elementor_Itemslideshow_Widget());