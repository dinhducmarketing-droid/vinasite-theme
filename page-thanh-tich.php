<?php
/**
 * Landing page – "Thành tích" (awards & recognition).
 *
 * WordPress auto-uses page-{slug}.php for slug "thanh-tich", overriding page
 * 21597's content WITHOUT editing it. Rollback = delete this file.
 *
 * Certificate images imported from the firm's own achievements page (Media
 * Library, not hotlinked). Contact/CTA use the site config.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$phone = dragon_opt('phone');

// Certificate/award images, in the source page order.
$certs = array(21625, 21626, 21627, 21628, 21629, 21630, 21631, 21632, 21633, 21634, 21635, 21636, 21637, 21638, 21639, 21640, 21641, 21642, 21643);

$highlights = array(
    array('award', 'Bằng khen',            'Được các cơ quan, tổ chức trao tặng ghi nhận đóng góp.'),
    array('star',  'Giấy chứng nhận',      'Chứng nhận từ Liên đoàn & Đoàn Luật sư về hoạt động nghề nghiệp.'),
    array('shield', 'Bảng vàng vinh danh', 'Vinh danh luật sư vì sự nghiệp phát triển pháp luật.'),
    array('check', 'Ghi nhận chuyên môn',  'Uy tín được khẳng định qua nhiều vụ việc và hoạt động cộng đồng.'),
);
?>
<article class="dragon-scope vs-awards">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Thành tích</span>
            </nav>
            <span class="dragon-eyebrow">Thành tích</span>
            <h1 class="vs-single__title">Thành tích &amp; Giải thưởng</h1>
            <p class="vs-about__lead">Những bằng khen, giấy chứng nhận và ghi nhận là minh chứng cho <strong>uy tín, năng lực và trách nhiệm nghề nghiệp</strong> của Công ty Luật TNHH Dragon.</p>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="#bang-khen"><?php dragon_the_icon('award'); ?>Xem thành tích</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Highlights -->
    <section class="dragon-section" aria-labelledby="vs-awards-hl-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Ghi nhận &amp; vinh danh</span>
                <h2 id="vs-awards-hl-title">Uy tín được khẳng định</h2>
                <p><?php echo esc_html(dragon_brand()); ?> và các luật sư được nhiều cơ quan, tổ chức ghi nhận, khen thưởng.</p>
            </div>
            <div class="dragon-ach__grid">
                <?php foreach ($highlights as $h) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($h[0]); ?></span>
                        <h3><?php echo esc_html($h[1]); ?></h3>
                        <p><?php echo esc_html($h[2]); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Certificate gallery -->
    <?php if (!empty($certs)) : ?>
    <section class="dragon-section dragon-section--soft" id="bang-khen" aria-labelledby="vs-awards-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Bằng khen &amp; chứng nhận</span>
                <h2 id="vs-awards-title">Bộ sưu tập thành tích</h2>
                <p>Nhấp vào từng bằng khen để xem ở kích thước đầy đủ.</p>
            </div>
            <div class="vs-cert-gallery">
                <?php foreach ($certs as $n => $cid) :
                    $full = wp_get_attachment_url($cid);
                    if (!$full) { continue; }
                    ?>
                    <a class="vs-cert dragon-reveal" href="<?php echo esc_url($full); ?>" target="_blank" rel="noopener" aria-label="Xem bằng khen <?php echo (int) ($n + 1); ?>">
                        <?php echo wp_get_attachment_image($cid, 'medium_large', false, array(
                            'alt'     => 'Bằng khen / chứng nhận Công ty Luật Dragon ' . ($n + 1),
                            'loading' => 'lazy',
                        )); ?>
                        <span class="vs-cert__view"><?php dragon_the_icon('help'); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Đồng hành cùng đội ngũ luật sư uy tín</h2>
                <p>Đặt lịch tư vấn hoặc gọi ngay để được luật sư Dragon hỗ trợ nhanh chóng, bảo mật.</p>
            </div>
            <div class="dragon-ctastrip__actions">
                <a class="dragon-btn" href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>"><?php dragon_the_icon('calendar'); ?>Đặt lịch tư vấn</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </section>

</article>
<?php
get_footer();
