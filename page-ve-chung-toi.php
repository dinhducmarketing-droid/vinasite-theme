<?php
/**
 * Landing page – "Về chúng tôi" (Về Công ty Luật TNHH Dragon).
 *
 * WordPress auto-uses page-{slug}.php for the page whose slug is "ve-chung-toi",
 * so this OVERRIDES the legacy WPBakery content of page 7184 WITHOUT editing it
 * (that old content had the wrong company info). Rollback = delete this file.
 *
 * Content adapted from the firm's own About page; contact details use the site's
 * canonical config (dragon_opt) so they stay consistent site-wide.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$company = dragon_opt('company_name');
$phone   = dragon_opt('phone');
$hotline = dragon_opt('hotline');
$email   = dragon_opt('email');
$address = dragon_opt('address');
$about_img = dragon_opt('about_img');

$stats = array(
    array('calendar',  '10+',  'Năm kinh nghiệm pháp lý'),
    array('folder',    '100+', 'Vụ việc đã xử lý thành công'),
    array('map-pin',   '02',   'Văn phòng: Hà Nội & Hải Phòng'),
    array('shield',    '100%', 'Cam kết bảo mật hồ sơ'),
);

$values = array(
    array('award',  'Uy tín',      'Đặt uy tín nghề nghiệp và quyền lợi khách hàng lên hàng đầu trong mọi vụ việc.'),
    array('shield', 'Chất lượng',  'Dịch vụ pháp lý chuyên sâu, phương án rõ ràng, bảo mật thông tin nghiêm ngặt.'),
    array('clock',  'Nhanh chóng', 'Tiếp nhận, đánh giá hồ sơ và phản hồi kịp thời cho từng yêu cầu.'),
);

$expertise = array(
    array('gavel',    'Luật sư hình sự', 'Đội ngũ luật sư giàu kinh nghiệm (trên 15 năm) trong bào chữa và tranh tụng án hình sự.'),
    array('scale',    'Tranh chấp dân sự', 'Chuyên gia giải quyết tranh chấp hợp đồng, tài sản, thừa kế và bồi thường thiệt hại.'),
    array('contract', 'Sở hữu trí tuệ & hợp đồng', 'Tư vấn bảo hộ sở hữu trí tuệ, rà soát và đàm phán hợp đồng.'),
    array('stamp',    'Thủ tục hành chính', 'Hỗ trợ khiếu nại, thủ tục cấp phép và làm việc với cơ quan nhà nước.'),
);

$offices = array(
    array(
        'label'   => 'Trụ sở chính – Hà Nội',
        'address' => $address,
        'phone'   => $phone,
        'email'   => $email,
    ),
    array(
        'label'   => 'Chi nhánh – Hải Phòng',
        'address' => 'Phòng 5, tầng 5, Toà nhà Khánh Hội, TP. Hải Phòng.',
        'phone'   => '',
        'email'   => '',
    ),
);
?>
<article class="dragon-scope vs-about">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Về chúng tôi</span>
            </nav>
            <span class="dragon-eyebrow">Về chúng tôi</span>
            <h1 class="vs-single__title"><?php echo esc_html($company); ?></h1>
            <p class="vs-about__lead">Đơn vị pháp lý uy tín tại Hà Nội và trên toàn quốc. Với phương châm <strong>“Uy tín – Chất lượng – Nhanh chóng”</strong>, chúng tôi cung cấp dịch vụ pháp lý chuyên sâu, mang lại quyền lợi tốt nhất cho khách hàng.</p>
            <div class="vs-about__values-chips">
                <span>Uy tín</span><span>Chất lượng</span><span>Nhanh chóng</span>
            </div>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>"><?php dragon_the_icon('calendar'); ?>Đặt lịch tư vấn</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Stats -->
    <section class="dragon-section vs-about__stats-sec" aria-label="Số liệu nổi bật">
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

    <!-- Intro (image + text) -->
    <section class="dragon-section" id="gioi-thieu" aria-labelledby="vs-about-intro-title">
        <div class="dragon-container">
            <div class="dragon-about__grid">
                <div class="dragon-about__media dragon-reveal">
                    <img src="<?php echo esc_url($about_img); ?>" width="560" height="420" alt="Đội ngũ <?php echo esc_attr($company); ?>" loading="lazy" decoding="async"/>
                    <div class="dragon-about__badge">Luật sư uy tín tại Hà Nội<span>Tư vấn – Tranh tụng – Pháp chế</span></div>
                </div>
                <div class="dragon-reveal">
                    <span class="dragon-eyebrow">Giới thiệu</span>
                    <h2 id="vs-about-intro-title">Hơn 10 năm đồng hành cùng khách hàng</h2>
                    <p>Công ty Luật TNHH Dragon hoạt động như một trong những đơn vị pháp lý uy tín hàng đầu tại Hà Nội và trên toàn quốc, với sứ mệnh hỗ trợ chuyên sâu trong các vấn đề pháp lý đa dạng.</p>
                    <p>Trải qua hơn 10 năm hình thành và phát triển, với trụ sở chính tại Hà Nội và chi nhánh tại Hải Phòng, Luật Dragon đã tiếp nhận và xử lý thành công hàng trăm vụ việc, bảo vệ quyền và lợi ích hợp pháp cho khách hàng.</p>
                    <ul class="dragon-about__points">
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('award'); ?></span><div><h3>Kinh nghiệm dày dặn</h3><p>Đội ngũ luật sư hành nghề lâu năm trên nhiều lĩnh vực.</p></div></li>
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('users'); ?></span><div><h3>Thành viên Đoàn Luật sư</h3><p>Hành nghề đúng chuẩn mực và quy định pháp luật.</p></div></li>
                        <li><span class="dragon-ico-chip"><?php dragon_the_icon('shield'); ?></span><div><h3>Bảo mật tuyệt đối</h3><p>Thông tin và hồ sơ khách hàng được bảo vệ nghiêm ngặt.</p></div></li>
                    </ul>
                    <div class="dragon-about__actions">
                        <a class="dragon-btn dragon-btn--outline" href="<?php echo esc_url(home_url('/doi-ngu-nhan-su/')); ?>">Xem đội ngũ luật sư</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core values -->
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-about-values-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Giá trị cốt lõi</span>
                <h2 id="vs-about-values-title">Nền tảng làm nên Luật Dragon</h2>
                <p>Ba giá trị định hướng mọi hoạt động và cam kết của chúng tôi với khách hàng.</p>
            </div>
            <div class="dragon-ach__grid vs-about__values">
                <?php foreach ($values as $v) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($v[0]); ?></span>
                        <h3><?php echo esc_html($v[1]); ?></h3>
                        <p><?php echo esc_html($v[2]); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Expertise / team -->
    <section class="dragon-section" aria-labelledby="vs-about-team-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Đội ngũ luật sư</span>
                <h2 id="vs-about-team-title">Chuyên môn sâu trên nhiều lĩnh vực</h2>
                <p>Các luật sư và chuyên viên giàu kinh nghiệm, thường xuyên tham gia hội thảo để cập nhật kiến thức pháp luật.</p>
            </div>
            <div class="dragon-ach__grid">
                <?php foreach ($expertise as $e) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($e[0]); ?></span>
                        <h3><?php echo esc_html($e[1]); ?></h3>
                        <p><?php echo esc_html($e[2]); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Practice areas -->
    <?php $areas = function_exists('dragon_practice_areas') ? dragon_practice_areas() : array(); ?>
    <?php if ($areas) : ?>
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-about-areas-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Lĩnh vực hoạt động</span>
                <h2 id="vs-about-areas-title">Dịch vụ pháp lý toàn diện</h2>
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

    <!-- Offices / contact -->
    <section class="dragon-section" id="lien-he" aria-labelledby="vs-about-office-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Văn phòng</span>
                <h2 id="vs-about-office-title">Địa chỉ liên hệ</h2>
                <p>Đến trực tiếp hoặc liên hệ qua điện thoại/email để được luật sư tiếp nhận.</p>
            </div>
            <div class="vs-offices">
                <?php foreach ($offices as $o) : ?>
                    <article class="dragon-card vs-office dragon-reveal">
                        <h3 class="vs-office__label"><?php dragon_the_icon('map-pin'); ?> <?php echo esc_html($o['label']); ?></h3>
                        <p class="vs-office__addr"><?php echo esc_html($o['address']); ?></p>
                        <ul class="vs-office__meta">
                            <?php if ($o['phone']) : ?>
                                <li><?php dragon_the_icon('phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $o['phone'])); ?>"><?php echo esc_html($o['phone']); ?></a></li>
                            <?php endif; ?>
                            <?php if ($hotline) : ?>
                                <li><?php dragon_the_icon('phone'); ?> Tổng đài: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>"><?php echo esc_html($hotline); ?></a></li>
                            <?php endif; ?>
                            <?php if ($o['email']) : ?>
                                <li><?php dragon_the_icon('mail'); ?> <a href="mailto:<?php echo esc_attr($o['email']); ?>"><?php echo esc_html($o['email']); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Cần trao đổi trực tiếp với luật sư?</h2>
                <p>Đặt lịch tư vấn hoặc gọi ngay để được tiếp nhận và đánh giá hồ sơ.</p>
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
