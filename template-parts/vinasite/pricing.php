<?php
/**
 * Trang chủ VinaSite – khối gói dịch vụ.
 * Giá cụ thể để trống có chủ đích: mỗi site tự báo giá theo yêu cầu.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$packages = vinasite_home_pricing();
?>
<section class="dragon-section vs-pricing" aria-labelledby="vs-pricing-title">
    <div class="dragon-container">

        <div class="dragon-section-head dragon-reveal">
            <span class="dragon-eyebrow">Gói dịch vụ</span>
            <h2 id="vs-pricing-title">Chọn gói phù hợp với quy mô của bạn</h2>
            <p>Mỗi dự án một bài toán khác nhau — hãy để lại thông tin để VinaSite báo giá đúng nhu cầu.</p>
        </div>

        <div class="vs-grid vs-grid--3 vs-pricing__grid">
            <?php foreach ($packages as $p) : ?>
                <article class="dragon-card vs-plan dragon-reveal<?php echo $p['featured'] ? ' vs-plan--featured' : ''; ?>">
                    <?php if ($p['featured']) : ?>
                        <span class="vs-plan__tag"><?php dragon_the_icon('star'); ?>Phổ biến nhất</span>
                    <?php endif; ?>
                    <h3 class="vs-plan__name"><?php echo esc_html($p['name']); ?></h3>
                    <p class="vs-plan__desc"><?php echo esc_html($p['desc']); ?></p>
                    <p class="vs-plan__price">Báo giá theo yêu cầu</p>
                    <ul class="vs-plan__list">
                        <?php foreach ($p['items'] as $item) : ?>
                            <li><?php dragon_the_icon('check'); ?><span><?php echo esc_html($item); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="dragon-btn <?php echo $p['featured'] ? 'dragon-btn--primary' : 'dragon-btn--outline'; ?> dragon-btn--block" href="#dragon-consultation">
                        Nhận báo giá
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
