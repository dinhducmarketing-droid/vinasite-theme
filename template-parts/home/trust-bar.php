<?php
/**
 * Home – Trust bar (4 qualitative values, no unverified statistics).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$items = array(
    array('users', 'Đội ngũ giàu kinh nghiệm', 'Luật sư và chuyên viên pháp lý nhiều năm hành nghề.'),
    array('folder', 'Tiếp nhận hồ sơ rõ ràng', 'Đánh giá sơ bộ và tư vấn phương án minh bạch.'),
    array('shield', 'Bảo mật thông tin', 'Cam kết bảo mật hồ sơ và dữ liệu khách hàng.'),
    array('process', 'Đồng hành xuyên suốt', 'Theo sát vụ việc đến khi bàn giao kết quả.'),
);
?>
<section class="dragon-trust" aria-label="Giá trị cốt lõi">
    <div class="dragon-container">
        <div class="dragon-trust__grid">
            <?php foreach ($items as $it) : ?>
                <div class="dragon-trust__item dragon-reveal">
                    <span class="dragon-ico-chip"><?php dragon_the_icon($it[0]); ?></span>
                    <div>
                        <p class="dragon-trust__title"><?php echo esc_html($it[1]); ?></p>
                        <p><?php echo esc_html($it[2]); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
