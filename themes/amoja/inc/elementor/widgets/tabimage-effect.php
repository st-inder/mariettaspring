<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;

class Amoja_Elementor_Tabimage_Effect extends Amoja_Base_Widgets_Swiper {

    /**
     * Get widget name.
     *
     * Retrieve tabimage widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'amoja-tabimage-effect';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabimage widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Amoja Tab Image Effect', 'amoja');
    }

    public function get_categories()
    {
        return array('amoja-addons');
    }


    public function get_script_depends() {
        return ['amoja-elementor-tabimage-effect', 'amoja-elementor-swiper'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_tabimage',
            [
                'label' => esc_html__('Tab Image Effect', 'amoja'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control('tabimage_title', [
            'label' => esc_html__('Title', 'amoja'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Title',
        ]);

        $repeater->add_control('tabimage_content', [
            'label' => esc_html__('Content', 'amoja'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'label_block' => true,
            'rows' => '8',
        ]);

        $repeater->add_control('tabimage_image', [
            'label' => esc_html__('Image', 'amoja'),
            'type' => Controls_Manager::MEDIA,
        ]);

        $repeater->add_control('tabimage_link', [
            'label' => esc_html__('Link to', 'amoja'),
            'placeholder' => esc_html__('https://your-link.com', 'amoja'),
            'type' => Controls_Manager::URL,
            'default' => [
                'url' => '#',
            ],
        ]);

        $this->add_control(
            'tabimage-effect',
            [
                'label' => esc_html__('Tabimage Effect Item', 'amoja'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ tabimage_title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tabimage_image',
                'default' => 'full',
                'separator' => 'none',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__('Columns', 'amoja'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition' => ['enable_carousel!' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label'      => esc_html__('Gutter', 'amoja'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition' => ['enable_carousel!' => 'yes']
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tabimage_background',
                'label' => esc_html__('Background', 'amoja'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}}',
            ]
        );


        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'amoja'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        // Wrapper.
        $this->start_controls_section(
            'tabimage_wrapper',
            [
                'label' => esc_html__('Wrapper', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__('Width', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 10000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabimage-wrapper' => 'max-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_height',
            [
                'label' => esc_html__('Height', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabimage-item-image' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabimage-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Overlay', 'amoja' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => esc_html__( 'Background Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabimage-wrapper .tabimage-item-image:after' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Item.
        $this->start_controls_section(
            'tabimage_item',
            [
                'label' => esc_html__('Item', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Height', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabimage-item-content' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tabimage-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title.
        $this->start_controls_section(
            'tabimage_title',
            [
                'label' => esc_html__('Title', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabimage_title_align',
            [
                'label'     => esc_html__('Alignment', 'amoja'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => esc_html__('Left', 'amoja'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'amoja'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'amoja'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .tabimage-item-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tabimage_title_typography',
                'selector' => '{{WRAPPER}} .tabimage-item-title',
            ]
        );

        $this->add_control(
            'tabimage_title_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabimage-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tabimage_title_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tabimage-item-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Carousel options
        $this->add_control_carousel(['enable_carousel' => 'yes']);
    }

    /**
     * Render tabimage widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {

        $settings = $this->get_settings_for_display();

        if (!empty($settings['tabimage-effect']) && is_array($settings['tabimage-effect'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-tabimage-group');
            if ($settings['enable_carousel'] === 'yes') {
                if (isset($settings['slides_to_show']) && $settings['slides_to_show'] == 1) {
                    $this->add_render_attribute('wrapper', 'class', 'elementor-tabimage-one');
                }
            }
            $this->add_render_attribute('row', 'class');
            if ($settings['enable_carousel'] !== 'yes') {
                $this->add_render_attribute('row', 'class', 'elementor-tabimage-wrapper');
            }
            if ($settings['enable_carousel'] === 'yes') {
                $this->add_render_attribute('row', 'class', 'elementor-tabimage-carousel');
            }
            // Carousel
            $this->get_data_elementor_columns();

            $this->add_render_attribute('item', 'class', 'elementor-tabimage-item');

            $id_int = substr($this->get_id_int(), 0, 3);
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok.?>>
                <div <?php $this->print_render_attribute_string('row'); // WPCS: XSS ok.?>>
                    <?php foreach ($settings['tabimage-effect'] as $index => $tabimage):
                        $item_setting_key = $this->get_repeater_setting_key('item', 'items', $index);
                        $this->add_render_attribute($item_setting_key, [
                            'class'         => [
                                'elementor-tabimage-item',
                                ($index == 0) ? 'elementor-active' : '',
                            ],
                            'data-trigger' => $index
                        ]);?>
                        <div <?php $this->print_render_attribute_string($settings['enable_carousel'] !== 'yes' ? $item_setting_key : 'item'); ?>>
                            <?php

                            if (!empty($tabimage['tabimage_image']['id'])) {
                                $image = Group_Control_Image_Size::get_attachment_image_src($tabimage['tabimage_image']['id'], 'tabimage_image', $settings);
                                if ($settings['enable_carousel'] !== 'yes') {
                                    echo '<div class="tabimage-item-image" style="background-image:url(' . esc_attr($image) . ')"></div>';
                                } else {
                                    echo '<div class="tabimage-item-image"> <img src="  '. esc_attr($image) . ' " /></div>';
                                }
                            }
                            ?>
                            <div class="tabimage-item-content">
                                <div class="tabimage-item-content-wrap">
                                    <div class="tabimage-item-content-inner">
                                        <a href="<?php echo esc_url($tabimage['tabimage_link']['url']); ?>"><h4 class="tabimage-item-title"><?php echo sprintf('%s', $tabimage['tabimage_title']); ?></h4></a>

                                        <?php if ($settings['enable_carousel'] === 'yes') {
                                            printf('<div class="tabimage-item-text">%s</div>', $tabimage['tabimage_content']); // WPCS: XSS ok.
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($settings['slides_to_show']) && $settings['slides_to_show'] == 1) { ?>
                    <div class="swiper_pagination_navigation">
                <?php } ?>
                    <?php $this->render_swiper_pagination_navigation();?>
                <?php if (isset($settings['slides_to_show']) && $settings['slides_to_show'] == 1) {?>
                    </div>
                <?php } ?>
                </div>
            <?php

        }
    }
}

$widgets_manager->register(new Amoja_Elementor_Tabimage_Effect());
