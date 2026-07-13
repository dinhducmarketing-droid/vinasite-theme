<?php
/**
 * Home – "Bạn đang gặp vấn đề gì?" need selector.
 * Buttons scroll to the consultation form and pre-select the practice field.
 * No auto-submit, no popup on load.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$problems = array(
    array('gavel', 'Tôi hoặc người thân đang liên quan vụ án hình sự', 'hinh-su'),
    array('home', 'Tôi đang có tranh chấp đất đai', 'dat-dai'),
    array('heart', 'Tôi cần giải quyết ly hôn hoặc quyền nuôi con', 'hon-nhan'),
    array('building', 'Doanh nghiệp đang có tranh chấp cổ đông', 'doanh-nghiep'),
    array('contract', 'Tôi cần rà soát hoặc soạn thảo hợp đồng', 'hop-dong'),
    array('user-tie', 'Tôi cần luật sư đại diện làm việc', 'dan-su'),
    array('stamp', 'Tôi cần khiếu nại hoặc kiện quyết định hành chính', 'hanh-chinh'),
    array('briefcase', 'Tôi cần giải quyết tranh chấp bằng trọng tài thương mại', 'trong-tai'),
    array('help', 'Tôi chưa biết nên chọn dịch vụ nào', ''),
);
?>
<section class="dragon-section" id="dragon-problems" aria-labelledby="dragon-problems-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Định hướng nhanh</span>
            <h2 id="dragon-problems-title">Bạn đang gặp vấn đề gì?</h2>
            <p>Chọn tình huống gần nhất với bạn, chúng tôi sẽ kết nối tới đúng luật sư phụ trách.</p>
        </div>
        <div class="dragon-problems__grid">
            <?php foreach ($problems as $p) : ?>
                <button class="dragon-problem dragon-reveal" type="button" data-dragon-problem="<?php echo esc_attr($p[2]); ?>">
                    <span class="dragon-ico-chip"><?php dragon_the_icon($p[0]); ?></span>
                    <span><?php echo esc_html($p[1]); ?></span>
                    <span class="dragon-ico-arrow"><?php dragon_the_icon('arrow-right'); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
