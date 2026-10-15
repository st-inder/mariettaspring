<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Amoja_Customize')) {

    class Amoja_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */

            $this->init_amoja_blog($wp_customize);
            $this->init_amoja_social($wp_customize);

            do_action('amoja_customize_register', $wp_customize);
        }


        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_amoja_blog($wp_customize) {

            $wp_customize->add_section('amoja_blog_archive', array(
                'title' => esc_html__('Blog', 'amoja'),
            ));

            // =========================================
            // Select Style
            // =========================================

            $wp_customize->add_setting('amoja_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_blog_style', array(
                'section' => 'amoja_blog_archive',
                'label'   => esc_html__('Blog style', 'amoja'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'amoja'),
                    //====start_premium
                    'style-1'  => esc_html__('Blog Grid', 'amoja'),
                    'list'  => esc_html__('Blog List', 'amoja'),
                    //====end_premium
                ),
            ));

            $wp_customize->add_setting('amoja_options_blog_columns', array(
                'type'              => 'option',
                'default'           => 1,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_blog_columns', array(
                'section' => 'amoja_blog_archive',
                'label'   => esc_html__('Colunms', 'amoja'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'amoja'),
                    2 => esc_html__('2', 'amoja'),
                    3 => esc_html__('3', 'amoja'),
                    4 => esc_html__('4', 'amoja'),
                ),
            ));

            $wp_customize->add_setting('amoja_options_blog_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'right',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_blog_archive_sidebar', array(
                'section' => 'amoja_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'amoja'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'amoja'),
                    'right' => esc_html__('Right', 'amoja'),
                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_amoja_social($wp_customize) {

            $wp_customize->add_section('amoja_social', array(
                'title' => esc_html__('Socials', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Show Social Share', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share_facebook', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_facebook', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Facebook', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share_twitter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_twitter', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Twitter', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share_linkedin', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_linkedin', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Linkedin', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share_google-plus', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_google-plus', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Google+', 'amoja'),
            ));

            $wp_customize->add_setting('amoja_options_social_share_pinterest', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_pinterest', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Pinterest', 'amoja'),
            ));
            $wp_customize->add_setting('amoja_options_social_share_email', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('amoja_options_social_share_email', array(
                'type'    => 'checkbox',
                'section' => 'amoja_social',
                'label'   => esc_html__('Share on Email', 'amoja'),
            ));
        }
    }
}
return new Amoja_Customize();
