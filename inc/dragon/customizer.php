<?php
/**
 * Dragon – WordPress Customizer panel.
 * Native (no plugin) admin editing for the centralised business info & links.
 *
 * @package ntgsite-dragon
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('customize_register', 'dragon_customize_register');
function dragon_customize_register($wp_customize)
{
    $wp_customize->add_section('dragon_business', array(
        'title'    => 'VinaSite – Thông tin & Trang chủ',
        'priority' => 20,
    ));

    $fields = array(
        'dragon_company_short' => array('Tên hiển thị ngắn (dùng trong tiêu đề/nội dung trang)', ''),
        'dragon_phone'        => array('Điện thoại chính (hiển thị)', ''),
        'dragon_hotline'      => array('Hotline / tổng đài', ''),
        'dragon_show_hotline' => array('Hiện hotline? (1 = có, 0 = ẩn)', '1'),
        'dragon_email'        => array('Email', ''),
        'dragon_zalo'         => array('Số Zalo (chỉ số)', ''),
        'dragon_address'      => array('Địa chỉ trụ sở', ''),
        'dragon_work_hours'   => array('Thời gian tiếp nhận tư vấn', ''),
        'dragon_map_embed'    => array('Link nhúng Google Maps (embed)', ''),
        'dragon_form_email'   => array('Email nhận đơn tư vấn', ''),
        'dragon_ga_ids'       => array('Mã Google Analytics (G-XXXX; nhiều mã cách nhau dấu phẩy)', ''),
        'dragon_facebook'     => array('Link Facebook (nếu có)', ''),
        'dragon_youtube'      => array('Link YouTube (nếu có)', ''),
        'dragon_hero_img'     => array('Ảnh nền banner hero (URL)', 'ảnh văn phòng'),
        'dragon_about_img'    => array('Ảnh khối Giới thiệu (URL)', 'ảnh đội ngũ'),
        'dragon_featured_img' => array('Ảnh băng showcase (URL)', 'ảnh nổi bật'),
        'dragon_cta_img'      => array('Ảnh nền dải CTA (URL)', 'ảnh tư vấn'),
    );

    $priority = 10;
    foreach ($fields as $id => $meta) {
        $wp_customize->add_setting($id, array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control($id, array(
            'label'       => $meta[0],
            'description' => $meta[1] !== '' ? 'Mặc định: ' . $meta[1] : '',
            'section'     => 'dragon_business',
            'type'        => (strlen($meta[0]) > 30 || strpos($id, 'address') || strpos($id, 'map') || strpos($id, 'hours')) ? 'textarea' : 'text',
            'priority'    => $priority++,
        ));
    }
}
