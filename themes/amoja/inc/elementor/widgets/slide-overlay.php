<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Amoja_Elementor_Slide_Overlay extends Widget_Base
{

    public function get_categories()
    {
        return array('amoja-addons');
    }

    public function get_name()
    {
        return 'amoja-slide-overlay';
    }

    public function get_title()
    {
        return esc_html__('Amoja Slide Overlay', 'amoja');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_keywords()
    {
        return ['tabs', 'accordion', 'toggle', 'link', 'showcase'];
    }

    public function get_script_depends()
    {
        return ['amoja-elementor-slide-overlay'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__('Items', 'amoja'),
            ]
        );

        $this->add_responsive_control(
            'duration',
            [
                'label' => esc_html__('Scrolling duration', 'amoja'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .slide-overlay-title-inner' => 'animation-duration: {{VALUE}}s',
                ],
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
            'brand_icon',
            [
                'label' => esc_html__('Icon', 'amoja'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
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
                        'title' => esc_html__('Title', 'amoja'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
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


        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__('Spacing', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 50
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'margin-left: calc({{SIZE}}{{UNIT}}/2); margin-right: calc({{SIZE}}{{UNIT}}/2);',
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

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'amoja'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Hover Color', 'amoja'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label' => esc_html__('Blend Mode', 'amoja'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Normal', 'amoja'),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );


        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__('Padding', 'amoja'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slide-overlay-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => 'px',
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'amoja'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color Hover', 'amoja'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_gap',
            [
                'label' => esc_html__('Gap', 'amoja'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 50
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'gap: {{SIZE}}{{UNIT}};',
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
        $title_html = '';
        $image_html = '';
        if (!empty($settings['items']) && is_array($settings['items'])) {
            $items = $settings['items'];
            // Row
            $this->add_render_attribute('wrapper', 'class', 'elementor-slide-overlay-wrapper');
            $this->add_render_attribute('row', 'class', 'elementor-slide-overlay-inner');
            $this->add_render_attribute('row', 'role', 'tablist');
            ?>

            <?php foreach ($items as $index => $item) :
                $item_title_setting_key = $this->get_repeater_setting_key('item_title', 'items', $index);
                $this->add_render_attribute($item_title_setting_key, [
                    'class' => [
                        'elementor-slide-overlay-title',
                        ($index == 0) ? 'elementor-active' : ''
                    ],
                    'data-trigger' => $index
                ]);

                ob_start();
                ?>
                <div <?php $this->print_render_attribute_string($item_title_setting_key); ?>>
                    <?php Icons_Manager::render_icon($item['brand_icon'], ['aria-hidden' => 'true']); ?>
                    <span><?php echo esc_html($item['title']); ?></span>
                </div>
                <?php
                $title_html .= ob_get_clean();
                ob_start();
                $item_content_setting_key = $this->get_repeater_setting_key('item_content', 'items', $index);
                $this->add_render_attribute($item_content_setting_key, [
                    'class' => [
                        'elementor-slide-overlay-content',
                        ($index == 0) ? 'elementor-active' : '',
                    ],
                    'data-target' => $index
                ]);
                ?>
                <div <?php $this->print_render_attribute_string($item_content_setting_key); ?>>
                    <?php $this->render_image($settings, $item); ?>
                </div>
                <?php
                $image_html .= ob_get_clean();
            endforeach; ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('row'); ?>>
                    <div class="slide-overlay-title-wrapper">
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                    </div>
                    <div class="slide-overlay-content-wrapper">
                        <div class="slide-overlay-content-inner">
                            <?php printf('%s', $image_html); ?>
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

$widgets_manager->register(new Amoja_Elementor_Slide_Overlay());
