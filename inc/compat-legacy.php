<?php
/**
 * VinaSite – lớp tương thích ngược (LEGACY).
 *
 * Từ bản đổi tên dragon_* → vinasite_*, các child theme khách cũ vẫn gọi hàm
 * tên dragon_*(). File này định nghĩa hàm cũ như "vỏ bọc" chuyển tiếp sang hàm
 * mới, nên KHÔNG sập site nào. Chỉ giữ để tương thích — code chính dùng
 * vinasite_*().
 *
 * Có thể bỏ file này sau khi TẤT CẢ child theme đã đổi sang gọi vinasite_*().
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Bảng hàm cũ → hàm mới. */
$vinasite_legacy_map = array(
    'dragon_opt'                  => 'vinasite_opt',
    'dragon_tel'                  => 'vinasite_tel',
    'dragon_brand'                => 'vinasite_brand',
    'dragon_logo_url'             => 'vinasite_logo_url',
    'dragon_cat_url'              => 'vinasite_cat_url',
    'dragon_the_icon'             => 'vinasite_the_icon',
    'dragon_icon'                 => 'vinasite_icon',
    'dragon_acf_contact'          => 'vinasite_acf_contact',
    'dragon_mix'                  => 'vinasite_mix',
    'dragon_font_map'             => 'vinasite_font_map',
    'dragon_font_current'         => 'vinasite_font_current',
    'dragon_sanitize_font'        => 'vinasite_sanitize_font',
    'dragon_design_tokens_css'    => 'vinasite_design_tokens_css',
    'dragon_practice_areas'       => 'vinasite_practice_areas',
    'dragon_hero_slides'          => 'vinasite_hero_slides',
    'dragon_faq_items'            => 'vinasite_faq_items',
    'dragon_private_upload_dir'   => 'vinasite_private_upload_dir',
    'dragon_obfuscate_filename'   => 'vinasite_obfuscate_filename',
    'dragon_consultation_respond' => 'vinasite_consultation_respond',
    'dragon_handle_consultation'  => 'vinasite_handle_consultation',
);

foreach ($vinasite_legacy_map as $old => $new) {
    if (!function_exists($old) && function_exists($new)) {
        // eval là cách gọn để tạo vỏ bọc forwarding cho từng hàm; chuỗi cố định,
        // không có dữ liệu người dùng nên an toàn.
        eval("function {$old}() { return call_user_func_array('{$new}', func_get_args()); }");
    }
}
unset($vinasite_legacy_map, $old, $new);
