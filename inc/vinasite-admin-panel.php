<?php
/**
 * VinaSite – Bảng điều khiển theme (menu admin riêng, kiểu Flatsome).
 *
 * Thêm menu "VinaSite" với: Bảng điều khiển (welcome + checklist), Tùy chọn giao
 * diện (Customizer), Bắt đầu nhanh, Nhật ký. Giúp theme giống một sản phẩm premium.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Đăng ký menu admin. */
add_action('admin_menu', 'vinasite_admin_menu', 5);
function vinasite_admin_menu()
{
    $icon = 'data:image/svg+xml;base64,' . base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#a7aaad"><path d="M4 3h3.2l4.8 12.5L16.8 3H20l-6.5 18h-3L4 3z"/></svg>'
    );
    add_menu_page('VinaSite', 'VinaSite', 'edit_theme_options', 'vinasite', 'vinasite_admin_dashboard', $icon, 2);
    add_submenu_page('vinasite', 'Bảng điều khiển', 'Bảng điều khiển', 'edit_theme_options', 'vinasite', 'vinasite_admin_dashboard');
    add_submenu_page('vinasite', 'Tùy chọn giao diện', 'Tùy chọn giao diện', 'edit_theme_options', 'customize.php');
    add_submenu_page('vinasite', 'Bắt đầu nhanh', 'Bắt đầu nhanh', 'edit_theme_options', 'vinasite-setup', 'vinasite_admin_setup');
    add_submenu_page('vinasite', 'Nhật ký cập nhật', 'Nhật ký cập nhật', 'edit_theme_options', 'vinasite-changelog', 'vinasite_admin_changelog');
    if (function_exists('vinasite_admin_brand_page')) {
        add_submenu_page('vinasite', 'Giới thiệu Vinasite', 'Giới thiệu Vinasite', 'edit_theme_options', 'vinasite-about', 'vinasite_admin_brand_page');
    }
}

/** CSS nội tuyến cho các trang VinaSite. */
function vinasite_admin_styles()
{
    echo '<style>
    .vs-panel{max-width:1000px}
    .vs-panel__hero{background:linear-gradient(120deg,#1c3d5f,#2a5580);color:#fff;border-radius:14px;padding:26px 30px;margin:18px 0 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .vs-panel__hero h1{color:#fff;margin:0 0 6px;font-size:26px}
    .vs-panel__hero p{margin:0;opacity:.85}
    .vs-panel__ver{background:rgba(255,255,255,.16);padding:6px 14px;border-radius:999px;font-weight:600;font-family:monospace}
    .vs-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:14px;margin:18px 0}
    .vs-card{background:#fff;border:1px solid #dcdcde;border-radius:12px;padding:18px}
    .vs-card h3{margin:0 0 6px;font-size:15px}
    .vs-card p{color:#646970;margin:0 0 12px;font-size:13px}
    .vs-check{background:#fff;border:1px solid #dcdcde;border-radius:12px;padding:6px 20px;margin:18px 0}
    .vs-check li{list-style:none;padding:12px 0;border-bottom:1px solid #f0f0f1;display:flex;align-items:center;gap:10px;margin:0}
    .vs-check li:last-child{border-bottom:none}
    .vs-dot{width:22px;height:22px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex:none;font-size:13px}
    .vs-dot--ok{background:#1f7a4d}.vs-dot--no{background:#d8382c}
    .vs-check .vs-act{margin-left:auto}
    .vs-changelog{background:#fff;border:1px solid #dcdcde;border-radius:12px;padding:6px 26px;white-space:pre-wrap;font-size:13px;line-height:1.7}
    </style>';
}

/** Một dòng checklist. */
function vinasite_check_row($ok, $label, $link_label = '', $link = '')
{
    echo '<li><span class="vs-dot ' . ($ok ? 'vs-dot--ok">✓' : 'vs-dot--no">!') . '</span> ' . esc_html($label);
    if (!$ok && $link) {
        echo '<a class="button button-small vs-act" href="' . esc_url($link) . '">' . esc_html($link_label) . '</a>';
    } elseif ($ok) {
        echo '<span class="vs-act" style="color:#1f7a4d;font-size:12px">Đã xong</span>';
    }
    echo '</li>';
}

/** Trang Bảng điều khiển. */
function vinasite_admin_dashboard()
{
    $theme = wp_get_theme();
    vinasite_admin_styles();
    $has_logo  = get_theme_mod('custom_logo') || (function_exists('dragon_opt') && dragon_opt('logo'));
    $has_color = get_theme_mod('dragon_color_primary');
    $has_menu  = has_nav_menu('primary');
    $has_front = get_option('show_on_front') === 'page' && get_option('page_on_front');
    $has_phone = function_exists('dragon_opt') && dragon_opt('phone');
    ?>
    <div class="wrap vs-panel">
        <div class="vs-panel__hero">
            <div>
                <h1>Chào mừng đến với VinaSite</h1>
                <p>Theme đa năng của Vinasite Việt Nam — cấu hình nhanh, tự cập nhật từ xa.</p>
            </div>
            <span class="vs-panel__ver">v<?php echo esc_html($theme->get('Version')); ?></span>
        </div>

        <div class="vs-cards">
            <div class="vs-card">
                <h3>🎨 Tùy chọn giao diện</h3>
                <p>Đổi màu, phông chữ, logo, thông tin liên hệ.</p>
                <a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>">Mở tùy biến</a>
            </div>
            <div class="vs-card">
                <h3>🧭 Menu</h3>
                <p>Quản lý menu đầu trang &amp; chân trang.</p>
                <a class="button" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>">Quản lý menu</a>
            </div>
            <div class="vs-card">
                <h3>🚀 Bắt đầu nhanh</h3>
                <p>Các bước dựng site mới trong 5 phút.</p>
                <a class="button" href="<?php echo esc_url(admin_url('admin.php?page=vinasite-setup')); ?>">Xem hướng dẫn</a>
            </div>
        </div>

        <h2>Tình trạng thiết lập</h2>
        <ul class="vs-check">
            <?php
            vinasite_check_row($has_logo, 'Logo site', 'Thêm logo', admin_url('customize.php?autofocus[section]=title_tagline'));
            vinasite_check_row($has_color, 'Màu thương hiệu', 'Chọn màu', admin_url('customize.php?autofocus[section]=dragon_design'));
            vinasite_check_row($has_menu, 'Menu chính', 'Tạo menu', admin_url('nav-menus.php'));
            vinasite_check_row($has_front, 'Trang chủ tĩnh', 'Đặt trang chủ', admin_url('options-reading.php'));
            vinasite_check_row((bool) $has_phone, 'Thông tin liên hệ (SĐT)', 'Nhập thông tin', admin_url('customize.php?autofocus[section]=dragon_business'));
            ?>
        </ul>
    </div>
    <?php
}

/** Trang Bắt đầu nhanh. */
function vinasite_admin_setup()
{
    vinasite_admin_styles();
    ?>
    <div class="wrap vs-panel">
        <div class="vs-panel__hero"><div><h1>Bắt đầu nhanh</h1><p>Dựng site mới với VinaSite trong vài bước.</p></div></div>
        <ol style="font-size:14px;line-height:2;max-width:720px">
            <li>Vào <b>Tùy biến → VinaSite – Màu sắc &amp; Phông chữ</b>: chọn màu chính, màu nhấn, font.</li>
            <li>Vào <b>Tùy biến → Nhận diện site</b>: tải logo.</li>
            <li>Vào <b>Tùy biến → Dragon – Thông tin &amp; Trang chủ</b>: nhập SĐT, email, địa chỉ, MST, Facebook/YouTube, mã Google Analytics, ảnh các section.</li>
            <li>Vào <b>Cài đặt → Đọc</b>: đặt một Trang tĩnh làm Trang chủ.</li>
            <li>Vào <b>Giao diện → Menu</b>: tạo menu và gán vào vị trí <i>Main Menu</i> + <i>Footer Menu</i>.</li>
            <li>Vào <b>Cài đặt → Cài đặt call button</b>: bật nút gọi (SĐT/Zalo/Email).</li>
            <li>Kết nối Google Indexing (plugin đã cài sẵn) để đẩy bài lên Google nhanh.</li>
        </ol>
    </div>
    <?php
}

/** Trang Nhật ký. */
function vinasite_admin_changelog()
{
    vinasite_admin_styles();
    $file = get_template_directory() . '/CHANGELOG.md';
    $content = file_exists($file) ? file_get_contents($file) : 'Chưa có nhật ký.';
    ?>
    <div class="wrap vs-panel">
        <div class="vs-panel__hero"><div><h1>Nhật ký cập nhật</h1><p>Các thay đổi qua từng phiên bản.</p></div></div>
        <div class="vs-changelog"><?php echo esc_html($content); ?></div>
    </div>
    <?php
}
