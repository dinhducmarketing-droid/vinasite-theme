<?php
/**
 * Trang chủ VinaSite – khối liên hệ + form tư vấn.
 *
 * Dùng lại đúng handler AJAX sẵn có (inc/dragon/ajax.php: nonce, honeypot,
 * chống spam theo IP, gửi mail) và giữ nguyên id form để dragon.js bắt được.
 * Giữ id khối là "dragon-consultation" vì header/footer/nút nổi đều trỏ tới đó.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$services = vinasite_home_services();
$phone    = vinasite_info('phone');
$email    = vinasite_info('email');
$address  = dragon_opt('address');
?>
<section class="dragon-section dragon-section--soft vs-contact" id="dragon-consultation" aria-labelledby="vs-contact-title">
    <div class="dragon-container">
        <div class="vs-contact__grid">

            <div class="vs-contact__intro dragon-reveal">
                <span class="dragon-eyebrow">Liên hệ</span>
                <h2 id="vs-contact-title">Bắt đầu website của bạn hôm nay</h2>
                <p>Để lại thông tin, đội ngũ <?php echo esc_html(vinasite_info('brand')); ?> sẽ gọi lại tư vấn miễn phí và báo giá theo đúng nhu cầu của bạn.</p>

                <ul class="vs-contact__list">
                    <li><?php dragon_the_icon('check'); ?><span>Tư vấn miễn phí, không ràng buộc.</span></li>
                    <li><?php dragon_the_icon('check'); ?><span>Báo giá minh bạch trước khi ký hợp đồng.</span></li>
                    <li><?php dragon_the_icon('check'); ?><span>Bàn giao đúng hẹn, hỗ trợ kỹ thuật lâu dài.</span></li>
                </ul>

                <ul class="vs-contact__info">
                    <li>
                        <span class="dragon-ico-chip"><?php dragon_the_icon('phone'); ?></span>
                        <a href="tel:<?php echo esc_attr(vinasite_info_tel()); ?>"><?php echo esc_html($phone); ?></a>
                    </li>
                    <li>
                        <span class="dragon-ico-chip"><?php dragon_the_icon('mail'); ?></span>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </li>
                    <?php if ($address !== '') : ?>
                        <li>
                            <span class="dragon-ico-chip"><?php dragon_the_icon('map-pin'); ?></span>
                            <span><?php echo esc_html($address); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="dragon-reveal">
                <form class="dragon-form vs-form" id="dragon-consult-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                    <input type="hidden" name="action" value="dragon_consultation"/>
                    <?php wp_nonce_field('dragon_consultation', 'dragon_nonce'); ?>

                    <!-- Bẫy bot: ẩn với người dùng, bot sẽ điền vào. -->
                    <div class="dragon-field--hp" aria-hidden="true">
                        <label for="dragon-website">Website</label>
                        <input type="text" id="dragon-website" name="dragon_website" tabindex="-1" autocomplete="off"/>
                    </div>

                    <div class="dragon-form__status" id="dragon-form-status" role="status" aria-live="polite"></div>

                    <div class="dragon-form__grid">
                        <div class="dragon-field">
                            <label for="dragon-name">Họ và tên <span class="req">*</span></label>
                            <input type="text" id="dragon-name" name="dragon_name" required autocomplete="name"/>
                        </div>
                        <div class="dragon-field">
                            <label for="dragon-phone">Số điện thoại <span class="req">*</span></label>
                            <input type="tel" id="dragon-phone" name="dragon_phone" required autocomplete="tel" pattern="[0-9+\s.\-]{8,15}"/>
                        </div>
                        <div class="dragon-field">
                            <label for="dragon-email">Email</label>
                            <input type="email" id="dragon-email" name="dragon_email" autocomplete="email"/>
                        </div>
                        <div class="dragon-field">
                            <label for="dragon-area">Dịch vụ quan tâm</label>
                            <select id="dragon-area" name="dragon_area">
                                <option value="">— Chọn dịch vụ —</option>
                                <?php foreach ($services as $s) : ?>
                                    <option value="<?php echo esc_attr($s['key']); ?>"><?php echo esc_html($s['title']); ?></option>
                                <?php endforeach; ?>
                                <option value="khac">Dịch vụ khác</option>
                            </select>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <label for="dragon-message">Bạn cần hỗ trợ gì?</label>
                            <textarea id="dragon-message" name="dragon_message" rows="4" placeholder="Mô tả ngắn về lĩnh vực kinh doanh và mong muốn của bạn."></textarea>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <label class="dragon-consent">
                                <input type="checkbox" name="dragon_consent" value="1" required/>
                                <span>Tôi đồng ý cho <?php echo esc_html(vinasite_info('company_name')); ?> liên hệ tư vấn và xử lý thông tin tôi cung cấp. <span class="req">*</span></span>
                            </label>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <button type="submit" class="dragon-btn dragon-btn--primary dragon-btn--block"><?php dragon_the_icon('mail'); ?>Gửi yêu cầu tư vấn</button>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <p class="dragon-form__micro"><?php dragon_the_icon('shield'); ?>Thông tin của bạn được bảo mật và chỉ dùng để liên hệ tư vấn.</p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
