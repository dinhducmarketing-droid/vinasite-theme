<?php
/**
 * Trang chủ — chọn nội dung theo preset (Customizer → "VinaSite – Kiểu trang chủ").
 *
 *  - vinasite (mặc định): giới thiệu theme VinaSite + dịch vụ của VinaSite.
 *  - dragon: trang chủ bespoke của Công ty Luật TNHH Dragon (site cũ giữ nguyên).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

if (vinasite_home_preset() === 'dragon') {
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
} else {
    $parts = array(
        'vinasite/hero',
        'vinasite/features',
        'vinasite/services',
        'vinasite/pricing',
        'vinasite/contact',
    );
}

foreach ($parts as $part) {
    get_template_part('template-parts/' . $part);
}

get_footer();
