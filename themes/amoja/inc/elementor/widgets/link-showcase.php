<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Amoja_Elementor_Link_Showcase extends Widget_Base
{

    public function get_categories()
    {
        return array('amoja-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'amoja-link-showcase';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Amoja Link Showcase', 'amoja');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-tabs';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since 2.1.0
     * @access public
     *
     */
    public function get_keywords()
    {
        return ['tabs', 'accordion', 'toggle', 'link', 'showcase'];
    }

    public function get_script_depends()
    {
        return ['amoja-elementor-link-showcase'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $templates = Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . esc_html__('Select', 'amoja') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
            $types[$template['template_id']] = $template['type'];
        }


        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__('Items', 'amoja'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'amoja'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Title', 'amoja'),
                'placeholder' => esc_html__('Title', 'amoja'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'source',
            [
                'label' => esc_html__('Source', 'amoja'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'html' => esc_html__('HTML', 'amoja'),
                    'template' => esc_html__('Template', 'amoja'),
                    'image' => esc_html__('Image', 'amoja'),
                ]
            ]
        );

        $repeater->add_control(
            'link_template',
            [
                'label' => esc_html__('Choose Template', 'amoja'),
                'default' => 0,
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'types' => $types,
                'label_block' => 'true',
                'condition' => [
                    'source' => 'template',
                ],
            ]
        );

        $repeater->add_control(
            'link_content',
            [
                'label' => esc_html__('Content', 'amoja'),
                'default' => esc_html__('Tab Content', 'amoja'),
                'placeholder' => esc_html__('Tab Content', 'amoja'),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
                'condition' => [
                    'source' => 'html',
                ],
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'       => esc_html__('Description', 'amoja'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'The restaurant and lounge offerings at our resort are guaranteed to please even the most discerning palates. ',
                'label_block' => true,
                'rows'        => '5',
            ]
        );

        $repeater->add_control(
            'link_image',
            [
                'label' => esc_html__('Choose Image', 'amoja'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'source' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'showcase_link',
            [
                'label' => esc_html__('Link to', 'amoja'),
                'placeholder' => esc_html__('https://your-link.com', 'amoja'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'amoja'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Title #1', 'amoja'),
                        'subtitle' => esc_html__('Subtitle #1', 'amoja'),
                        'link' => esc_html__('#', 'amoja'),
                    ],
                    [
                        'title' => esc_html__('Title #2', 'amoja'),
                        'subtitle' => esc_html__('Subtitle #2', 'amoja'),
                        'link' => esc_html__('#', 'amoja'),
                    ],
                    [
                        'title' => esc_html__('Title #3', 'amoja'),
                        'subtitle' => esc_html__('Subtitle #3', 'amoja'),
                        'link' => esc_html__('#', 'amoja'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => esc_html__('Button Text', 'amoja'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'amoja'),
            ]
        );

        $this->add_control(
            'link_button',
            [
                'label'       => esc_html__('Link Button', 'amoja'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'amoja'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'link_image',
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => esc_html__('Wrapper', 'amoja'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'min-height',
            [
                'label' => esc_html__('Height', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-link-showcase-inner' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'amoja'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_width', [
            'label' => esc_html__('Width', 'amoja'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 70,
                ],
                'px' => [
                    'min' => 20,
                    'max' => 800,
                ],
            ],
            'default' => [
                'unit' => '%',
            ],
            'size_units' => ['%', 'px'],
            'selectors' => [
                '{{WRAPPER}} .link-showcase-title-wrapper' => 'flex-basis: {{SIZE}}{{UNIT}}',
            ],
        ]);


        $this->add_responsive_control('title_space_between', [
            'label' => esc_html__('Gap between title', 'amoja'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 400,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .link-showcase-title-inner' => 'gap: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control(
            'title_spacing', [
            'label' => esc_html__('Distance from content', 'amoja'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 400,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .elementor-link-showcase-inner' => 'gap: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'amoja'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .link-showcase-title-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'amoja'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .showcase-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_active',
            [
                'label' => esc_html__('Title Color Active', 'amoja'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-link-showcase-title.elementor-active .showcase-title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-link-showcase-title:hover .showcase-title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-link-showcase-title.elementor-active .showcase-title a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-link-showcase-title:hover .showcase-title a:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .showcase-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Image', 'amoja'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'amoja'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .link-showcase-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__( 'Button', 'amoja' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-button',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->start_controls_tabs( 'button_tabs' );

        $this->start_controls_tab( 'button_normal',
            [
                'label' => esc_html__( 'Normal', 'amoja' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__( 'Background Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => esc_html__( 'Border Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button-hover',
            [
                'label' => esc_html__( 'Hover', 'amoja' ),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Color', 'amoja' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'amoja' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'amoja'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['items']) && is_array($settings['items'])) {
            $items = $settings['items'];
            // Row
            $this->add_render_attribute('wrapper', 'class', 'elementor-link-showcase-wrapper');
            $this->add_render_attribute('row', 'class', 'elementor-link-showcase-inner');
            $this->add_render_attribute('row', 'role', 'tablist');
            $id_int = substr($this->get_id_int(), 0, 3);
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('row'); ?>>
                    <div class="link-showcase-item link-showcase-title-wrapper">
                        <div class="link-showcase-title-inner">
                            <?php foreach ($items as $index => $item) :
                                $count = $index + 1;
                                $item_title_setting_key = $this->get_repeater_setting_key('item_title', 'items', $index);
                                $this->add_render_attribute($item_title_setting_key, [
                                    'id' => 'elementor-link-showcase-title-' . $id_int . $count,
                                    'class' => [
                                        'elementor-link-showcase-title',
                                        ($index == 0) ? 'elementor-active' : '',
                                        'elementor-repeater-item-' . $item['_id']
                                    ],
                                    'data-tab' => $count,
                                    'role' => 'tab',
                                    'aria-controls' => 'elementor-link-showcase-content-' . $id_int . $count,
                                ]);

                                ?>
                                <div <?php $this->print_render_attribute_string($item_title_setting_key); ?>>
                                    <div class="showcase-content">
                                        <?php if (!empty($item['title'])) { ?>
                                            <div class="showcase-title"><a href="<?php echo esc_url($item['showcase_link']['url']); ?>"><?php echo sprintf('%s', $item['title']); ?></a></div>
                                        <?php } ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="elementor-button-outline">
                                <a class="elementor-button" href="<?php echo esc_attr($settings['link_button']['url']) ?>">
                                    <?php if (!empty($settings['button_text'])) : ?>
                                        <span class="elementor-button-content-wrapper">
                                            <span class="elementor-button-text"><?php echo esc_html($settings['button_text']); ?></span>
                                            <span class="elementor-button-icon"><i class="amoja-icon-arrow-right"></i></span>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="link-showcase-item link-showcase-content-wrapper">
                        <div class="link-showcase-content-inner">
                            <?php foreach ($items as $index => $item) :
                                $count = $index + 1;
                                $item_content_setting_key = $this->get_repeater_setting_key('item_content', 'items', $index);
                                $this->add_render_attribute($item_content_setting_key, [
                                    'id' => 'elementor-link-showcase-content-' . $id_int . $count,
                                    'class' => [
                                        'elementor-link-showcase-content',
                                        'elementor-repeater-item-' . $item['_id'],
                                        ($index == 0) ? 'elementor-active' : '',
                                    ],
                                    'data-tab' => $count,
                                    'role' => 'tab',
                                    'aria-controls' => 'elementor-link-showcase-title-' . $id_int . $count,
                                ]);
                                ?>
                                <div <?php $this->print_render_attribute_string($item_content_setting_key); ?>>
                                    <?php if ('html' === $item['source']): ?>
                                        <?php echo amoja_elementor_parse_text_editor($item['link_content'], $this); // WPCS: XSS ok. ?>
                                    <?php elseif ('template' === $item['source']): ?>
                                        <?php echo Plugin::instance()->frontend->get_builder_content_for_display($item['link_template']); ?>
                                    <?php else: ?>
                                    <div class="elementor-link-showcase-content-inner">
                                        <?php $this->render_image($settings, $item); ?>
                                        <?php if (!empty($item['description'])) { ?>
                                            <div class="description"><?php echo sprintf('%s', $item['description']); ?></div>
                                        <?php } ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $item)
    {
        if (!empty($item['link_image']['url'])) :
            ?>
            <?php
            $item['link_image_size'] = $settings['link_image_size'];
            $item['link_image_custom_dimension'] = $settings['link_image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($item, 'link_image');
            ?>
        <?php
        endif;
    }
}

$widgets_manager->register(new Amoja_Elementor_Link_Showcase());