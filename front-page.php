<?php
/**
 * Trang chủ — theme generic, chọn nội dung theo kiểu (Customizer → "VinaSite – Kiểu trang chủ").
 *
 *  - content : render NỘI DUNG trang chủ soạn trong WordPress (shortcode page
 *              builder chạy qua shim). Dùng cho site di cư từ Flatsome.
 *  - vinasite: giới thiệu theme VinaSite + dịch vụ (mặc định, site cài mới).
 *
 * Nội dung chuyên biệt theo lĩnh vực (vd hãng luật) do CHILD THEME cung cấp:
 * child ghi đè front-page.php này. Theme cha không chứa nội dung ngành nghề nào.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (vinasite_home_preset() === 'content') {
    echo '<div class="vs-legacy-home">';
    while (have_posts()) {
        the_post();
        the_content();
    }
    echo '</div>';
} else {
    $parts = array(
        'vinasite/hero',
        'vinasite/features',
        'vinasite/services',
        'vinasite/pricing',
        'vinasite/contact',
    );
    foreach ($parts as $part) {
        get_template_part('template-parts/' . $part);
    }
}

get_footer();
