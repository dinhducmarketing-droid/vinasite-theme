<?php
/**
 * Trang chủ VinaSite – khối dịch vụ của VinaSite.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$services = vinasite_home_services();
?>
<section class="vs-section vs-section--soft vs-services" aria-labelledby="vs-services-title">
    <div class="vs-container">

        <div class="vs-section-head vs-reveal">
            <span class="vs-eyebrow">Dịch vụ</span>
            <h2 id="vs-services-title">VinaSite làm gì cho doanh nghiệp của bạn?</h2>
            <p>Từ tên miền, hosting đến thiết kế, nội dung và SEO — trọn gói tại một đầu mối.</p>
        </div>

        <div class="vs-grid vs-grid--3">
            <?php foreach ($services as $s) : ?>
                <article class="vs-card vs-service vs-reveal">
                    <span class="vs-ico-chip"><?php vinasite_the_icon($s['icon']); ?></span>
                    <h3 class="vs-service__title"><?php echo esc_html($s['title']); ?></h3>
                    <p class="vs-service__desc"><?php echo esc_html($s['desc']); ?></p>
                    <a class="vs-service__link" href="#vs-consultation">
                        Tư vấn dịch vụ này<?php vinasite_the_icon('arrow-right'); ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
