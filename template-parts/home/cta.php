<?php
/**
 * Home – Short CTA strip (mid page).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$phone   = dragon_opt('phone');
$cta_img = dragon_opt('cta_img');
?>
<section class="dragon-ctastrip<?php echo $cta_img ? ' has-bg' : ''; ?>" aria-label="Liên hệ tư vấn">
    <?php if ($cta_img) : ?>
        <div class="dragon-ctastrip__bg" aria-hidden="true">
            <img src="<?php echo esc_url($cta_img); ?>" alt="" width="1536" height="1024" loading="lazy" decoding="async"/>
        </div>
    <?php endif; ?>
    <div class="dragon-container dragon-ctastrip__inner">
        <div>
            <h2>Cần trao đổi trực tiếp với luật sư?</h2>
            <p>Đặt lịch tư vấn hoặc gọi ngay để được tiếp nhận và đánh giá hồ sơ.</p>
        </div>
        <div class="dragon-ctastrip__actions">
            <a class="dragon-btn" href="#dragon-consultation"><?php dragon_the_icon('calendar'); ?>Đặt lịch tư vấn</a>
            <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
        </div>
    </div>
</section>
