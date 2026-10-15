<?php
/**
 * Add widget Duration to Elementor
 *
 * @since   1.0.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Amoja_BABE_Elementor_Itemmeta_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'babe-item-meta';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Detail Meta', 'amoja');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-preferences';
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
        return ['max', 'people', 'guests'];
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

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */


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
        $babe_post = get_post($post_id);

        if (is_single() && $babe_post->post_type == BABE_Post_types::$booking_obj_post_type) {
            $babe_post = BABE_Post_types::get_post($babe_post->ID);

            $room_area   = isset($babe_post['amoja_room_area']) ? $babe_post['amoja_room_area'] : false;
            $room_beds   = isset($babe_post['amoja_beds']) ? $babe_post['amoja_beds'] : false;
            $min_guests  = isset($babe_post['min_guests']) ? $babe_post['min_guests'] : false;
            $guests      = isset($babe_post['guests']) ? $babe_post['guests'] : false;
            ?>
            <div class="elementor-widget-inner">
                <div class="item-meta">
                    <?php if (!empty($room_area)) { ?>
                        <div class="item-meta-inner item-room-area">
                            <i class="amoja-icon amoja-icon-maximize"></i>
                            <span>
                            <?php printf('%s', esc_html($room_area)); ?>
                        </span>
                        </div>
                    <?php } ?>
                    <?php if (!empty($min_guests) || !empty($guests)) { ?>
                        <div class="item-meta-inner item-room-guests">
                            <i class="amoja-icon amoja-icon-users1"></i>
                            <span>
                            <?php printf('%1$s-%2$s %3$s', esc_html($min_guests), esc_html($guests), esc_html__('person', 'amoja')); ?>
                        </span>
                        </div>
                    <?php } ?>
                    <?php if (!empty($room_beds)) { ?>
                        <div class="item-meta-inner item-room-beds">
                            <i class="amoja-icon amoja-icon-double-bed1"></i>
                            <span>
                            <?php printf('%s %s', esc_html($room_beds), esc_html__('beds', 'amoja')); ?>
                        </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }


}
$widgets_manager->register(new Amoja_BABE_Elementor_Itemmeta_Widget());