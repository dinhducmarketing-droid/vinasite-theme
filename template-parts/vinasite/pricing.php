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
<section class="vs-section vs-pricing" aria-labelledby="vs-pricing-title">
    <div class="vs-container">

        <div class="vs-section-head vs-reveal">
            <span class="vs-eyebrow">Gói dịch vụ</span>
            <h2 id="vs-pricing-title">Chọn gói phù hợp với quy mô của bạn</h2>
            <p>Mỗi dự án một bài toán khác nhau — hãy để lại thông tin để VinaSite báo giá đúng nhu cầu.</p>
        </div>

        <div class="vs-grid vs-grid--3 vs-pricing__grid">
            <?php foreach ($packages as $p) : ?>
                <article class="vs-card vs-plan vs-reveal<?php echo $p['featured'] ? ' vs-plan--featured' : ''; ?>">
                    <?php if ($p['featured']) : ?>
                        <span class="vs-plan__tag"><?php vinasite_the_icon('star'); ?>Phổ biến nhất</span>
                    <?php endif; ?>
                    <h3 class="vs-plan__name"><?php echo esc_html($p['name']); ?></h3>
                    <p class="vs-plan__desc"><?php echo esc_html($p['desc']); ?></p>
                    <p class="vs-plan__price">Báo giá theo yêu cầu</p>
                    <ul class="vs-plan__list">
                        <?php foreach ($p['items'] as $item) : ?>
                            <li><?php vinasite_the_icon('check'); ?><span><?php echo esc_html($item); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="vs-btn <?php echo $p['featured'] ? 'vs-btn--primary' : 'vs-btn--outline'; ?> vs-btn--block" href="#vs-consultation">
                        Nhận báo giá
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
