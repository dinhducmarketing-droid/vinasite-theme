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

/** Icon menu hiện rõ, đúng kích thước (WP mặc định làm mờ icon ảnh). */
add_action('admin_head', 'vinasite_admin_menu_icon_css');
function vinasite_admin_menu_icon_css()
{
    echo '<style>#toplevel_page_vinasite .wp-menu-image img{opacity:1;width:22px;height:22px;padding-top:6px}#toplevel_page_vinasite:hover .wp-menu-image img,#toplevel_page_vinasite.current .wp-menu-image img{opacity:1}</style>';
}

/** Đăng ký menu admin. */
add_action('admin_menu', 'vinasite_admin_menu', 5);
function vinasite_admin_menu()
{
    // Icon chữ "V" hai màu (xanh + đỏ) theo logo VinaSite — dùng lại từ file branding.
    $icon = function_exists('vinasite_admin_icon')
        ? vinasite_admin_icon()
        : 'dashicons-admin-appearance';
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
    $icon = function_exists('vinasite_admin_icon') ? vinasite_admin_icon() : '';
    echo '<style>
    .vs-panel{max-width:1040px}
    .vs-panel *{box-sizing:border-box}
    /* HERO */
    .vs-hero{position:relative;overflow:hidden;border-radius:18px;padding:34px 38px;margin:20px 0 26px;color:#fff;
        background:radial-gradient(120% 140% at 100% 0,#2f6db0 0,#1c3d5f 45%,#102a4a 100%);
        box-shadow:0 12px 30px -12px rgba(16,42,74,.55)}
    .vs-hero::after{content:"";position:absolute;right:-60px;top:-60px;width:260px;height:260px;border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.14),transparent 70%)}
    .vs-hero__row{position:relative;z-index:1;display:flex;align-items:center;gap:20px;flex-wrap:wrap}
    .vs-hero__logo{width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,.14);
        display:flex;align-items:center;justify-content:center;flex:none;backdrop-filter:blur(2px)}
    .vs-hero__logo img{width:42px;height:42px;object-fit:contain}
    .vs-hero__txt{flex:1;min-width:220px}
    .vs-hero h1{color:#fff;margin:0 0 6px;font-size:27px;font-weight:800;letter-spacing:.2px;line-height:1.2}
    .vs-hero h1 span{color:#ffd54a}
    .vs-hero p{margin:0;opacity:.88;font-size:14px;max-width:560px}
    .vs-hero__ver{align-self:flex-start;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.22);
        padding:6px 15px;border-radius:999px;font-weight:700;font-family:ui-monospace,monospace;font-size:13px;white-space:nowrap}
    /* PROGRESS */
    .vs-prog{position:relative;z-index:1;margin-top:22px}
    .vs-prog__top{display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px;opacity:.95}
    .vs-prog__bar{height:9px;border-radius:999px;background:rgba(255,255,255,.2);overflow:hidden}
    .vs-prog__fill{height:100%;border-radius:999px;background:linear-gradient(90deg,#7be0a5,#ffd54a);transition:width .6s ease}
    /* SECTION TITLE */
    .vs-h2{font-size:16px;font-weight:700;color:#1d2939;margin:26px 0 12px;display:flex;align-items:center;gap:8px}
    .vs-h2::before{content:"";width:4px;height:18px;border-radius:3px;background:linear-gradient(#2f6db0,#d8382c)}
    /* CARDS */
    .vs-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin:14px 0}
    .vs-card{background:#fff;border:1px solid #e4e7ec;border-radius:14px;padding:20px;transition:.18s ease;position:relative}
    .vs-card:hover{transform:translateY(-3px);box-shadow:0 12px 24px -14px rgba(16,42,74,.4);border-color:#c9d6e5}
    .vs-card__ico{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;
        font-size:22px;margin-bottom:12px;background:#eaf1fb}
    .vs-card h3{margin:0 0 6px;font-size:15px;color:#1d2939}
    .vs-card p{color:#667085;margin:0 0 14px;font-size:13px;line-height:1.55}
    .vs-card .button-primary{background:#1e5aa8;border-color:#1e5aa8}
    /* CHECKLIST */
    .vs-check{background:#fff;border:1px solid #e4e7ec;border-radius:14px;padding:4px 22px;margin:12px 0;list-style:none}
    .vs-check li{padding:14px 0;border-bottom:1px solid #f2f4f7;display:flex;align-items:center;gap:12px;margin:0;font-size:14px;color:#344054}
    .vs-check li:last-child{border-bottom:none}
    .vs-dot{width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex:none;font-size:13px;box-shadow:0 2px 5px -1px rgba(0,0,0,.2)}
    .vs-dot--ok{background:linear-gradient(135deg,#22a06b,#1f7a4d)}
    .vs-dot--no{background:linear-gradient(135deg,#e0574b,#d8382c)}
    .vs-check .vs-act{margin-left:auto}
    .vs-check .vs-done{margin-left:auto;color:#1f7a4d;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px}
    /* GRID 2 cột: checklist + trợ giúp */
    .vs-grid2{display:grid;grid-template-columns:1.4fr 1fr;gap:20px;align-items:start}
    @media(max-width:900px){.vs-grid2{grid-template-columns:1fr}}
    .vs-help{background:#f8fafc;border:1px solid #e4e7ec;border-radius:14px;padding:20px 22px}
    .vs-help h3{margin:0 0 10px;font-size:15px;color:#1d2939}
    .vs-help ul{margin:0;padding:0;list-style:none}
    .vs-help li{padding:8px 0;border-bottom:1px dashed #e4e7ec;font-size:13px}
    .vs-help li:last-child{border-bottom:none}
    .vs-help a{text-decoration:none;font-weight:600}
    .vs-changelog{background:#fff;border:1px solid #e4e7ec;border-radius:14px;padding:8px 28px;white-space:pre-wrap;font-size:13px;line-height:1.75;color:#344054}
    .vs-panel .vs-hero__logo--empty{font-size:30px;font-weight:800;color:#fff}
    </style>';
}

/** Ô logo trong hero (ảnh logo VinaSite, fallback chữ V). */
function vinasite_hero_logo()
{
    $icon = function_exists('vinasite_admin_icon') ? vinasite_admin_icon() : '';
    echo '<div class="vs-hero__logo">';
    if ($icon) {
        echo '<img src="' . esc_url($icon) . '" alt="VinaSite">';
    } else {
        echo '<span class="vs-hero__logo--empty">V</span>';
    }
    echo '</div>';
}

/** Một dòng checklist. */
function vinasite_check_row($ok, $label, $link_label = '', $link = '')
{
    echo '<li><span class="vs-dot ' . ($ok ? 'vs-dot--ok">✓' : 'vs-dot--no">!') . '</span> ' . esc_html($label);
    if (!$ok && $link) {
        echo '<a class="button button-small vs-act" href="' . esc_url($link) . '">' . esc_html($link_label) . '</a>';
    } elseif ($ok) {
        echo '<span class="vs-done">✓ Đã xong</span>';
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

    $steps = array($has_logo, $has_color, $has_menu, $has_front, (bool) $has_phone);
    $done  = count(array_filter($steps));
    $total = count($steps);
    $pct   = (int) round($done / $total * 100);
    ?>
    <div class="wrap vs-panel">
        <div class="vs-hero">
            <div class="vs-hero__row">
                <?php vinasite_hero_logo(); ?>
                <div class="vs-hero__txt">
                    <h1>Chào mừng đến với VinaSite<span>.</span></h1>
                    <p>Theme đa năng của VinaSite Việt Nam — cấu hình nhanh, tự cập nhật từ xa. Hoàn tất các bước bên dưới để site sẵn sàng chạy.</p>
                </div>
                <span class="vs-hero__ver">v<?php echo esc_html($theme->get('Version')); ?></span>
            </div>
            <div class="vs-prog">
                <div class="vs-prog__top">
                    <span>Tiến độ thiết lập</span>
                    <strong><?php echo (int) $done; ?>/<?php echo (int) $total; ?> hoàn tất · <?php echo (int) $pct; ?>%</strong>
                </div>
                <div class="vs-prog__bar"><div class="vs-prog__fill" style="width:<?php echo (int) $pct; ?>%"></div></div>
            </div>
        </div>

        <div class="vs-cards">
            <div class="vs-card">
                <div class="vs-card__ico" style="background:#eaf1fb">🎨</div>
                <h3>Tùy chọn giao diện</h3>
                <p>Đổi màu, phông chữ, logo, thông tin liên hệ.</p>
                <a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>">Mở tùy biến</a>
            </div>
            <div class="vs-card">
                <div class="vs-card__ico" style="background:#eafaf1">🧭</div>
                <h3>Menu điều hướng</h3>
                <p>Quản lý menu đầu trang &amp; chân trang.</p>
                <a class="button" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>">Quản lý menu</a>
            </div>
            <div class="vs-card">
                <div class="vs-card__ico" style="background:#fef3ec">🚀</div>
                <h3>Bắt đầu nhanh</h3>
                <p>Các bước dựng site mới trong 5 phút.</p>
                <a class="button" href="<?php echo esc_url(admin_url('admin.php?page=vinasite-setup')); ?>">Xem hướng dẫn</a>
            </div>
        </div>

        <div class="vs-grid2">
            <div>
                <div class="vs-h2">Tình trạng thiết lập</div>
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
            <div>
                <div class="vs-h2">Liên kết nhanh</div>
                <div class="vs-help">
                    <ul>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=vinasite-setup')); ?>">📋 Hướng dẫn dựng site</a></li>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=vinasite-changelog')); ?>">🕓 Nhật ký cập nhật</a></li>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=vinasite-about')); ?>">ℹ️ Giới thiệu VinaSite</a></li>
                        <li><a href="https://vinasite.com.vn/" target="_blank" rel="noopener">🌐 vinasite.com.vn</a></li>
                        <li><a href="tel:0528976666">📞 Hỗ trợ: 052 897 6666</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/** Trang Bắt đầu nhanh. */
function vinasite_admin_setup()
{
    vinasite_admin_styles();
    ?>
    <div class="wrap vs-panel">
        <div class="vs-hero"><div class="vs-hero__row"><?php vinasite_hero_logo(); ?><div class="vs-hero__txt"><h1>Bắt đầu nhanh</h1><p>Dựng site mới với VinaSite trong vài bước.</p></div></div></div>
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
        <div class="vs-hero"><div class="vs-hero__row"><?php vinasite_hero_logo(); ?><div class="vs-hero__txt"><h1>Nhật ký cập nhật</h1><p>Các thay đổi qua từng phiên bản.</p></div></div></div>
        <div class="vs-changelog"><?php echo esc_html($content); ?></div>
    </div>
    <?php
}
