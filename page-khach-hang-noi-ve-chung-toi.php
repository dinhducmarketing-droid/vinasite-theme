<?php
/**
 * Landing page – "Khách hàng nói về chúng tôi" (client testimonials).
 *
 * WordPress auto-uses page-{slug}.php for slug "khach-hang-noi-ve-chung-toi",
 * overriding page 21590's content WITHOUT editing it. Rollback = delete file.
 *
 * Testimonials are the REAL reviews from the firm's own page (only 3 exist; no
 * fake reviews are invented). Trust/social-proof sections are qualitative and
 * point at the verifiable Achievements & TV pages.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$phone = dragon_opt('phone');

// Real client reviews (verbatim, lightly tidied), with client type.
$reviews = array(
    array('Doanh nghiệp', 'Dịch vụ tuyệt vời', 'Dịch vụ tư vấn pháp lý tuyệt vời đến từ Công ty Luật Dragon là sự lựa chọn tốt nhất của chúng tôi.'),
    array('Cá nhân', 'Nhanh chóng, hiệu quả', 'Cảm ơn Công ty Luật Dragon đã giải quyết vụ kiện dân sự của tôi nhanh chóng và hiệu quả. Đội ngũ luật sư am hiểu và tận tâm. Tôi sẽ giới thiệu dịch vụ đến người thân.'),
    array('Cá nhân', 'Chuyên nghiệp và tận tâm', 'Công ty Luật Dragon rất chuyên nghiệp và tận tâm. Luật sư giúp tôi hiểu rõ quy trình và đưa ra giải pháp phù hợp. Tôi rất hài lòng và sẽ tiếp tục sử dụng dịch vụ.'),
);

$trust = array(
    array('heart',  'Tận tâm với khách hàng', 'Lắng nghe, đồng hành và bảo vệ tối đa quyền lợi của khách hàng.'),
    array('shield', 'Bảo mật tuyệt đối',       'Thông tin và hồ sơ khách hàng được giữ kín, an toàn.'),
    array('process','Giải pháp rõ ràng',       'Đánh giá hồ sơ, đề xuất phương án và báo phí minh bạch.'),
    array('clock',  'Phản hồi nhanh chóng',    'Tiếp nhận và xử lý yêu cầu kịp thời cho từng vụ việc.'),
);

$star_svg = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 3 6.9 7.5.6-5.7 4.9 1.8 7.3L12 17.8 5.1 21.7l1.8-7.3L1.2 9.5l7.5-.6z"/></svg>';
?>
<article class="dragon-scope vs-reviews-page">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Khách hàng nói về chúng tôi</span>
            </nav>
            <span class="dragon-eyebrow">Khách hàng nói về chúng tôi</span>
            <h1 class="vs-single__title">Niềm tin từ khách hàng</h1>
            <p class="vs-about__lead">Sự hài lòng của khách hàng cá nhân và doanh nghiệp là <strong>thước đo uy tín</strong> của Công ty Luật TNHH Dragon.</p>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="#danh-gia"><?php dragon_the_icon('chat'); ?>Xem đánh giá</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Testimonials -->
    <section class="dragon-section" id="danh-gia" aria-labelledby="vs-rv-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Đánh giá thực tế</span>
                <h2 id="vs-rv-title">Cảm nhận của khách hàng</h2>
                <p>Những chia sẻ chân thật từ khách hàng đã sử dụng dịch vụ pháp lý của <?php echo esc_html(dragon_brand()); ?>.</p>
            </div>
            <div class="vs-reviews">
                <?php foreach ($reviews as $r) : ?>
                    <figure class="dragon-card vs-review dragon-reveal">
                        <span class="vs-review__mark" aria-hidden="true">”</span>
                        <div class="vs-review__stars" aria-label="5 trên 5 sao">
                            <?php echo str_repeat($star_svg, 5); // phpcs:ignore ?>
                        </div>
                        <h3 class="vs-review__title"><?php echo esc_html($r[1]); ?></h3>
                        <blockquote class="vs-review__text"><?php echo esc_html($r[2]); ?></blockquote>
                        <figcaption class="vs-review__cat"><?php dragon_the_icon('user-tie'); ?> Khách hàng <?php echo esc_html(mb_strtolower($r[0])); ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Why clients trust -->
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-rv-trust-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Vì sao khách hàng tin chọn</span>
                <h2 id="vs-rv-trust-title">Giá trị chúng tôi mang lại</h2>
            </div>
            <div class="dragon-ach__grid">
                <?php foreach ($trust as $t) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($t[0]); ?></span>
                        <h3><?php echo esc_html($t[1]); ?></h3>
                        <p><?php echo esc_html($t[2]); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Social proof -->
    <section class="dragon-section" aria-labelledby="vs-rv-proof-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Được ghi nhận &amp; tin tưởng</span>
                <h2 id="vs-rv-proof-title">Uy tín được khẳng định</h2>
                <p>Không chỉ qua lời nói — uy tín của <?php echo esc_html(dragon_brand()); ?> còn được thể hiện qua thành tích và sự hiện diện trên truyền thông.</p>
            </div>
            <div class="vs-proof">
                <a class="dragon-card vs-proof__item dragon-reveal" href="<?php echo esc_url(home_url('/thanh-tich/')); ?>">
                    <span class="dragon-ico-chip"><?php dragon_the_icon('award'); ?></span>
                    <span class="vs-proof__body">
                        <strong>Thành tích &amp; giải thưởng</strong>
                        <span>Bằng khen, giấy chứng nhận và bảng vàng vinh danh.</span>
                    </span>
                    <?php dragon_the_icon('arrow-right'); ?>
                </a>
                <a class="dragon-card vs-proof__item dragon-reveal" href="<?php echo esc_url(home_url('/video-truyen-hinh/')); ?>">
                    <span class="dragon-ico-chip"><?php dragon_the_icon('news'); ?></span>
                    <span class="vs-proof__body">
                        <strong>Video / Truyền hình</strong>
                        <span>Luật sư Dragon phỏng vấn, phân tích pháp luật trên ANTV.</span>
                    </span>
                    <?php dragon_the_icon('arrow-right'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Trở thành khách hàng tiếp theo hài lòng cùng <?php echo esc_html(dragon_brand()); ?></h2>
                <p>Đặt lịch tư vấn hoặc gọi ngay để được luật sư hỗ trợ nhanh chóng, bảo mật.</p>
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
