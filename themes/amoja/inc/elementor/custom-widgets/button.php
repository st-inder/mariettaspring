<?php
// Button
use Elementor\Controls_Manager;

add_action('elementor/element/button/section_button/after_section_end', function ($element, $args) {
    /** @var \Elementor\Element_Base $element */
    $element->update_control(
        'button_type',
        [
            'label'        => esc_html__('Type', 'amoja'),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'default',
            'options'      => [
                'default'   => esc_html__('Default', 'amoja'),
                'outline' => esc_html__('OutLine', 'amoja'),
                'info'    => esc_html__('Info', 'amoja'),
                'success' => esc_html__('Success', 'amoja'),
                'warning' => esc_html__('Warning', 'amoja'),
                'danger'  => esc_html__('Danger', 'amoja'),
                'type-link'  => esc_html__('Link', 'amoja'),
            ],
            'prefix_class' => 'elementor-button-',
        ]
    );

}, 10, 2);

add_action('elementor/element/button/section_style/after_section_end', function ($element, $args) {

    $element->update_control(
        'button_text_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-type-link .elementor-button:after,{{WRAPPER}}.elementor-button-type-link .elementor-button:before' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $element->update_control(
        'background_color',
        [
            'global'    => [
                'default' => '',
            ],
        ]
    );

    $element->update_control(
        'button_background_hover_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-type-link .elementor-button .elementor-button-icon:before' => 'background-color: {{VALUE}};',
            ],
        ]
    );

}, 10, 2);


add_action('elementor/element/button/section_button/before_section_end', function ($element, $args) {
    $element->add_control(
        'icon_size',
        [
            'label' => esc_html__( 'Icon Size', 'amoja' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon svg' => '--size-icon: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    $element->add_control(
        'icon_color',
        [
            'label' => esc_html__( 'Icon Color', 'amoja' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
                'selected_icon[value]!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button .elementor-button-icon svg' => 'fill: {{VALUE}};',
            ],
        ]
    );
    $element->add_control(
        'icon_color_hover',
        [
            'label' => esc_html__( 'Icon Color Hover', 'amoja' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
                'selected_icon[value]!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
            ],
        ]
    );
}, 10, 2);