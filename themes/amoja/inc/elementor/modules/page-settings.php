<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amoja_Elementor_Page_Settings')) :
    /**
     * The main Amoja_Elementor_Page_Settings class
     */
    class Amoja_Elementor_Page_Settings {
        public function __construct() {
            add_action('elementor/documents/register_controls', [$this, 'register_controls']);
        }

        public function register_controls( $document ) {

            $document->start_controls_section(
                'amoja_breadcrumb_settings',
                [
                    'label' => esc_html__('Breadcrumb Settings', 'amoja'),
                    'tab'   => \Elementor\Controls_Manager::TAB_SETTINGS,
                ]
            );

            $id = get_the_ID();

            $document->add_control(
                'amoja_breadcrumb_switch',
                [
                    'label' => esc_html__('Hide Breadcrumb', 'amoja'),
                    'type'  => Elementor\Controls_Manager::SWITCHER,
                    'selectors' => [
                        '.elementor-page-' . $id => '--page-breadcrumb-display: none',
                    ],
                ]
            );

            $document->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'     => 'amoja_breadcrumb_background',
                    'selector' => '.header-width-fixer, .elementor-page-' . $id . ' .header-width-fixer',
                ]
            );


            $document->add_control('amoja_breadcrumb_background_overlay_heading',[
                'label' => esc_html__('Background Overlay', 'amoja'),
                'type'  => Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
            ]);

            $document->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'amoja_breadcrumb_background_overlay',
                    'selector' => '.header-width-fixer::before, .elementor-page-' . $id . ' .header-width-fixer::before',
                ]
            );

            $document->add_control(
                'amoja_breadcrumb_background_overlay_opacity',
                [
                    'label' => esc_html__( 'Opacity', 'amoja' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => [
                        'size' => .5,
                    ],
                    'range' => [
                        'px' => [
                            'max' => 1,
                            'step' => 0.01,
                        ],
                    ],
                    'selectors' => [
                        '.header-width-fixer::before, .elementor-page-' . $id . ' .header-width-fixer::before' => 'opacity: {{SIZE}};',
                    ],
                ]
            );

            $document->end_controls_section();
        }
    }
endif;

new Amoja_Elementor_Page_Settings();