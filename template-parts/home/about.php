<?php
/**
 * Home – About the firm (two columns).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$about_img = dragon_opt('about_img');
$points = array(
    array('award', 'Năng lực chuyên môn', 'Tư vấn và tranh tụng trên nhiều lĩnh vực pháp luật.'),
    array('shield', 'Cam kết bảo mật', 'Thông tin và hồ sơ khách hàng được bảo vệ nghiêm ngặt.'),
    array('process', 'Phương án rõ ràng', 'Đánh giá hồ sơ, đề xuất giải pháp và báo phí minh bạch.'),
    array('users', 'Tinh thần trách nhiệm', 'Đồng hành và cập nhật tiến độ trong suốt quá trình.'),
);
?>
<section class="dragon-section" id="dragon-about" aria-labelledby="dragon-about-title">
    <div class="dragon-container">
        <div class="dragon-about__grid">
            <div class="dragon-about__media dragon-reveal">
                <img src="<?php echo esc_url($about_img); ?>" width="560" height="420" alt="Đội ngũ Công ty Luật TNHH Dragon" loading="lazy" decoding="async"/>
                <div class="dragon-about__badge">Luật sư uy tín tại Hà Nội<span>Tư vấn – Tranh tụng – Pháp chế</span></div>
            </div>
            <div class="dragon-reveal">
                <span class="dragon-eyebrow">Về chúng tôi</span>
                <h2 id="dragon-about-title"><?php echo esc_html(dragon_opt('company_name')); ?></h2>
                <p>Công ty Luật TNHH Dragon cung cấp dịch vụ pháp lý toàn diện cho cá nhân và doanh nghiệp: tư vấn, tranh tụng và pháp chế thường xuyên. Chúng tôi tiếp nhận, đánh giá hồ sơ và xây dựng phương án xử lý phù hợp cho từng vụ việc.</p>
                <ul class="dragon-about__points">
                    <?php foreach ($points as $p) : ?>
                        <li>
                            <span class="dragon-ico-chip"><?php dragon_the_icon($p[0]); ?></span>
                            <div><h3><?php echo esc_html($p[1]); ?></h3><p><?php echo esc_html($p[2]); ?></p></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="dragon-about__actions">
                    <a class="dragon-btn dragon-btn--primary" href="https://vanphongluatsu.com.vn/ve-chung-toi/">Tìm hiểu về Luật Dragon</a>
                    <a class="dragon-btn dragon-btn--outline" href="https://vanphongluatsu.com.vn/doi-ngu-nhan-su/">Xem đội ngũ luật sư</a>
                </div>
            </div>
        </div>
    </div>
</section>
