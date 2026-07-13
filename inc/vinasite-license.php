<?php
/**
 * VinaSite – Kiểm soát bản quyền (license-lite).
 *
 * CẤP HIỆN TẠI (nhẹ):
 *   - Nhắc nhở MỀM trong admin nếu tên miền không nằm trong danh sách cấp phép.
 *   - KHÔNG chặn site (tránh làm hỏng site khách).
 *   - Mặc định: danh sách rỗng = không giới hạn, không làm phiền.
 *
 * KIỂM SOÁT THẬT (cập nhật) đến từ: repo Private + Git Updater — chỉ những site
 * bạn cấu hình token mới nhận được bản cập nhật.
 *
 * NÂNG CẤP SAU (khi bán ra ngoài): nối hàm vinasite_is_licensed() tới server cấp
 * key (Freemius, Software License Manager…) để chặn cứng. Chỉ cần đổi phần thân
 * hàm hoặc dùng filter 'vinasite_is_licensed'; toàn bộ chỗ khác giữ nguyên.
 *
 * Cách cấp phép cho 1 site: trên site đó chạy
 *   wp option update vinasite_licensed_domains "tenmien.com"
 * (nhiều tên miền cách nhau dấu phẩy). Bỏ trống = không giới hạn.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Chuẩn hoá 1 tên miền: bỏ http(s)://, www., dấu / cuối, hạ chữ thường. */
function vinasite_norm_domain($d)
{
    $d = preg_replace('#^https?://#i', '', trim((string) $d));
    $d = preg_replace('#^www\.#i', '', $d);
    return strtolower(rtrim($d, '/'));
}

/** Danh sách tên miền được cấp phép (rỗng = không giới hạn). */
function vinasite_licensed_domains()
{
    $raw  = (string) get_option('vinasite_licensed_domains', '');
    $list = array_filter(array_map('trim', explode(',', $raw)));
    $list = apply_filters('vinasite_licensed_domains', $list);
    return array_values(array_unique(array_map('vinasite_norm_domain', $list)));
}

/** Tên miền hiện tại của site. */
function vinasite_host()
{
    $h = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (string) wp_parse_url(home_url(), PHP_URL_HOST);
    return vinasite_norm_domain($h);
}

/**
 * Site có được cấp phép không?
 * Rỗng danh sách = true (không giới hạn). Lọc được qua 'vinasite_is_licensed'
 * để sau này nối tới server cấp key.
 */
function vinasite_is_licensed()
{
    $domains = vinasite_licensed_domains();
    $ok = empty($domains) || in_array(vinasite_host(), $domains, true);
    return (bool) apply_filters('vinasite_is_licensed', $ok);
}

/** Nhắc nhở MỀM trong admin (không chặn). Chỉ hiện khi đã cấu hình domain và không khớp. */
add_action('admin_notices', 'vinasite_license_notice');
function vinasite_license_notice()
{
    if (vinasite_is_licensed() || !current_user_can('manage_options')) {
        return;
    }
    echo '<div class="notice notice-warning is-dismissible"><p>'
        . '<strong>Theme VinaSite</strong> — tên miền <code>' . esc_html(vinasite_host()) . '</code> '
        . 'chưa nằm trong danh sách được cấp phép. Vui lòng liên hệ '
        . '<strong>Vinasite Việt Nam · 052 897 6666</strong> để kích hoạt cho tên miền này.'
        . '</p></div>';
}
