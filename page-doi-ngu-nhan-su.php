<?php
/**
 * Landing page – "Đội ngũ nhân sự" (lawyer team).
 *
 * WordPress auto-uses page-{slug}.php for the page whose slug is
 * "doi-ngu-nhan-su", overriding page 8666's content WITHOUT editing it.
 * Rollback = delete this file.
 *
 * Team content + portraits adapted from the firm's own team page (imported into
 * the Media Library, not hotlinked). Contact/CTA use the site's canonical config.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$phone = dragon_opt('phone');

// Attachment IDs of the portraits imported into the Media Library.
$team = array(
    array(
        'name'  => 'Luật sư Đỗ Thị Thu Hiền',
        'role'  => 'Luật sư tranh tụng',
        'photo' => 21605,
        'tags'  => array('Hình sự', 'Doanh nghiệp', 'Đất đai'),
    ),
    array(
        'name'  => 'Luật sư Nguyễn Thị Kim Anh',
        'role'  => 'Luật sư tư vấn',
        'photo' => 21606,
        'tags'  => array('Doanh nghiệp', 'Tranh chấp đất đai'),
    ),
    array(
        'name'  => 'Luật sư Bùi Thị Mai',
        'role'  => 'Luật sư',
        'photo' => 21607,
        'tags'  => array('Dân sự', 'Kinh doanh thương mại'),
    ),
    array(
        'name'  => 'Luật sư Nguyễn Minh Long',
        'role'  => 'Luật sư',
        'photo' => 21608,
        'tags'  => array('Hình sự', 'Trọng tài thương mại', 'Tranh chấp thương mại'),
    ),
);

$fields = array(
    array('gavel',    'Hình sự'),
    array('scale',    'Dân sự'),
    array('contract', 'Sở hữu trí tuệ'),
    array('stamp',    'Hành chính'),
);
?>
<article class="dragon-scope vs-team">

    <!-- Hero -->
    <header class="vs-single__hero vs-about__hero">
        <div class="dragon-container">
            <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <span aria-hidden="true">›</span>
                <span>Đội ngũ nhân sự</span>
            </nav>
            <span class="dragon-eyebrow">Đội ngũ nhân sự</span>
            <h1 class="vs-single__title">Đội ngũ Luật sư &amp; Chuyên viên pháp lý</h1>
            <p class="vs-about__lead">Công ty Luật TNHH Dragon quy tụ đội ngũ luật sư, chuyên viên giàu kinh nghiệm và uy tín, hoạt động trên nhiều lĩnh vực: <strong>hình sự, dân sự, sở hữu trí tuệ và hành chính</strong>.</p>
            <div class="vs-about__hero-cta">
                <a class="dragon-btn dragon-btn--primary" href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>"><?php dragon_the_icon('calendar'); ?>Đặt lịch tư vấn</a>
                <a class="dragon-btn dragon-btn--ghost" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </header>

    <!-- Team grid -->
    <section class="dragon-section" aria-labelledby="vs-team-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Nhân sự chủ chốt</span>
                <h2 id="vs-team-title">Luật sư trực tiếp phụ trách hồ sơ</h2>
                <p>Mỗi vụ việc được luật sư giàu chuyên môn tiếp nhận, đánh giá và đồng hành đến khi bàn giao kết quả.</p>
            </div>
            <div class="dragon-lawyers__grid">
                <?php foreach ($team as $m) : ?>
                    <article class="dragon-card dragon-lawyer dragon-reveal">
                        <div class="dragon-lawyer__photo">
                            <?php echo wp_get_attachment_image($m['photo'], 'medium_large', false, array(
                                'alt'     => esc_attr($m['name']),
                                'loading' => 'lazy',
                                'class'   => 'vs-lawyer__img',
                            )); ?>
                        </div>
                        <div class="dragon-lawyer__body">
                            <h3 class="dragon-lawyer__name"><?php echo esc_html($m['name']); ?></h3>
                            <div class="dragon-lawyer__role"><?php echo esc_html($m['role']); ?></div>
                            <?php if (!empty($m['tags'])) : ?>
                                <ul class="vs-lawyer__tags">
                                    <?php foreach ($m['tags'] as $t) : ?>
                                        <li><?php echo esc_html($t); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <div class="dragon-lawyer__actions">
                                <a class="dragon-btn dragon-btn--primary" href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>">Đặt lịch tư vấn</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Practice fields band -->
    <section class="dragon-section dragon-section--soft" aria-labelledby="vs-team-fields-title">
        <div class="dragon-container">
            <div class="dragon-section-head">
                <span class="dragon-eyebrow">Lĩnh vực hoạt động</span>
                <h2 id="vs-team-fields-title">Chuyên môn của đội ngũ</h2>
                <p>Tư vấn và tranh tụng trên các lĩnh vực pháp luật trọng tâm.</p>
            </div>
            <div class="dragon-ach__grid">
                <?php foreach ($fields as $f) : ?>
                    <article class="dragon-card dragon-ach__card dragon-reveal vs-field-card">
                        <span class="dragon-ico-chip"><?php dragon_the_icon($f[0]); ?></span>
                        <h3><?php echo esc_html($f[1]); ?></h3>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA strip -->
    <section class="dragon-ctastrip" aria-label="Liên hệ tư vấn">
        <div class="dragon-container dragon-ctastrip__inner">
            <div>
                <h2>Cần luật sư tiếp nhận hồ sơ của bạn?</h2>
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
