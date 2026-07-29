<?php
/**
 * VinaSite – WordPress Customizer panel.
 * Native (no plugin) admin editing for the centralised business info & links.
 *
 * @package vinasite
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('customize_register', 'vinasite_customize_register');
function vinasite_customize_register($wp_customize)
{
    $wp_customize->add_section('vinasite_business', array(
        'title'    => 'VinaSite – Thông tin & Trang chủ',
        'priority' => 20,
    ));

    $fields = array(
        'vinasite_company_short' => array('Tên hiển thị ngắn (dùng trong tiêu đề/nội dung trang)', ''),
        'vinasite_phone'        => array('Điện thoại chính (hiển thị)', ''),
        'vinasite_hotline'      => array('Hotline / tổng đài', ''),
        'vinasite_show_hotline' => array('Hiện hotline? (1 = có, 0 = ẩn)', '1'),
        'vinasite_email'        => array('Email', ''),
        'vinasite_zalo'         => array('Số Zalo (chỉ số)', ''),
        'vinasite_address'      => array('Địa chỉ trụ sở', ''),
        'vinasite_work_hours'   => array('Thời gian tiếp nhận tư vấn', ''),
        'vinasite_map_embed'    => array('Link nhúng Google Maps (embed)', ''),
        'vinasite_form_email'   => array('Email nhận đơn tư vấn', ''),
        'vinasite_ga_ids'       => array('Mã Google Analytics (G-XXXX; nhiều mã cách nhau dấu phẩy)', ''),
        'vinasite_facebook'     => array('Link Facebook (nếu có)', ''),
        'vinasite_youtube'      => array('Link YouTube (nếu có)', ''),
        'vinasite_hero_img'     => array('Ảnh nền banner hero (URL)', 'ảnh văn phòng'),
        'vinasite_about_img'    => array('Ảnh khối Giới thiệu (URL)', 'ảnh đội ngũ'),
        'vinasite_featured_img' => array('Ảnh băng showcase (URL)', 'ảnh nổi bật'),
        'vinasite_cta_img'      => array('Ảnh nền dải CTA (URL)', 'ảnh tư vấn'),
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
            'section'     => 'vinasite_business',
            'type'        => (strlen($meta[0]) > 30 || strpos($id, 'address') || strpos($id, 'map') || strpos($id, 'hours')) ? 'textarea' : 'text',
            'priority'    => $priority++,
        ));
    }
}
