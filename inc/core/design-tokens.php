<?php
/**
 * VinaSite – Design tokens per-site (màu sắc & phông chữ).
 *
 * Cho phép MỖI website tự đặt màu thương hiệu + font riêng qua Customizer,
 * không cần sửa code. Tông đậm/nhạt/hover được suy ra tự động từ 2 màu chính
 * nên chủ site chỉ cần chọn "Màu chính" + "Màu nhấn".
 *
 * An toàn: chỉ xuất CSS ghi đè khi site CÓ chọn màu riêng — nếu để trống,
 * theme dùng đúng bảng màu mặc định trong vs-base.css (không đổi giao diện).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Trộn 2 màu hex theo tỉ lệ $w (0..1 phần của $mix). Trả về hex. */
function vinasite_mix($hex, $mix, $w)
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
        '--vs-primary'      => '#1e5aa8', // xanh VinaSite đậm — nền hero, nút chính, tiêu đề
        '--vs-primary-dark' => '#174683',
        '--vs-secondary'    => '#4790cd', // xanh logo
        '--vs-accent'       => '#e51e22', // đỏ logo — mảng nhấn, viền, nền tag
        '--vs-accent-hover' => '#c4171b',
        '--vs-gold-text'    => '#c4171b', // đỏ đậm — CHỮ nhấn trên nền sáng (đạt AA)
        '--vs-lotus'        => '#ffd100', // vàng dòng tagline logo
        '--vs-lotus-soft'   => '#fff8dd',
        '--vs-bg-light'     => '#f5f9fd', // nền dịu tông lạnh, hợp thương hiệu xanh
        '--vs-bg-soft'      => '#eaf2fa',
        '--vs-border'       => '#d9e4f0',
    );
}

/** Danh mục phông chữ hỗ trợ (Google Fonts). */
function vinasite_font_map()
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
function vinasite_font_current()
{
    $map = vinasite_font_map();
    $key = get_theme_mod('vinasite_font_family', 'be-vietnam');
    if (!isset($map[$key])) { $key = 'be-vietnam'; }
    $data = $map[$key];
    $data['key'] = $key;
    return $data;
}

/** Sanitize lựa chọn font. */
function vinasite_sanitize_font($val)
{
    return array_key_exists($val, vinasite_font_map()) ? $val : 'be-vietnam';
}

/** Đăng ký mục Customizer "Màu sắc & Font". */
add_action('customize_register', 'vinasite_design_customize');
function vinasite_design_customize($wp_customize)
{
    $wp_customize->add_section('vinasite_design', array(
        'title'    => 'VinaSite – Màu sắc & Phông chữ',
        'priority' => 19,
    ));

    // Màu chính
    $wp_customize->add_setting('vinasite_color_primary', array(
        'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vinasite_color_primary', array(
        'label'       => 'Màu chính (thương hiệu)',
        'description' => 'Dùng cho tiêu đề, header, nút chính. Để trống = giữ màu mặc định của theme.',
        'section'     => 'vinasite_design',
        'priority'    => 10,
    )));

    // Màu nhấn
    $wp_customize->add_setting('vinasite_color_accent', array(
        'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vinasite_color_accent', array(
        'label'       => 'Màu nhấn (nút, điểm nhấn)',
        'description' => 'Dùng cho nút gọi, điểm nhấn, gạch chân tiêu đề.',
        'section'     => 'vinasite_design',
        'priority'    => 20,
    )));

    // Phông chữ
    $choices = array();
    foreach (vinasite_font_map() as $k => $f) { $choices[$k] = $f['label']; }
    $wp_customize->add_setting('vinasite_font_family', array(
        'default' => 'be-vietnam', 'sanitize_callback' => 'vinasite_sanitize_font', 'transport' => 'refresh',
    ));
    $wp_customize->add_control('vinasite_font_family', array(
        'label'    => 'Phông chữ toàn site',
        'section'  => 'vinasite_design',
        'type'     => 'select',
        'choices'  => $choices,
        'priority' => 30,
    ));
}

/**
 * Dựng chuỗi CSS token màu/font của site (dùng chung cho frontend VÀ trình
 * soạn thảo block — editor cần đúng biến này để bảng màu theme.json hiển thị
 * đúng màu thương hiệu từng site).
 */
function vinasite_design_tokens_css()
{
    $vars  = array();
    $them  = ''; // CSS bổ sung ngoài :root

    $primary_mod = sanitize_hex_color((string) get_theme_mod('vinasite_color_primary', ''));
    $accent_mod  = sanitize_hex_color((string) get_theme_mod('vinasite_color_accent', ''));
    $la_vinasite = vinasite_home_preset() === 'vinasite';

    if ($primary_mod || $accent_mod) {
        // Chủ site tự chọn màu → suy ra các tông còn lại. Màu nào bỏ trống thì lấy
        // theo bảng màu mặc định của preset đang dùng.
        $primary = $primary_mod ? $primary_mod : ($la_vinasite ? '#1e5aa8' : '#4a2c17');
        $accent  = $accent_mod ? $accent_mod : ($la_vinasite ? '#e51e22' : '#d99a1c');
        $vars['--vs-primary']       = $primary;
        $vars['--vs-primary-dark']  = vinasite_mix($primary, '#000000', 0.22);
        $vars['--vs-secondary']     = vinasite_mix($primary, '#ffffff', 0.22);
        $vars['--vs-accent']        = $accent;
        $vars['--vs-accent-hover']  = vinasite_mix($accent, '#000000', 0.16);
        $vars['--vs-gold-text']     = vinasite_mix($accent, '#000000', 0.42);
    } elseif ($la_vinasite) {
        // Chưa chọn màu + đang dùng giao diện VinaSite → đồng bộ theo màu logo.
        // (Site preset khác không vào nhánh này nên giữ nguyên tông mặc định.)
        $vars = vinasite_logo_palette();

        // Nút mặc định có nền = màu nhấn (đỏ logo). Chữ mặc định là màu chính đậm
        // (xanh) sẽ không đọc được trên nền đỏ → ép chữ trắng.
        $them .= '.vs-btn{--_fg:#fff;}.vs-btn:hover{color:#fff;}';
        // Viền card khi hover: mặc định là be nâu, đổi sang xanh nhạt cho hợp tông.
        $them .= '.vs-card:hover{border-color:#b9d2ea;}';
    }

    // Font: luôn xuất theo lựa chọn (mặc định = be-vietnam = giống hiện tại).
    $font = vinasite_font_current();
    $vars['--vs-font'] = $font['stack'];

    $css = ':root{';
    foreach ($vars as $k => $v) { $css .= $k . ':' . $v . ';'; }
    $css .= '}' . $them;

    return $css;
}

/** Xuất CSS ghi đè token màu/font ra frontend. */
add_action('wp_enqueue_scripts', 'vinasite_output_design_tokens', 30);
function vinasite_output_design_tokens()
{
    wp_add_inline_style('vs-base', vinasite_design_tokens_css());
}
