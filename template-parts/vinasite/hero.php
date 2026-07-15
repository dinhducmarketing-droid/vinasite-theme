<?php
/**
 * Trang chủ VinaSite – khối Hero.
 * Nền bằng gradient thương hiệu (không dùng ảnh ngoài → không CLS, không LCP ảnh).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$theme = wp_get_theme();
$phone = vinasite_info('phone');
?>
<section class="vs-hero" aria-labelledby="vs-hero-title">
    <div class="vs-hero__deco" aria-hidden="true"></div>
    <div class="dragon-container vs-hero__inner">

        <div class="vs-hero__content">
            <span class="dragon-eyebrow"><?php echo esc_html(vinasite_info('company_name')); ?></span>
            <h1 class="vs-hero__title" id="vs-hero-title">
                Giao diện <strong>VinaSite</strong> — nền tảng website cho doanh nghiệp Việt
            </h1>
            <p class="vs-hero__desc">
                <?php echo esc_html(vinasite_info('slogan')); ?>. Một giao diện WordPress nhẹ, chuẩn SEO,
                tự cập nhật và dùng chung được cho nhiều website — do VinaSite thiết kế và phát triển.
            </p>
            <div class="vs-hero__cta">
                <a class="dragon-btn dragon-btn--primary" href="#dragon-consultation">
                    <?php dragon_the_icon('mail'); ?>Nhận tư vấn miễn phí
                </a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(vinasite_info_tel()); ?>">
                    <?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?>
                </a>
            </div>
            <ul class="vs-hero__points">
                <li><?php dragon_the_icon('check'); ?><span>Hơn 1.000 doanh nghiệp &amp; shop tin dùng</span></li>
                <li><?php dragon_the_icon('check'); ?><span>Bàn giao nhanh, không phụ thuộc page builder</span></li>
                <li><?php dragon_the_icon('check'); ?><span>Hỗ trợ kỹ thuật trọn đời website</span></li>
            </ul>
        </div>

        <aside class="vs-hero__card" aria-label="Thông tin giao diện">
            <div class="vs-hero__card-head">
                <span class="vs-hero__badge"><?php dragon_the_icon('shield'); ?>Đang cài đặt</span>
                <strong><?php echo esc_html($theme->get('Name')); ?></strong>
                <span class="vs-hero__ver">Phiên bản <?php echo esc_html($theme->get('Version')); ?></span>
            </div>
            <ul class="vs-hero__specs">
                <li><span>Tự cập nhật</span><b>Từ GitHub</b></li>
                <li><span>Phông chữ</span><b>6 lựa chọn</b></li>
                <li><span>Màu thương hiệu</span><b>Tuỳ chỉnh</b></li>
                <li><span>Plugin kèm theo</span><b>2 plugin</b></li>
            </ul>
            <p class="vs-hero__note">
                <?php dragon_the_icon('help'); ?>
                Đây là trang chủ mặc định của giao diện. Vào <strong>Giao diện → Tuỳ biến</strong> để nhập thông tin
                doanh nghiệp của bạn, hoặc đổi kiểu trang chủ tại mục <strong>VinaSite – Kiểu trang chủ</strong>.
            </p>
        </aside>

    </div>
</section>
