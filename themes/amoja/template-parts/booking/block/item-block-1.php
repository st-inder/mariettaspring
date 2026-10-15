<?php
$babe_post  = BABE_Post_types::get_post($post['ID']);
$image_srcs = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), 'amoja-item');
$item_url    = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);
$price_old   = $post['discount_price_from'] < $post['price_from'] ? '<span class="item_info_price_old">' . BABE_Currency::get_currency_price($post['price_from']) . '</span>' : '';
$discount    = $post['discount'] ? '<span class="item_info_price_discount">' . $post['discount'] . esc_html__('% Off', 'amoja') . '</span>' : '';
$item_class  = isset($settings['enable_carousel']) && $settings['enable_carousel'] == 'yes' ? 'swiper-slide' : 'grid-item';
$room_area   = isset($babe_post['amoja_room_area']) ? $babe_post['amoja_room_area'] : false;
$room_beds   = isset($babe_post['amoja_beds']) ? $babe_post['amoja_beds'] : false;
$min_guests   = isset($babe_post['min_guests']) ? $babe_post['min_guests'] : false;
$guests   = isset($babe_post['guests']) ? $babe_post['guests'] : false;
?>
<div class="babe_items babe_items_1 <?php echo esc_attr($item_class); ?>">
    <div class="babe_all_items_item_inner">
        <div class="item_img">
            <div class="items_labels">
                <?php printf('%s', $discount); ?>
            </div>

            <div class="item_info_price">
                <label><?php echo esc_html__('from', 'amoja'); ?></label>
                <span class="item_info_price_new"><?php echo BABE_Currency::get_currency_price($post['discount_price_from']); ?></span>
                <?php printf('%s', $price_old); ?>
                <?php ?>
            </div>
            <?php echo has_post_thumbnail($post['ID']) ? '<a class="item-thumb" href="' . $item_url . '"><img src="' . $image_srcs[0] . '" alt="' . esc_attr($post['post_title']) . '"></a>' : ''; ?>
        </div>
        <div class="item_text">
            <div class="item_title delta">
                <a href="<?php echo esc_url($item_url); ?>"><?php echo apply_filters('translate_text', $post['post_title']); ?></a>
            </div>
            <div class="item-meta">
                <?php if (!empty($room_area)) { ?>
                    <div class="item-room-area">
                        <span>
                            <?php printf('%s', esc_html($room_area)); ?>
                        </span>
                    </div>
                <?php } ?>
                <?php if (!empty($min_guests) || !empty($guests)) { ?>
                    <div class="item-room-guests">
                        <span>
                            <?php printf('%1$s-%2$s %3$s', esc_html($min_guests), esc_html($guests), esc_html__('person', 'amoja')); ?>
                        </span>
                    </div>
                <?php } ?>
                <?php if (!empty($room_beds)) { ?>
                    <div class="item-room-beds">
                        <span>
                            <?php printf('%s %s', esc_html($room_beds), esc_html__('beds', 'amoja')); ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>