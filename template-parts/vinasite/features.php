<?php
/**
 * Trang chủ VinaSite – khối giới thiệu tính năng của theme.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$features = vinasite_home_features();
?>
<section class="vs-section vs-features" aria-labelledby="vs-features-title">
    <div class="vs-container">

        <div class="vs-section-head vs-reveal">
            <span class="vs-eyebrow">Giao diện VinaSite</span>
            <h2 id="vs-features-title">Vì sao chọn giao diện này?</h2>
            <p>Được xây dựng để một mã nguồn phục vụ nhiều website khách hàng — mỗi site vẫn có bản sắc riêng.</p>
        </div>

        <div class="vs-grid vs-grid--3">
            <?php foreach ($features as $f) : ?>
                <article class="vs-card vs-feature vs-reveal">
                    <span class="vs-ico-chip"><?php vinasite_the_icon($f['icon']); ?></span>
                    <h3 class="vs-feature__title"><?php echo esc_html($f['title']); ?></h3>
                    <p class="vs-feature__desc"><?php echo esc_html($f['desc']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
