<?php
/**
 * VinaSite – admin white-label branding.
 * Adds a "VinaSite" item at the top of the admin sidebar + a small brand info
 * page, and a footer credit. Admin-only, purely cosmetic.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/* Menu icon: VinaSite "V" mark as an inline SVG data URI (blue + red). */
function vinasite_admin_icon()
{
    $svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>"
        . "<path fill='%233f9bd6' d='M4 5h4l3 9-2 4z'/>"
        . "<path fill='%23e2251b' d='M14 4h3l-4 15-2-5z'/></svg>";
    return 'data:image/svg+xml;base64,' . base64_encode(str_replace(array('%233f9bd6', '%23e2251b'), array('#3f9bd6', '#e2251b'), $svg));
}

/* Trang giới thiệu giờ là sub-mục của menu "VinaSite" (đăng ký trong
   vinasite-admin-panel.php) — KHÔNG tạo menu top-level riêng nữa để tránh trùng. */
function vinasite_admin_brand_page()
{
    $theme = wp_get_theme();
    ?>
    <div class="wrap">
        <div style="max-width:760px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:0;overflow:hidden;margin-top:20px;">
            <div style="background:linear-gradient(120deg,#1e5aa8,#102a4a);color:#fff;padding:28px 32px;">
                <div style="font-size:26px;font-weight:800;letter-spacing:.5px;">VinaSite<span style="color:#ffd54a;">.</span></div>
                <div style="opacity:.85;margin-top:4px;">Trân trọng niềm tin của bạn</div>
            </div>
            <div style="padding:24px 32px;line-height:1.7;color:#334155;">
                <p style="margin:0 0 12px;"><strong>Giao diện:</strong> <?php echo esc_html($theme->get('Name')); ?> — phiên bản <?php echo esc_html($theme->get('Version')); ?></p>
                <p style="margin:0 0 12px;"><strong>Thiết kế &amp; phát triển:</strong> Công ty TNHH VinaSite Việt Nam — chuyên thiết kế website, SEO, quản trị website, hosting/VPS &amp; email doanh nghiệp cho hơn 1.000 doanh nghiệp &amp; shop.</p>
                <p style="margin:0 0 16px;"><strong>Hotline:</strong> 052 897 6666 &nbsp;·&nbsp; <strong>Email:</strong> info@vinasite.com.vn</p>
                <a href="https://vinasite.com.vn/" target="_blank" rel="noopener" class="button button-primary" style="background:#1e5aa8;border-color:#1e5aa8;">Truy cập vinasite.com.vn</a>
            </div>
        </div>
    </div>
    <?php
}

/* Footer credit in the admin. */
add_filter('admin_footer_text', 'vinasite_admin_footer', 99);
function vinasite_admin_footer($text)
{
    return 'Giao diện <strong>VinaSite</strong> · Thiết kế bởi <a href="https://vinasite.com.vn/" target="_blank" rel="noopener">VinaSite Việt Nam</a>';
}
