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
class Amoja_Elementor_Menu_Bg extends Widget_Base {

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
        return 'amoja-menu-background';
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
        return esc_html__('Amoja Menu Background', 'amoja');
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
    public function get_icon() {
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

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__('Menu Items', 'amoja'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'amoja'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Title', 'amoja'),
                'placeholder' => esc_html__('Title', 'amoja'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link_image',
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

        $repeater->add_control(
            'menu_link',
            [
                'label'       => esc_html__('Link to', 'amoja'),
                'placeholder' => esc_html__('https://your-link.com', 'amoja'),
                'type'        => Controls_Manager::URL,
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label'       => esc_html__('Menu Items', 'amoja'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title' => esc_html__('Menu #1', 'amoja'),
                        'link'  => esc_html__('#', 'amoja'),
                    ]
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'link_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'amoja'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'amoja'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .menu-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .menu-link:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .menu-link',
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
        if (!empty($settings['items']) && is_array($settings['items'])) {
            $items = $settings['items'];
            // Row
            $this->add_render_attribute('wrapper', 'class', 'elementor-menu-background-wrapper');
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>

                <div class="menu-background-items">
                    <?php foreach ($items as $index => $item) :
                        $this->add_render_attribute('link_' . $index, 'class', 'menu-link');
                        if (!empty($item['menu_link']['url'])) {
                            $this->add_link_attributes('link_' . $index, $item['menu_link']);
                        }
                        if (!empty($item['title'])) { ?>
                            <div class="menu-title">
                                <a <?php $this->print_render_attribute_string('link_' . $index); ?>><span><?php echo esc_html($item['title']); ?></span></a>
                                <?php
                                if (!empty($item['link_image']['url'])) {
                                    ?>
                                    <div class="menu-background">
                                        <?php $this->render_image($settings, $item); ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php }
                    endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $item) {
        $item['link_image_size']             = $settings['link_image_size'];
        $item['link_image_custom_dimension'] = $settings['link_image_custom_dimension'];
        echo Group_Control_Image_Size::get_attachment_image_html($item, 'link_image');
    }
}

$widgets_manager->register(new Amoja_Elementor_Menu_Bg());
