<?php
/**
 * Trang chủ VinaSite – khối liên hệ + form tư vấn.
 *
 * Dùng lại đúng handler AJAX sẵn có (inc/core/ajax.php: nonce, honeypot,
 * chống spam theo IP, gửi mail) và giữ nguyên id form để vinasite.js bắt được.
 * Giữ id khối là "vs-consultation" vì header/footer/nút nổi đều trỏ tới đó.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$services = vinasite_home_services();
$phone    = vinasite_info('phone');
$email    = vinasite_info('email');
$address  = vinasite_opt('address');
?>
<section class="vs-section vs-section--soft vs-contact" id="vs-consultation" aria-labelledby="vs-contact-title">
    <div class="vs-container">
        <div class="vs-contact__grid">

            <div class="vs-contact__intro vs-reveal">
                <span class="vs-eyebrow">Liên hệ</span>
                <h2 id="vs-contact-title">Bắt đầu website của bạn hôm nay</h2>
                <p>Để lại thông tin, đội ngũ <?php echo esc_html(vinasite_info('brand')); ?> sẽ gọi lại tư vấn miễn phí và báo giá theo đúng nhu cầu của bạn.</p>

                <ul class="vs-contact__list">
                    <li><?php vinasite_the_icon('check'); ?><span>Tư vấn miễn phí, không ràng buộc.</span></li>
                    <li><?php vinasite_the_icon('check'); ?><span>Báo giá minh bạch trước khi ký hợp đồng.</span></li>
                    <li><?php vinasite_the_icon('check'); ?><span>Bàn giao đúng hẹn, hỗ trợ kỹ thuật lâu dài.</span></li>
                </ul>

                <ul class="vs-contact__info">
                    <li>
                        <span class="vs-ico-chip"><?php vinasite_the_icon('phone'); ?></span>
                        <a href="tel:<?php echo esc_attr(vinasite_info_tel()); ?>"><?php echo esc_html($phone); ?></a>
                    </li>
                    <li>
                        <span class="vs-ico-chip"><?php vinasite_the_icon('mail'); ?></span>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </li>
                    <?php if ($address !== '') : ?>
                        <li>
                            <span class="vs-ico-chip"><?php vinasite_the_icon('map-pin'); ?></span>
                            <span><?php echo esc_html($address); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="vs-reveal">
                <form class="vs-form vs-form" id="vs-consult-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                    <input type="hidden" name="action" value="vinasite_consultation"/>
                    <?php wp_nonce_field('vinasite_consultation', 'vinasite_nonce'); ?>

                    <!-- Bẫy bot: ẩn với người dùng, bot sẽ điền vào. -->
                    <div class="vs-field--hp" aria-hidden="true">
                        <label for="vs-website">Website</label>
                        <input type="text" id="vs-website" name="vinasite_website" tabindex="-1" autocomplete="off"/>
                    </div>

                    <div class="vs-form__status" id="vs-form-status" role="status" aria-live="polite"></div>

                    <div class="vs-form__grid">
                        <div class="vs-field">
                            <label for="vs-name">Họ và tên <span class="req">*</span></label>
                            <input type="text" id="vs-name" name="vinasite_name" required autocomplete="name"/>
                        </div>
                        <div class="vs-field">
                            <label for="vs-phone">Số điện thoại <span class="req">*</span></label>
                            <input type="tel" id="vs-phone" name="vinasite_phone" required autocomplete="tel" pattern="[0-9+\s.\-]{8,15}"/>
                        </div>
                        <div class="vs-field">
                            <label for="vs-email">Email</label>
                            <input type="email" id="vs-email" name="vinasite_email" autocomplete="email"/>
                        </div>
                        <div class="vs-field">
                            <label for="vs-area">Dịch vụ quan tâm</label>
                            <select id="vs-area" name="vinasite_area">
                                <option value="">— Chọn dịch vụ —</option>
                                <?php foreach ($services as $s) : ?>
                                    <option value="<?php echo esc_attr($s['key']); ?>"><?php echo esc_html($s['title']); ?></option>
                                <?php endforeach; ?>
                                <option value="khac">Dịch vụ khác</option>
                            </select>
                        </div>
                        <div class="vs-field vs-field--full">
                            <label for="vs-message">Bạn cần hỗ trợ gì?</label>
                            <textarea id="vs-message" name="vinasite_message" rows="4" placeholder="Mô tả ngắn về lĩnh vực kinh doanh và mong muốn của bạn."></textarea>
                        </div>
                        <div class="vs-field vs-field--full">
                            <label class="vs-consent">
                                <input type="checkbox" name="vinasite_consent" value="1" required/>
                                <span>Tôi đồng ý cho <?php echo esc_html(vinasite_info('company_name')); ?> liên hệ tư vấn và xử lý thông tin tôi cung cấp. <span class="req">*</span></span>
                            </label>
                        </div>
                        <div class="vs-field vs-field--full">
                            <button type="submit" class="vs-btn vs-btn--primary vs-btn--block"><?php vinasite_the_icon('mail'); ?>Gửi yêu cầu tư vấn</button>
                        </div>
                        <div class="vs-field vs-field--full">
                            <p class="vs-form__micro"><?php vinasite_the_icon('shield'); ?>Thông tin của bạn được bảo mật và chỉ dùng để liên hệ tư vấn.</p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
