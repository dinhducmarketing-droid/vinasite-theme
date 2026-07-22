<?php
/**
 * VinaSite – meta description trang chủ (generic).
 *
 * Theme cha KHÔNG phát schema theo ngành (vd LegalService) — đó là việc của
 * child theme theo lĩnh vực. Chỉ đặt meta description cho trang chủ giới thiệu
 * VinaSite, và chỉ khi Rank Math không quản lý (tránh trùng).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', 'dragon_meta_description', 1);
function dragon_meta_description()
{
    if (!is_front_page() || defined('RANK_MATH_VERSION')) {
        return;
    }
    // Site di cư: nội dung trang chủ là của họ, theme không áp mô tả nào.
    if (vinasite_home_preset() === 'content') {
        return;
    }

    // Trang chủ giới thiệu VinaSite: ưu tiên mô tả site, trống thì dùng blurb theme.
    $mo_ta = get_bloginfo('description');
    if ($mo_ta === '') {
        $mo_ta = 'Giao diện VinaSite — website WordPress nhẹ, chuẩn SEO, tự cập nhật, do Công ty TNHH VinaSite Việt Nam thiết kế và phát triển.';
    }
    echo '<meta name="description" content="' . esc_attr($mo_ta) . '"/>' . "\n";
}
