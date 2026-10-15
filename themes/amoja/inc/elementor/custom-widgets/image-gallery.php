<?php
// Image Gallery
use Elementor\Controls_Manager;
add_action( 'elementor/element/image-gallery/section_gallery/before_section_end', function ( $element, $args ) {
    $element->add_control(
        'image_gallery_layout',
        [
            'label' => esc_html__('Layout Special', 'amoja'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'prefix_class' => 'image-gallery-layout-special-',
        ]
    );
}, 10, 2 );
