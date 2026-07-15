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

/**
 * Bảng màu lấy từ LOGO VinaSite (chữ V xanh + đỏ, dòng tagline vàng).
 * Màu gốc đo trực tiếp từ file logo: đỏ #ed2024, xanh #4790cd.
 *
 * Các sắc độ dưới đây bám sát màu logo nhưng đã chỉnh để chữ đọc được
 * (đo bằng công thức tương phản WCAG, chuẩn AA = 4.5:1):
 *  - Xanh logo #4790cd làm nền + chữ trắng chỉ đạt 3.4:1 → màu chính dùng bản
 *    xanh đậm cùng tông #1e5aa8 (6.8:1, cũng là màu đang dùng ở trang admin);
 *    xanh logo giữ vai trò màu phụ.
 *  - Đỏ logo #ed2024 làm nền + chữ trắng chỉ đạt 4.35:1 → màu nhấn dùng #e51e22
 *    (4.6:1), lệch 8 đơn vị kênh đỏ nên mắt thường không phân biệt được.
 *  - Đỏ làm CHỮ trên nền sáng cần đậm hơn nữa → #c4171b (6.0:1).
 */
function vinasite_logo_palette()
{
    return array(
        '--dragon-primary'      => '#1e5aa8', // xanh VinaSite đậm — nền hero, nút chính, tiêu đề
        '--dragon-primary-dark' => '#174683',
        '--dragon-secondary'    => '#4790cd', // xanh logo
        '--dragon-accent'       => '#e51e22', // đỏ logo — mảng nhấn, viền, nền tag
        '--dragon-accent-hover' => '#c4171b',
        '--dragon-gold-text'    => '#c4171b', // đỏ đậm — CHỮ nhấn trên nền sáng (đạt AA)
        '--dragon-lotus'        => '#ffd100', // vàng dòng tagline logo
        '--dragon-lotus-soft'   => '#fff8dd',
        '--dragon-bg-light'     => '#f5f9fd', // nền dịu tông lạnh, hợp thương hiệu xanh
        '--dragon-bg-soft'      => '#eaf2fa',
        '--dragon-border'       => '#d9e4f0',
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
    $vars  = array();
    $them  = ''; // CSS bổ sung ngoài :root

    $primary_mod = sanitize_hex_color((string) get_theme_mod('dragon_color_primary', ''));
    $accent_mod  = sanitize_hex_color((string) get_theme_mod('dragon_color_accent', ''));
    $la_vinasite = vinasite_home_preset() === 'vinasite';

    if ($primary_mod || $accent_mod) {
        // Chủ site tự chọn màu → suy ra các tông còn lại. Màu nào bỏ trống thì lấy
        // theo bảng màu mặc định của preset đang dùng.
        $primary = $primary_mod ? $primary_mod : ($la_vinasite ? '#1e5aa8' : '#4a2c17');
        $accent  = $accent_mod ? $accent_mod : ($la_vinasite ? '#e51e22' : '#d99a1c');
        $vars['--dragon-primary']       = $primary;
        $vars['--dragon-primary-dark']  = dragon_mix($primary, '#000000', 0.22);
        $vars['--dragon-secondary']     = dragon_mix($primary, '#ffffff', 0.22);
        $vars['--dragon-accent']        = $accent;
        $vars['--dragon-accent-hover']  = dragon_mix($accent, '#000000', 0.16);
        $vars['--dragon-gold-text']     = dragon_mix($accent, '#000000', 0.42);
    } elseif ($la_vinasite) {
        // Chưa chọn màu + đang dùng giao diện VinaSite → đồng bộ theo màu logo.
        // (Site preset "dragon" không vào nhánh này nên giữ nguyên tông nâu/vàng.)
        $vars = vinasite_logo_palette();

        // Nút mặc định có nền = màu nhấn (đỏ logo). Chữ mặc định là màu chính đậm
        // (xanh) sẽ không đọc được trên nền đỏ → ép chữ trắng.
        $them .= '.dragon-btn{--_fg:#fff;}.dragon-btn:hover{color:#fff;}';
        // Viền card khi hover: mặc định là be nâu, đổi sang xanh nhạt cho hợp tông.
        $them .= '.dragon-card:hover{border-color:#b9d2ea;}';
    }

    // Font: luôn xuất theo lựa chọn (mặc định = be-vietnam = giống hiện tại).
    $font = dragon_font_current();
    $vars['--dragon-font'] = $font['stack'];

    $css = ':root{';
    foreach ($vars as $k => $v) { $css .= $k . ':' . $v . ';'; }
    $css .= '}' . $them;

    wp_add_inline_style('dragon-base', $css);
}
