<?php
/**
 * VinaSite – Design tokens per-site (màu sắc & phông chữ).
 *
 * Cho phép MỖI website tự đặt màu thương hiệu + font riêng qua Customizer,
 * không cần sửa code. Tông đậm/nhạt/hover được suy ra tự động từ 2 màu chính
 * nên chủ site chỉ cần chọn "Màu chính" + "Màu nhấn".
 *
 * An toàn: chỉ xuất CSS ghi đè khi site CÓ chọn màu riêng — nếu để trống,
 * theme dùng đúng bảng màu mặc định trong dragon-base.css (không đổi giao diện).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Trộn 2 màu hex theo tỉ lệ $w (0..1 phần của $mix). Trả về hex. */
function dragon_mix($hex, $mix, $w)
{
    $parse = function ($h) {
        $h = ltrim((string) $h, '#');
        if (strlen($h) === 3) { $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2]; }
        if (strlen($h) !== 6) { $h = '000000'; }
        return array(hexdec(substr($h, 0, 2)), hexdec(substr($h, 2, 2)), hexdec(substr($h, 4, 2)));
    };
    list($r1, $g1, $b1) = $parse($hex);
    list($r2, $g2, $b2) = $parse($mix);
    $w = max(0, min(1, (float) $w));
    return sprintf(
        '#%02x%02x%02x',
        (int) round($r1 * (1 - $w) + $r2 * $w),
        (int) round($g1 * (1 - $w) + $g2 * $w),
        (int) round($b1 * (1 - $w) + $b2 * $w)
    );
}

/** Danh mục phông chữ hỗ trợ (Google Fonts). */
function dragon_font_map()
{
    return array(
        'be-vietnam' => array('label' => 'Be Vietnam Pro (mặc định)', 'query' => 'Be+Vietnam+Pro:wght@400;600;700', 'stack' => '"Be Vietnam Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'),
        'inter'      => array('label' => 'Inter',        'query' => 'Inter:wght@400;600;700',        'stack' => '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'),
        'roboto'     => array('label' => 'Roboto',       'query' => 'Roboto:wght@400;500;700',       'stack' => '"Roboto", -apple-system, "Segoe UI", Arial, sans-serif'),
        'montserrat' => array('label' => 'Montserrat',   'query' => 'Montserrat:wght@400;600;700',   'stack' => '"Montserrat", -apple-system, "Segoe UI", Arial, sans-serif'),
        'open-sans'  => array('label' => 'Open Sans',    'query' => 'Open+Sans:wght@400;600;700',    'stack' => '"Open Sans", -apple-system, "Segoe UI", Arial, sans-serif'),
        'lora'       => array('label' => 'Lora (serif)', 'query' => 'Lora:wght@400;600;700',         'stack' => '"Lora", Georgia, "Times New Roman", serif'),
    );
}

/** Font đang chọn (fallback về be-vietnam). */
function dragon_font_current()
{
    $map = dragon_font_map();
    $key = get_theme_mod('dragon_font_family', 'be-vietnam');
    if (!isset($map[$key])) { $key = 'be-vietnam'; }
    $data = $map[$key];
    $data['key'] = $key;
    return $data;
}

/** Sanitize lựa chọn font. */
function dragon_sanitize_font($val)
{
    return array_key_exists($val, dragon_font_map()) ? $val : 'be-vietnam';
}

/** Đăng ký mục Customizer "Màu sắc & Font". */
add_action('customize_register', 'dragon_design_customize');
function dragon_design_customize($wp_customize)
{
    $wp_customize->add_section('dragon_design', array(
        'title'    => 'VinaSite – Màu sắc & Phông chữ',
        'priority' => 19,
    ));

    // Màu chính
    $wp_customize->add_setting('dragon_color_primary', array(
        'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dragon_color_primary', array(
        'label'       => 'Màu chính (thương hiệu)',
        'description' => 'Dùng cho tiêu đề, header, nút chính. Để trống = giữ màu mặc định của theme.',
        'section'     => 'dragon_design',
        'priority'    => 10,
    )));

    // Màu nhấn
    $wp_customize->add_setting('dragon_color_accent', array(
        'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dragon_color_accent', array(
        'label'       => 'Màu nhấn (nút, điểm nhấn)',
        'description' => 'Dùng cho nút gọi, điểm nhấn, gạch chân tiêu đề.',
        'section'     => 'dragon_design',
        'priority'    => 20,
    )));

    // Phông chữ
    $choices = array();
    foreach (dragon_font_map() as $k => $f) { $choices[$k] = $f['label']; }
    $wp_customize->add_setting('dragon_font_family', array(
        'default' => 'be-vietnam', 'sanitize_callback' => 'dragon_sanitize_font', 'transport' => 'refresh',
    ));
    $wp_customize->add_control('dragon_font_family', array(
        'label'    => 'Phông chữ toàn site',
        'section'  => 'dragon_design',
        'type'     => 'select',
        'choices'  => $choices,
        'priority' => 30,
    ));
}

/** Xuất CSS ghi đè token màu/font (chỉ khi site có tùy chỉnh). */
add_action('wp_enqueue_scripts', 'dragon_output_design_tokens', 30);
function dragon_output_design_tokens()
{
    $vars = array();

    $primary_mod = sanitize_hex_color((string) get_theme_mod('dragon_color_primary', ''));
    $accent_mod  = sanitize_hex_color((string) get_theme_mod('dragon_color_accent', ''));

    // Chỉ ghi đè màu khi chủ site đã chọn ít nhất 1 màu (giữ nguyên giao diện mặc định).
    if ($primary_mod || $accent_mod) {
        $primary = $primary_mod ? $primary_mod : '#4a2c17';
        $accent  = $accent_mod ? $accent_mod : '#d99a1c';
        $vars['--dragon-primary']       = $primary;
        $vars['--dragon-primary-dark']  = dragon_mix($primary, '#000000', 0.22);
        $vars['--dragon-secondary']     = dragon_mix($primary, '#ffffff', 0.22);
        $vars['--dragon-accent']        = $accent;
        $vars['--dragon-accent-hover']  = dragon_mix($accent, '#000000', 0.16);
        $vars['--dragon-gold-text']     = dragon_mix($accent, '#000000', 0.42);
    }

    // Font: luôn xuất theo lựa chọn (mặc định = be-vietnam = giống hiện tại).
    $font = dragon_font_current();
    $vars['--dragon-font'] = $font['stack'];

    if (empty($vars)) { return; }

    $css = ':root{';
    foreach ($vars as $k => $v) { $css .= $k . ':' . $v . ';'; }
    $css .= '}';

    wp_add_inline_style('dragon-base', $css);
}
