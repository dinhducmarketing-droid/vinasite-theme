<?php
/**
 * VinaSite – Block Patterns (bộ dựng trang kéo-thả bằng Gutenberg).
 *
 * Đóng gói các section của theme thành MẪU trong nút "+" của trình soạn thảo:
 * chèn → sửa chữ/ảnh trực tiếp → xong. Nội dung lưu trong database (như kiểu
 * trang chủ "content") nên update theme không bao giờ đụng tới.
 *
 * Màu trong pattern dùng bảng màu theme.json → trỏ về biến --dragon-* nên tự
 * theo màu thương hiệu từng site (Customizer → VinaSite – Màu sắc & Phông chữ).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/* -------------------------------------------------------------------------
 * Editor: nạp token màu/font của site vào canvas soạn thảo, để bảng màu
 * theme.json hiển thị đúng màu thương hiệu (biến --dragon-* vốn chỉ có ở
 * frontend). Dùng block_editor_settings_all để CSS vào đúng iframe canvas.
 * ---------------------------------------------------------------------- */
add_filter('block_editor_settings_all', 'vinasite_editor_tokens');
function vinasite_editor_tokens($settings)
{
    if (function_exists('dragon_design_tokens_css')) {
        $settings['styles'][] = array('css' => dragon_design_tokens_css());
    }
    return $settings;
}

/* CSS của pattern: nạp cả frontend (mọi trang — file rất nhẹ) lẫn editor. */
add_action('wp_enqueue_scripts', 'vinasite_patterns_css', 25);
function vinasite_patterns_css()
{
    $ver = defined('DRAGON_ASSET_VER') ? DRAGON_ASSET_VER : '1.0.0';
    wp_enqueue_style('vinasite-patterns', get_template_directory_uri() . '/assets/dragon/css/vinasite-patterns.css', array(), $ver);
}

add_action('after_setup_theme', 'vinasite_patterns_editor_style');
function vinasite_patterns_editor_style()
{
    add_theme_support('editor-styles');
    add_editor_style('assets/dragon/css/vinasite-patterns.css');
}

/* -------------------------------------------------------------------------
 * Đăng ký nhóm + các pattern.
 * ---------------------------------------------------------------------- */
add_action('init', 'vinasite_register_patterns');
function vinasite_register_patterns()
{
    if (!function_exists('register_block_pattern')) {
        return;
    }

    register_block_pattern_category('vinasite', array('label' => 'VinaSite'));

    /* ---------- 1. Hero trang chủ ---------- */
    register_block_pattern('vinasite/hero', array(
        'title'       => 'VinaSite – Hero trang chủ',
        'description' => 'Khối mở đầu trang chủ: nhãn nhỏ, tiêu đề H1, mô tả và 2 nút CTA.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"vs-primary","textColor":"vs-white","className":"vsp-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vsp-hero has-vs-white-color has-vs-primary-background-color has-text-color has-background"><!-- wp:paragraph {"className":"vsp-eyebrow"} -->
<p class="vsp-eyebrow">TÊN CÔNG TY CỦA BẠN</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-x-large-font-size">Tiêu đề chính của trang — nói rõ bạn giúp khách điều gì</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Một đoạn mô tả ngắn 1–2 câu về dịch vụ và giá trị bạn mang lại cho khách hàng.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"vs-accent","textColor":"vs-white"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-vs-white-color has-vs-accent-background-color has-text-color has-background wp-element-button" href="#lien-he">Nhận tư vấn miễn phí</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","textColor":"vs-white"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-vs-white-color has-text-color wp-element-button" href="tel:0000000000">Gọi ngay</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 2. Lưới dịch vụ 3 cột ---------- */
    $the_dich_vu = '<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"vsp-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-card"><!-- wp:heading {"level":3,"textColor":"vs-primary"} -->
<h3 class="wp-block-heading has-vs-primary-color has-text-color">Tên dịch vụ</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"vs-muted","fontSize":"small"} -->
<p class="has-vs-muted-color has-text-color has-small-font-size">Mô tả ngắn 2–3 dòng về dịch vụ này và lợi ích cho khách hàng.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"vs-accent-text","fontSize":"small"} -->
<p class="has-vs-accent-text-color has-text-color has-small-font-size"><a href="#lien-he">Tư vấn dịch vụ này →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->';

    register_block_pattern('vinasite/dich-vu', array(
        'title'       => 'VinaSite – Lưới dịch vụ',
        'description' => 'Tiêu đề section + 6 card dịch vụ (2 hàng × 3 cột). Nhân bản/xoá card tuỳ ý.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"vs-bg-light","className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vsp-section has-vs-bg-light-background-color has-background"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Dịch vụ của chúng tôi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"vs-muted"} -->
<p class="has-text-align-center has-vs-muted-color has-text-color">Một câu dẫn ngắn về nhóm dịch vụ bên dưới.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns">' . $the_dich_vu . $the_dich_vu . $the_dich_vu . '</div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns">' . $the_dich_vu . $the_dich_vu . $the_dich_vu . '</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 3. FAQ (accordion native, không cần JS) ---------- */
    $cau_hoi = '<!-- wp:details {"className":"vsp-faq-item"} -->
<details class="wp-block-details vsp-faq-item"><summary>Câu hỏi thường gặp — sửa câu hỏi ở đây?</summary><!-- wp:paragraph -->
<p>Câu trả lời viết ở đây. Ngắn gọn, đúng chính sách thực tế của bạn.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->';

    register_block_pattern('vinasite/faq', array(
        'title'       => 'VinaSite – Câu hỏi thường gặp (FAQ)',
        'description' => 'Accordion bấm mở/đóng, không cần JavaScript. Nhân bản để thêm câu hỏi.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-section"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Câu hỏi thường gặp</h2>
<!-- /wp:heading -->

' . $cau_hoi . '

' . $cau_hoi . '

' . $cau_hoi . '

' . $cau_hoi . '</div>
<!-- /wp:group -->',
    ));

    /* ---------- 4. Dải CTA ---------- */
    register_block_pattern('vinasite/cta', array(
        'title'       => 'VinaSite – Dải kêu gọi hành động (CTA)',
        'description' => 'Dải màu thương hiệu với tiêu đề + 2 nút, đặt giữa hoặc cuối trang.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"vs-primary","textColor":"vs-white","className":"vsp-cta","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vsp-cta has-vs-white-color has-vs-primary-background-color has-text-color has-background"><!-- wp:heading {"textAlign":"center","textColor":"vs-white"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-white-color has-text-color">Bạn cần được tư vấn cho trường hợp của mình?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Để lại thông tin hoặc gọi ngay — chúng tôi phản hồi trong thời gian sớm nhất.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"vs-accent","textColor":"vs-white"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-vs-white-color has-vs-accent-background-color has-text-color has-background wp-element-button" href="tel:0000000000">Gọi ngay</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","textColor":"vs-white"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-vs-white-color has-text-color wp-element-button" href="#lien-he">Gửi yêu cầu tư vấn</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ));
}
