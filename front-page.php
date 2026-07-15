<?php
/**
 * Trang chủ — chọn nội dung theo kiểu trang chủ (Customizer → "VinaSite – Kiểu trang chủ").
 *
 *  - content : render NỘI DUNG trang chủ soạn trong WordPress (shortcode page
 *              builder chạy qua shim). Dùng cho site di cư từ Flatsome giữ
 *              nguyên bố cục cũ (vd vietnhatsknn.com). Sửa ở Trang > Trang chủ.
 *  - vinasite: giới thiệu theme VinaSite + dịch vụ — site cài theme lần đầu.
 *  - dragon  : trang chủ bespoke của Công ty Luật TNHH Dragon (mặc định cho các
 *              site đã chạy theme từ trước).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

$vinasite_che_do = vinasite_home_preset();

// Site di cư: trang chủ là nội dung page trong WP, không dựng từ template-parts.
if ($vinasite_che_do === 'content') {
    get_header();
    echo '<div class="vs-legacy-home">';
    while (have_posts()) {
        the_post();
        the_content();
    }
    echo '</div>';
    get_footer();
    return;
}

get_header();

if ($vinasite_che_do === 'vinasite') {
    $parts = array(
        'vinasite/hero',
        'vinasite/features',
        'vinasite/services',
        'vinasite/pricing',
        'vinasite/contact',
    );
} else {
    // Thứ tự khối theo bản thiết kế riêng của Dragon.
    $parts = array(
        'home/hero',
        'home/trust-bar',
        'home/about',
        'home/practice-areas',
        'home/problem-selector',
        'home/cta',
        'home/process',
        'home/lawyers',
        'home/achievements',
        'home/legal-posts',
        'home/testimonials',
        'home/faq',
        'home/consultation-form',
        'home/news', // đưa xuống cuối, ngay trên footer, theo yêu cầu.
    );
}

foreach ($parts as $part) {
    get_template_part('template-parts/' . $part);
}

get_footer();
