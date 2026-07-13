<?php
/**
 * Landing page – "Video / Truyền hình" (TV appearances / interviews).
 *
 * WordPress auto-uses page-{slug}.php for slug "video-truyen-hinh", overriding
 * the page's stored content WITHOUT editing it. Rollback = delete this file.
 *
 * Videos are the firm's real YouTube uploads (facade pattern: a YouTube poster
 * thumbnail + play button; the iframe is injected on click by dragon.js, so the
 * page stays light). IDs collected from the firm's own Video page.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$phone = dragon_opt('phone');

// [YouTube ID, title].
$videos = array(
    array('m1FdYZ18Hn4', 'Luật sư Bùi Thị Mai trả lời phỏng vấn ANTV về hành vi có dấu hiệu lừa đảo của Công ty Hoàng Hà'),
    array('_CxCBmXFzhM', 'Luật sư trả lời phỏng vấn Truyền hình CAND về hành vi quay lén hình ảnh của người khác'),
    array('ycrK0w4rJQc', 'Luật sư trả lời phỏng vấn ANTV về hành vi quảng cáo cá độ phi pháp'),
    array('qhyTjjNJgrE', 'Góp vốn bằng ngôi nhà và giấy chứng nhận quyền sử dụng đất có đảm bảo tính pháp lý'),
    array('p87OQXVQzdE', 'So sánh tội Lừa đảo chiếm đoạt tài sản và tội Lạm dụng tín nhiệm chiếm đoạt tài sản'),
    array('_VCepDEE8-I', 'Luật sư phân tích điểm mới của Nghị định 91/2019 về xử phạt hành chính trong lĩnh vực đất đai'),
    array('ZvgL7tceX78', 'Luật sư Hà Nội tư vấn đòi nợ xấu hiệu quả, tránh vi phạm pháp luật'),
    array('CiQYkG_V_Mg', 'Luật sư Công ty Luật Dragon nói về vụ án cướp tài sản'),
    array('WkLIuONy0BY', 'Luật sư tại Hải Phòng tư vấn thủ tục thăm gặp người thân tại trại tạm giam'),
    array('RVo423DW1Dg', 'Công ty Luật Dragon tại Hải Phòng tư vấn thủ tục nhập Hộ khẩu – Hộ tịch'),
    array('2ssAZJ52VaQ', 'Doanh nghiệp cho vay nặng lãi bao nhiêu thì bị xử lý hình sự?'),
    array('b9GVMm0PKLI', 'Thủ tục ly hôn đơn phương theo Luật Hôn nhân và gia đình'),
    array('jdag8oLzMH8', 'Lễ kỉ niệm 10 năm thành lập Công ty Luật Dragon'),
);

$play_svg = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';
?>
<article class="dragon-scope vs-video-page">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Video / Truyền hình</span>
            </nav>
            <span class="dragon-eyebrow">Video / Truyền hình</span>
            <h1 class="vs-single__title">Luật sư Dragon trên truyền hình</h1>
            <p class="vs-about__lead">Luật sư <?php echo esc_html(dragon_brand()); ?> tham gia phỏng vấn, phân tích pháp luật trên <strong>ANTV, Truyền hình CAND</strong> và nhiều chương trình pháp lý — chia sẻ kiến thức, bảo vệ quyền lợi người dân và doanh nghiệp.</p>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="#video"><?php dragon_the_icon('news'); ?>Xem video</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Video grid -->
    <section class="dragon-section" id="video" aria-labelledby="vs-video-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Thư viện video</span>
                <h2 id="vs-video-title">Phỏng vấn &amp; tư vấn pháp luật trên truyền hình</h2>
                <p>Nhấp vào video để xem trực tiếp ngay trên trang.</p>
            </div>
            <div class="vs-video-grid">
                <?php foreach ($videos as $v) :
                    $yid = $v[0];
                    ?>
                    <article class="vs-video dragon-reveal">
                        <button class="vs-video__frame" type="button" data-yt="<?php echo esc_attr($yid); ?>" aria-label="Phát video: <?php echo esc_attr($v[1]); ?>">
                            <img class="vs-video__thumb" src="https://i.ytimg.com/vi/<?php echo esc_attr($yid); ?>/hqdefault.jpg" alt="<?php echo esc_attr($v[1]); ?>" width="480" height="360" loading="lazy" decoding="async"/>
                            <span class="vs-video__play"><?php echo $play_svg; // phpcs:ignore ?></span>
                        </button>
                        <h3 class="vs-video__title"><?php echo esc_html($v[1]); ?></h3>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Cần luật sư tư vấn vấn đề của bạn?</h2>
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
