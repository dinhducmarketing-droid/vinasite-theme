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
<section class="dragon-section vs-features" aria-labelledby="vs-features-title">
    <div class="dragon-container">

        <div class="dragon-section-head dragon-reveal">
            <span class="dragon-eyebrow">Giao diện VinaSite</span>
            <h2 id="vs-features-title">Vì sao chọn giao diện này?</h2>
            <p>Được xây dựng để một mã nguồn phục vụ nhiều website khách hàng — mỗi site vẫn có bản sắc riêng.</p>
        </div>

        <div class="vs-grid vs-grid--3">
            <?php foreach ($features as $f) : ?>
                <article class="dragon-card vs-feature dragon-reveal">
                    <span class="dragon-ico-chip"><?php dragon_the_icon($f['icon']); ?></span>
                    <h3 class="vs-feature__title"><?php echo esc_html($f['title']); ?></h3>
                    <p class="vs-feature__desc"><?php echo esc_html($f['desc']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
