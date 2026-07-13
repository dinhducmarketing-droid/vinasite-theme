<?php
/**
 * Home – Credibility / achievements (qualitative, no unverified figures).
 * Placeholder statistics (30 years, 270,000 businesses, ...) are intentionally
 * NOT rendered until an admin verifies them – per brief.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$items = array(
    array('shield', 'Giấy phép hoạt động hợp pháp', 'Hành nghề theo quy định của pháp luật và Liên đoàn Luật sư.'),
    array('award', 'Hoạt động nghề nghiệp thường xuyên', 'Tham gia hội thảo, tọa đàm và phổ biến pháp luật.'),
    array('users', 'Thành viên Đoàn Luật sư', 'Luật sư thuộc Đoàn Luật sư, hành nghề đúng chuẩn mực.'),
    array('news', 'Hiện diện truyền thông pháp lý', 'Chia sẻ kiến thức trên các kênh thông tin chính thống.'),
);
?>
<section class="dragon-section dragon-section--soft" id="dragon-achievements" aria-labelledby="dragon-ach-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Uy tín & năng lực</span>
            <h2 id="dragon-ach-title">Cơ sở tạo nên niềm tin</h2>
            <p>Những giá trị thực tế thể hiện năng lực và trách nhiệm nghề nghiệp của Luật Dragon.</p>
        </div>
        <div class="dragon-ach__grid">
            <?php foreach ($items as $it) : ?>
                <article class="dragon-card dragon-ach__card dragon-reveal">
                    <span class="dragon-ico-chip"><?php dragon_the_icon($it[0]); ?></span>
                    <h3><?php echo esc_html($it[1]); ?></h3>
                    <p><?php echo esc_html($it[2]); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
