<?php

use Elementor\Controls_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Amoja_Elementor_Button_Popup extends Elementor\Widget_Base {

    public function get_name() {
        return 'amoja-button-popup';
    }

    public function get_title() {
        return esc_html__('Amoja full-screen menu', 'amoja');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_script_depends() {
        return ['amoja-elementor-button-popup'];
    }

    protected function register_controls() {
        $templates = \Elementor\Plugin::instance()->templates_manager->get_source('local')->get_items();
        $options   = [
            '0' => '— ' . esc_html__('Select', 'amoja') . ' —',
        ];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
        }
        $this->start_controls_section(
            'section_config',
            [
                'label' => esc_html__('Main Config', 'amoja'),
            ]
        );

        $this->add_control(
            'heading_line',
            [
                'label' => esc_html__('Line Color', 'amoja'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_width',
            [
                'label' => esc_html__( 'Width', 'amoja' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .line' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'template_id',
            [
                'label'       => esc_html__('Choose Template', 'amoja'),
                'default'     => 0,
                'type'        => Controls_Manager::SELECT,
                'options'     => $options,
                'label_block' => 'true',
                'separator'   => 'before'
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'amoja'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Wrap Popup Padding', 'amoja'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .button-popup-menu-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .button-popup-menu-content-inner' => 'max-height: calc(100vh - {{TOP}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'amoja-button-popup-menu');
        $this->add_render_attribute('button', 'class', 'button-popup-menu');
        $this->add_render_attribute('popup', 'class', 'button-popup-menu-content');

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <button <?php $this->print_render_attribute_string('button'); ?>>
                <span class="line-container">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </span>
            </button>
        </div>
        <?php
        if (!Plugin::$instance->editor->is_edit_mode()) {
            ?>
            <div <?php $this->print_render_attribute_string('popup'); ?>>
                <div class="button-popup-menu-content-inner">
                    <?php

                    if (!empty($settings['template_id'])) {
                        echo Plugin::instance()->frontend->get_builder_content_for_display($settings['template_id']);
                    } else {
                        echo esc_html__('No Templates', 'amoja');
                    }

                    ?>
                </div>
                <div class="button-popup-menu-bg"></div>
            </div>
            <?php
        }
    }

}

$widgets_manager->register(new Amoja_Elementor_Button_Popup());
