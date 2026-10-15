<?php
// Icon Box
use Elementor\Controls_Manager;
add_action( 'elementor/element/icon-box/section_style_icon/before_section_end', function ( $element, $args ) {
    $element->add_control(
        'icon_style_theme',
        [
            'label' => esc_html__('Theme Style', 'amoja'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'prefix_class' => 'icon-box-style-amoja-',
        ]
    );
    $element->add_control(
        'text_color_hover',
        [
            'label'     => esc_html__('Link Hover', 'amoja'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-wrapper:hover .elementor-icon-box-title a' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'icon_style_theme' => 'yes',
            ],
        ]
    );
    $element->add_control(
        'bg_color_hover',
        [
            'label'     => esc_html__('BgColor Hover', 'amoja'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-wrapper .elementor-icon:before' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'icon_style_theme' => 'yes',
            ],
        ]
    );


}, 10, 2 );
