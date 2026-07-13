<?php
/**
 * Landing page – "Hồ sơ năng lực" (firm capability profile).
 *
 * WordPress auto-uses page-{slug}.php for slug "ho-so-nang-luc", overriding
 * page 1381's content WITHOUT editing it. Rollback = delete this file.
 *
 * Cover + media images adapted from the firm's own capability page (imported
 * into the Media Library, not hotlinked). Contact uses the site config.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$phone   = dragon_opt('phone');
$hotline = dragon_opt('hotline');
$email   = dragon_opt('email');
$address = dragon_opt('address');

$cover_id = 21609; // "HỒ SƠ NĂNG LỰC" branded cover (page 1)
$antv_id  = 21610; // Dragon lawyer on ANTV
$cover_url = wp_get_attachment_url($cover_id);

// Full capability-profile deck (imported from the firm's document, in page order).
$doc_pages = array(21609, 21611, 21612, 21613, 21614, 21615, 21616, 21617, 21618, 21619, 21620, 21621, 21622, 21623, 21624);

$stats = array(
    array('calendar', '10+',  'Năm kinh nghiệm'),
    array('folder',   '100+', 'Vụ việc đã xử lý'),
    array('scale',    '04',   'Lĩnh vực chính'),
    array('map-pin',  '03',   'Văn phòng làm việc'),
);

$strengths = array(
    array('award',  'Kinh nghiệm 10+ năm', 'Bề dày hành nghề, tư vấn và tranh tụng trên nhiều lĩnh vực pháp luật.'),
    array('users',  'Đội ngũ luật sư',     'Luật sư thuộc Đoàn Luật sư, chuyên môn sâu và tận tâm với khách hàng.'),
    array('shield', 'Bảo mật tuyệt đối',   'Thông tin và hồ sơ khách hàng được bảo vệ nghiêm ngặt.'),
    array('heart',  'Pháp lý từ tâm',      'Đặt quyền lợi và niềm tin của khách hàng lên hàng đầu.'),
);

$offices = array(
    array('label' => 'Trụ sở chính – Hà Nội',   'address' => $address, 'main' => true),
    array('label' => 'VP giao dịch – Hà Nội',    'address' => 'Số 22 ngõ 29 phố Trạm, phường Long Biên, TP. Hà Nội.', 'main' => false),
    array('label' => 'Chi nhánh – Hải Phòng',    'address' => 'Phòng 5, tầng 5, Toà nhà Khánh Hội, lô 2/3C đường Lê Hồng Phong, TP. Hải Phòng.', 'main' => false),
);
?>
<article class="dragon-scope vs-profile-page">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Hồ sơ năng lực</span>
            </nav>
            <span class="dragon-eyebrow">Hồ sơ năng lực</span>
            <h1 class="vs-single__title">Hồ sơ năng lực <?php echo esc_html(dragon_brand()); ?></h1>
            <p class="vs-about__lead">Dịch vụ luật sư uy tín tại Hà Nội với phương châm <strong>“Pháp lý từ tâm”</strong> — hơn 10 năm kinh nghiệm tư vấn và tranh tụng trên nhiều lĩnh vực.</p>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="#ho-so"><?php dragon_the_icon('folder'); ?>Xem hồ sơ năng lực</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Stats -->
    <section class="dragon-section vs-about__stats-sec" aria-label="Số liệu năng lực">
        <div class="dragon-container">
            <div class="vs-stats">
                <?php foreach ($stats as $s) : ?>
                    <div class="vs-stat dragon-reveal">
                        <span class="vs-stat__ico"><?php dragon_the_icon($s[0]); ?></span>
                        <span class="vs-stat__num"><?php echo esc_html($s[1]); ?></span>
                        <span class="vs-stat__label"><?php echo esc_html($s[2]); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Profile cover + intro -->
    <section class="dragon-section" id="ho-so" aria-labelledby="vs-profile-title">
        <div class="dragon-container">
            <div class="dragon-about__grid">
                <?php if ($cover_url) : ?>
                    <a class="vs-fullimg vs-profile__cover dragon-reveal" href="<?php echo esc_url($cover_url); ?>" target="_blank" rel="noopener" aria-label="Xem ảnh hồ sơ năng lực đầy đủ">
                        <?php echo wp_get_attachment_image($cover_id, 'large', false, array('alt' => 'Hồ sơ năng lực Công ty Luật TNHH Dragon', 'loading' => 'lazy')); ?>
                        <span class="vs-fullimg__view"><?php dragon_the_icon('help'); ?> Xem ảnh đầy đủ</span>
                    </a>
                <?php endif; ?>
                <div class="dragon-reveal">
                    <span class="dragon-eyebrow">Giới thiệu năng lực</span>
                    <h2 id="vs-profile-title">Năng lực &amp; kinh nghiệm của <?php echo esc_html(dragon_brand()); ?></h2>
                    <p>Hồ sơ năng lực thể hiện quá trình hình thành, lĩnh vực hoạt động và năng lực chuyên môn của Công ty Luật TNHH Dragon — đơn vị pháp lý uy tín tại Hà Nội và trên toàn quốc.</p>
                    <ul class="dragon-about__points">
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('award'); ?></span><div><h3>Hơn 10 năm hành nghề</h3><p>Kinh nghiệm tư vấn và tranh tụng đa lĩnh vực.</p></div></li>
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('users'); ?></span><div><h3>Đội ngũ luật sư Đoàn LS</h3><p>Chuyên môn sâu, hành nghề đúng chuẩn mực.</p></div></li>
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('map-pin'); ?></span><div><h3>03 văn phòng Hà Nội &amp; Hải Phòng</h3><p>Tiếp nhận và hỗ trợ khách hàng thuận tiện.</p></div></li>
                    </ul>
                    <div class="dragon-about__actions">
                        <a class="dragon-btn dragon-btn--primary" href="#ho-so-day-du"><?php dragon_the_icon('folder'); ?>Xem hồ sơ đầy đủ</a>
                        <a class="dragon-btn dragon-btn--outline" href="<?php echo esc_url(home_url('/ve-chung-toi/')); ?>">Về chúng tôi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Full document gallery -->
    <?php if (!empty($doc_pages)) : ?>
    <section class="dragon-section dragon-section--soft" id="ho-so-day-du" aria-labelledby="vs-doc-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Tài liệu đầy đủ</span>
                <h2 id="vs-doc-title">Toàn bộ hồ sơ năng lực</h2>
                <p>Nhấp vào từng trang để xem chi tiết ở kích thước đầy đủ.</p>
            </div>
            <div class="vs-doc-gallery">
                <?php foreach ($doc_pages as $n => $pid) :
                    $full = wp_get_attachment_url($pid);
                    if (!$full) { continue; }
                    ?>
                    <a class="vs-doc-page vs-fullimg dragon-reveal" href="<?php echo esc_url($full); ?>" target="_blank" rel="noopener" aria-label="Xem trang hồ sơ năng lực <?php echo (int) ($n + 1); ?>">
                        <?php echo wp_get_attachment_image($pid, 'medium_large', false, array(
                            'alt'     => 'Hồ sơ năng lực Công ty Luật Dragon – trang ' . ($n + 1),
                            'loading' => 'lazy',
                        )); ?>
                        <span class="vs-fullimg__view"><?php dragon_the_icon('help'); ?> Xem đầy đủ</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Practice areas -->
    <?php $areas = function_exists('dragon_practice_areas') ? dragon_practice_areas() : array(); ?>
    <?php if ($areas) : ?>
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-profile-areas-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Lĩnh vực hoạt động</span>
                <h2 id="vs-profile-areas-title">Phạm vi dịch vụ pháp lý</h2>
                <p>Tư vấn và tranh tụng trên các lĩnh vực pháp luật trọng tâm.</p>
            </div>
            <div class="vs-about__areas">
                <?php foreach ($areas as $a) : ?>
                    <a class="dragon-card vs-about__area dragon-reveal" href="<?php echo esc_url($a['url']); ?>">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($a['icon']); ?></span>
                        <span class="vs-about__area-text">
                            <strong><?php echo esc_html($a['title']); ?></strong>
                            <?php dragon_the_icon('arrow-right'); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Strengths -->
    <section class="dragon-section" aria-labelledby="vs-profile-strength-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Năng lực nổi bật</span>
                <h2 id="vs-profile-strength-title">Vì sao khách hàng tin chọn <?php echo esc_html(dragon_brand()); ?></h2>
            </div>
            <div class="dragon-ach__grid">
                <?php foreach ($strengths as $st) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($st[0]); ?></span>
                        <h3><?php echo esc_html($st[1]); ?></h3>
                        <p><?php echo esc_html($st[2]); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Media / press -->
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-profile-media-title">
        <div class="dragon-container">
            <div class="dragon-about__grid">
                <div class="dragon-reveal">
                    <span class="dragon-eyebrow">Truyền thông</span>
                    <h2 id="vs-profile-media-title">Hiện diện trên truyền thông pháp lý</h2>
                    <p>Luật sư <?php echo esc_html(dragon_brand()); ?> tham gia các chương trình pháp luật trên truyền hình (ANTV), chia sẻ kiến thức và góp phần bảo vệ quyền, lợi ích hợp pháp của người dân và doanh nghiệp.</p>
                    <div class="dragon-about__actions">
                        <a class="dragon-btn dragon-btn--outline" href="<?php echo esc_url(home_url('/video-truyen-hinh/')); ?>">Xem Video / Truyền hình</a>
                    </div>
                </div>
                <div class="vs-fullimg dragon-reveal">
                    <?php echo wp_get_attachment_image($antv_id, 'large', false, array('alt' => 'Luật sư Dragon trên truyền hình ANTV', 'loading' => 'lazy')); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Offices -->
    <section class="dragon-section" id="lien-he" aria-labelledby="vs-profile-office-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Hệ thống văn phòng</span>
                <h2 id="vs-profile-office-title">Địa chỉ liên hệ</h2>
                <p>Ba văn phòng tại Hà Nội và Hải Phòng, sẵn sàng tiếp nhận yêu cầu của khách hàng.</p>
            </div>
            <div class="vs-offices vs-offices--3">
                <?php foreach ($offices as $o) : ?>
                    <article class="dragon-card vs-office dragon-reveal">
                        <h3 class="vs-office__label"><?php dragon_the_icon('map-pin'); ?> <?php echo esc_html($o['label']); ?></h3>
                        <p class="vs-office__addr"><?php echo esc_html($o['address']); ?></p>
                        <?php if (!empty($o['main'])) : ?>
                            <ul class="vs-office__meta">
                                <li><?php dragon_the_icon('phone'); ?> <a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php echo esc_html($phone); ?></a></li>
                                <?php if ($hotline) : ?><li><?php dragon_the_icon('phone'); ?> Tổng đài: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>"><?php echo esc_html($hotline); ?></a></li><?php endif; ?>
                                <li><?php dragon_the_icon('mail'); ?> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Cần tư vấn hoặc nhận hồ sơ năng lực đầy đủ?</h2>
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
