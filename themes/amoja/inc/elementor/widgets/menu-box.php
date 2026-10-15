<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Amoja_Elementor_Menu_Box extends Widget_Base {

    public function get_categories() {
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
    public function get_name() {
        return 'amoja-menu-box';
    }

    public function get_icon() {
        return 'eicon-image-box';
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
    public function get_title() {
        return esc_html__('Amoja Restaurants Box', 'amoja');
    }

    public function get_script_depends() {
        return ['amoja-elementor-menu-box', 'magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $templates = Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . esc_html__('Select', 'amoja') . ' —',
        ];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
        }

        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__('Menu Box', 'amoja'),
            ]
        );

        $this->add_control(
            'box_subtitle',
            [
                'label'   => esc_html__('Type', 'amoja'),
                'default' => 'Dining',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label'   => esc_html__('Restaurent name', 'amoja'),
                'default' => 'Ajoma Restaurant',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'box_time',
            [
                'label'   => esc_html__('Open Time', 'amoja'),
                'default' => '18:00 - 22:00',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'box_desc',
            [
                'label'   => esc_html__('Description', 'amoja'),
                'default' => 'Immerse yourself in elegance with top-notch live music performances, expertly crafted cocktails and food, and exceptional service.',
                'type'    => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'template',
            [
                'label'       => esc_html__('Popup Menu', 'amoja'),
                'default'     => 0,
                'type'        => Controls_Manager::SELECT,
                'options'     => $options,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'box_image',
            [
                'label'   => esc_html__('Choose Image', 'amoja'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'box_image', // Actually its `image_size`
                'label'   => esc_html__('Image Resolution', 'amoja'),
                'default' => 'full',
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

        $this->add_control('type_heading',
            [
                'label' => esc_html__('Type', 'amoja'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'type_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'type_typography',
                'selector' => '{{WRAPPER}} .sub-title',
            ]
        );

        $this->add_control('title_heading',
            [
                'label' => esc_html__('Reastaurant name', 'amoja'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control('time_heading',
            [
                'label' => esc_html__('Open time', 'amoja'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'time_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .box-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'time_typography',
                'selector' => '{{WRAPPER}} .box-time',
            ]
        );

        $this->add_control('desc_heading',
            [
                'label' => esc_html__('Description', 'amoja'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typography',
                'selector' => '{{WRAPPER}} .box-description',
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
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('button', [
            'class' => [
                'button-popup'
            ],
            'href'  => [
                '#amoja-menu-popup-' . esc_attr($this->get_id())
            ]
        ]);

        $this->add_render_attribute('popup', [
            'class' => [
                'mfp-hide',
                'menu-popup-content',
                'menu-popup-content-' . $this->get_id()
            ],
            'id'    => [
                'amoja-menu-popup-' . $this->get_id()
            ]
        ]);
        ?>
        <div class="menu-box-wrap">
            <div class="menu-box-thumb">
                <a <?php $this->print_render_attribute_string('button'); ?>>
                    <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'box_image'); ?>
                    <span class="text-hover"><?php echo esc_html__('View Menu', 'amoja'); ?></span>
                </a>
                <div <?php $this->print_render_attribute_string('popup'); ?>>
                    <div class="menu-popup-inner">
                        <button class="menu-popup-close mfp-close">
                            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="23.691" height="22.723" viewBox="0 0 23.691 22.723">
                                <g transform="translate(-126.154 -143.139)">
                                    <line x2="23" y2="22" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="3"></line>
                                    <path d="M0,22,23,0" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="3"></path>
                                </g>
                            </svg>
                        </button>
                        <div class="menu-popup-content-inner">
                            <?php
                            if (!empty($settings['template'])) {
                                echo Plugin::instance()->frontend->get_builder_content_for_display($settings['template']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-box-content">
                <?php
                if (!empty($settings['box_subtitle'])) {
                    echo '<span class="sub-title">' . esc_html($settings['box_subtitle']) . '</span>';
                }
                if (!empty($settings['box_title'])) {
                    echo '<h5 class="title">' . esc_html($settings['box_title']) . '</h5>';
                }
                if (!empty($settings['box_time'])) {
                    echo '<div class="box-time">' . ' <svg aria-hidden="true" class="e-font-icon-svg e-far-clock" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg>'  . esc_html($settings['box_time']) . '</div>';
                }
                if (!empty($settings['box_desc'])) {
                    echo '<div class="box-description">' . esc_html($settings['box_desc']) . '</div>';
                }
                ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Amoja_Elementor_Menu_Box());
