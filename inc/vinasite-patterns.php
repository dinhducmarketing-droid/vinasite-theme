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

    // Ảnh giữ chỗ (SVG xám, siêu nhẹ) — người dùng bấm vào ảnh để thay bằng ảnh thật.
    $anh_ngang = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 480'%3E%3Crect width='640' height='480' fill='%23e2ebf3'/%3E%3C/svg%3E";
    $anh_doc   = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 480 600'%3E%3Crect width='480' height='600' fill='%23e2ebf3'/%3E%3C/svg%3E";

    /* ---------- 5. Quy trình các bước ---------- */
    $buoc = function ($so, $ten) {
        return '<!-- wp:group {"className":"vsp-step","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-step"><!-- wp:paragraph {"className":"vsp-step-num","textColor":"vs-white","backgroundColor":"vs-primary"} -->
<p class="vsp-step-num has-vs-white-color has-vs-primary-background-color has-text-color has-background">' . $so . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"textColor":"vs-primary"} -->
<h3 class="wp-block-heading has-vs-primary-color has-text-color">' . $ten . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"vs-muted","fontSize":"small"} -->
<p class="has-vs-muted-color has-text-color has-small-font-size">Mô tả ngắn cho bước này.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
    };
    register_block_pattern('vinasite/quy-trinh', array(
        'title'       => 'VinaSite – Quy trình các bước',
        'description' => '5 bước làm việc, có số thứ tự. Nhân bản/xoá bước tuỳ ý.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-section"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Quy trình làm việc</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"vsp-steps","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-steps">' . $buoc('1', 'Tiếp nhận thông tin') . '

' . $buoc('2', 'Đánh giá sơ bộ') . '

' . $buoc('3', 'Trao đổi và đề xuất phương án') . '

' . $buoc('4', 'Thống nhất phạm vi và chi phí') . '

' . $buoc('5', 'Triển khai và bàn giao') . '</div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 6. Giới thiệu 2 cột (ảnh + chữ) ---------- */
    register_block_pattern('vinasite/gioi-thieu', array(
        'title'       => 'VinaSite – Giới thiệu 2 cột',
        'description' => 'Ảnh bên trái, nội dung giới thiệu + nút bên phải. Bấm vào ảnh để thay.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-section"><!-- wp:media-text {"mediaType":"image"} -->
<div class="wp-block-media-text is-stacked-on-mobile"><figure class="wp-block-media-text__media"><img src="' . $anh_ngang . '" alt="Ảnh giới thiệu — thay bằng ảnh thật của bạn"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-vs-primary-color has-text-color">Về chúng tôi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"vs-muted"} -->
<p class="has-vs-muted-color has-text-color">Đoạn giới thiệu ngắn về đơn vị: bạn là ai, phục vụ khách hàng nào và điều gì làm bạn khác biệt. Nên kèm thông tin có thể xác minh (giấy phép, địa chỉ, lĩnh vực hoạt động).</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Tìm hiểu thêm</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:media-text --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 7. Đội ngũ ---------- */
    $thanh_vien = '<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"vsp-card vsp-member","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-card vsp-member"><!-- wp:image {"sizeSlug":"large","className":"vsp-member-photo"} -->
<figure class="wp-block-image size-large vsp-member-photo"><img src="' . $anh_doc . '" alt="Ảnh thành viên — thay bằng ảnh thật"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"textAlign":"center","textColor":"vs-primary"} -->
<h3 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Họ và tên</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"vs-muted","fontSize":"small"} -->
<p class="has-text-align-center has-vs-muted-color has-text-color has-small-font-size">Chức danh · Lĩnh vực chuyên môn</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->';
    register_block_pattern('vinasite/doi-ngu', array(
        'title'       => 'VinaSite – Đội ngũ',
        'description' => '3 thẻ thành viên: ảnh, tên, chức danh. Chỉ dùng người thật, ảnh thật.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"vs-bg-light","className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vsp-section has-vs-bg-light-background-color has-background"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Đội ngũ của chúng tôi</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns">' . $thanh_vien . $thanh_vien . $thanh_vien . '</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 8. Đánh giá khách hàng ---------- */
    $danh_gia = '<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"vsp-card vsp-quote","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-card vsp-quote"><!-- wp:paragraph {"textColor":"vs-text"} -->
<p class="has-vs-text-color has-text-color">“Nội dung đánh giá thật của khách hàng — chỉ dùng đánh giá có thật và được phép đăng.”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"vs-muted","fontSize":"small"} -->
<p class="has-vs-muted-color has-text-color has-small-font-size"><strong>Tên khách (viết tắt được)</strong> — loại dịch vụ đã dùng</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->';
    register_block_pattern('vinasite/danh-gia', array(
        'title'       => 'VinaSite – Đánh giá khách hàng',
        'description' => '3 thẻ trích dẫn. Chỉ dùng đánh giá có thật, có thể viết tắt tên khách.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-section"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Khách hàng nói về chúng tôi</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns">' . $danh_gia . $danh_gia . $danh_gia . '</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 9. Bảng giá 3 gói ---------- */
    $goi = function ($ten, $noi_bat = false) {
        $cls = $noi_bat ? 'vsp-card vsp-plan vsp-plan-hot' : 'vsp-card vsp-plan';
        return '<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"' . $cls . '","layout":{"type":"constrained"}} -->
<div class="wp-block-group ' . $cls . '"><!-- wp:heading {"level":3,"textAlign":"center","textColor":"vs-primary"} -->
<h3 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">' . $ten . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"vs-accent-text","className":"vsp-plan-price"} -->
<p class="has-text-align-center vsp-plan-price has-vs-accent-text-color has-text-color"><strong>Liên hệ báo giá</strong></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item --><li>Quyền lợi 1</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Quyền lợi 2</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Quyền lợi 3</li><!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"width":100} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button" href="#lien-he">Nhận báo giá</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->';
    };
    register_block_pattern('vinasite/bang-gia', array(
        'title'       => 'VinaSite – Bảng giá 3 gói',
        'description' => '3 gói dịch vụ, gói giữa nổi bật. Không ghi giá khi chưa có giá thật.',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vsp-section"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color">Gói dịch vụ</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns">' . $goi('Cơ bản') . $goi('Chuyên nghiệp', true) . $goi('Doanh nghiệp') . '</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ));

    /* ---------- 10. Form tư vấn (shortcode dùng lại handler AJAX sẵn có) ---------- */
    register_block_pattern('vinasite/form-tu-van', array(
        'title'       => 'VinaSite – Form tư vấn',
        'description' => 'Thông tin liên hệ bên trái + form gửi yêu cầu bên phải (chống spam, gửi email như form trang chủ).',
        'categories'  => array('vinasite'),
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"vs-bg-soft","className":"vsp-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vsp-section has-vs-bg-soft-background-color has-background"><!-- wp:heading {"textAlign":"center","textColor":"vs-primary"} -->
<h2 class="wp-block-heading has-text-align-center has-vs-primary-color has-text-color" id="lien-he">Gửi yêu cầu tư vấn</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:paragraph {"textColor":"vs-muted"} -->
<p class="has-vs-muted-color has-text-color">Để lại thông tin, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất. Thông tin của bạn được bảo mật.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Điện thoại:</strong> <a href="tel:0000000000">000 000 0000</a><br><strong>Email:</strong> <a href="mailto:email@vidu.com">email@vidu.com</a><br><strong>Địa chỉ:</strong> nhập địa chỉ của bạn</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:shortcode -->
[vinasite_form]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ));
}

/* -------------------------------------------------------------------------
 * Shortcode [vinasite_form] — form tư vấn chèn được vào MỌI trang/bài.
 * Dùng lại đúng handler AJAX sẵn có của theme (inc/dragon/ajax.php: nonce,
 * bẫy bot, chống spam theo IP, gửi mail) — không thêm plugin form nào.
 * ---------------------------------------------------------------------- */
add_shortcode('vinasite_form', 'vinasite_form_shortcode');
function vinasite_form_shortcode()
{
    // Form dùng class .dragon-form (nằm trong dragon-home.css) → nạp khi cần.
    wp_enqueue_style('dragon-home', get_template_directory_uri() . '/assets/dragon/css/dragon-home.css', array('dragon-base'), defined('DRAGON_ASSET_VER') ? DRAGON_ASSET_VER : '1.0.0');

    ob_start();
    ?>
    <form class="dragon-form" id="dragon-consult-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
        <input type="hidden" name="action" value="dragon_consultation"/>
        <?php wp_nonce_field('dragon_consultation', 'dragon_nonce'); ?>
        <!-- Bẫy bot: ẩn với người dùng, bot sẽ điền vào. -->
        <div class="dragon-field--hp" aria-hidden="true">
            <label for="dragon-website">Website</label>
            <input type="text" id="dragon-website" name="dragon_website" tabindex="-1" autocomplete="off"/>
        </div>
        <div class="dragon-form__status" id="dragon-form-status" role="status" aria-live="polite"></div>
        <div class="dragon-form__grid">
            <div class="dragon-field">
                <label for="dragon-name">Họ và tên <span class="req">*</span></label>
                <input type="text" id="dragon-name" name="dragon_name" required autocomplete="name"/>
            </div>
            <div class="dragon-field">
                <label for="dragon-phone">Số điện thoại <span class="req">*</span></label>
                <input type="tel" id="dragon-phone" name="dragon_phone" required autocomplete="tel" pattern="[0-9+\s.\-]{8,15}"/>
            </div>
            <div class="dragon-field dragon-field--full">
                <label for="dragon-email">Email</label>
                <input type="email" id="dragon-email" name="dragon_email" autocomplete="email"/>
            </div>
            <div class="dragon-field dragon-field--full">
                <label for="dragon-message">Nội dung cần tư vấn</label>
                <textarea id="dragon-message" name="dragon_message" rows="4"></textarea>
            </div>
            <div class="dragon-field dragon-field--full">
                <label class="dragon-consent">
                    <input type="checkbox" name="dragon_consent" value="1" required/>
                    <span>Tôi đồng ý cho <?php echo esc_html(dragon_brand()); ?> liên hệ và xử lý thông tin tôi cung cấp. <span class="req">*</span></span>
                </label>
            </div>
            <div class="dragon-field dragon-field--full">
                <button type="submit" class="dragon-btn dragon-btn--primary dragon-btn--block"><?php dragon_the_icon('mail'); ?>Gửi yêu cầu tư vấn</button>
            </div>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
