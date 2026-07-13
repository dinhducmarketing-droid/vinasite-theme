<?php
/**
 * Home – Case intake & resolution process (5 steps).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$steps = array(
    array('phone', 'Tiếp nhận thông tin', 'Ghi nhận yêu cầu qua điện thoại, Zalo hoặc biểu mẫu.'),
    array('folder', 'Đánh giá sơ bộ', 'Luật sư xem xét hồ sơ và xác định hướng xử lý.'),
    array('contract', 'Đề xuất & báo phí', 'Trình bày phương án và mức phí dịch vụ minh bạch.'),
    array('shield', 'Ký hợp đồng dịch vụ', 'Thống nhất phạm vi công việc và cam kết bảo mật.'),
    array('check', 'Triển khai & bàn giao', 'Thực hiện, cập nhật tiến độ và bàn giao kết quả.'),
);
?>
<section class="dragon-section dragon-section--soft" id="dragon-process" aria-labelledby="dragon-process-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Quy trình làm việc</span>
            <h2 id="dragon-process-title">Quy trình tiếp nhận và giải quyết yêu cầu pháp lý</h2>
            <p>Năm bước rõ ràng, minh bạch từ khi tiếp nhận đến khi bàn giao kết quả.</p>
        </div>
        <ol class="dragon-process__grid">
            <?php foreach ($steps as $i => $st) : ?>
                <li class="dragon-process__step dragon-reveal" style="--i:<?php echo (int) $i; ?>;">
                    <div class="dragon-process__marker">
                        <span class="dragon-process__num"><?php echo (int) ($i + 1); ?></span>
                        <span class="dragon-process__ico"><?php dragon_the_icon($st[0]); ?></span>
                    </div>
                    <h3><?php echo esc_html($st[1]); ?></h3>
                    <p><?php echo esc_html($st[2]); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
