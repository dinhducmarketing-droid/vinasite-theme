<?php
/**
 * Home – Consultation request form.
 * Progressive enhancement: posts to admin-ajax (no reload) when JS is on, and
 * degrades to a normal POST to admin-post.php when JS is off. Server handler in
 * inc/dragon/ajax.php validates nonce, honeypot, sanitises and rate-limits.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$areas = dragon_practice_areas();
$phone = dragon_opt('phone');
?>
<section class="dragon-section dragon-consult" id="dragon-consultation" aria-labelledby="dragon-consult-title">
    <div class="dragon-container">
        <div class="dragon-consult__grid">

            <div class="dragon-consult__intro dragon-reveal">
                <span class="dragon-eyebrow">Đăng ký tư vấn</span>
                <h2 id="dragon-consult-title">Gửi yêu cầu cho luật sư</h2>
                <p>Để lại thông tin, luật sư Dragon sẽ liên hệ tiếp nhận và đánh giá hồ sơ trong thời gian sớm nhất.</p>
                <ul class="dragon-consult__list">
                    <li><?php dragon_the_icon('check'); ?><span>Tiếp nhận và phản hồi nhanh chóng.</span></li>
                    <li><?php dragon_the_icon('check'); ?><span>Bảo mật tuyệt đối thông tin và hồ sơ.</span></li>
                    <li><?php dragon_the_icon('check'); ?><span>Tư vấn qua điện thoại, Zalo hoặc trực tiếp.</span></li>
                </ul>
                <a class="dragon-consult__phone" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>">
                    <span class="dragon-ico-chip"><?php dragon_the_icon('phone'); ?></span>
                    <?php echo esc_html($phone); ?>
                </a>
                <?php if (dragon_opt('map_embed')) : ?>
                    <div class="dragon-map">
                        <iframe src="<?php echo esc_url(dragon_opt('map_embed')); ?>" width="600" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ trụ sở Công ty Luật Dragon"></iframe>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dragon-reveal">
                <form class="dragon-form" id="dragon-consult-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="action" value="dragon_consultation"/>
                    <?php wp_nonce_field('dragon_consultation', 'dragon_nonce'); ?>
                    <!-- Honeypot: hidden from users, bots fill it -->
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
                            <label for="dragon-area">Lĩnh vực cần hỗ trợ</label>
                            <select id="dragon-area" name="dragon_area">
                                <option value="">— Chọn lĩnh vực —</option>
                                <?php foreach ($areas as $a) : ?>
                                    <option value="<?php echo esc_attr($a['key']); ?>"><?php echo esc_html($a['title']); ?></option>
                                <?php endforeach; ?>
                                <option value="khac">Chưa rõ / lĩnh vực khác</option>
                            </select>
                        </div>
                        <div class="dragon-field">
                            <label for="dragon-city">Tỉnh / thành phố</label>
                            <input type="text" id="dragon-city" name="dragon_city" autocomplete="address-level1"/>
                        </div>
                        <div class="dragon-field">
                            <label for="dragon-file">Tải hồ sơ (tùy chọn)</label>
                            <input type="file" id="dragon-file" name="dragon_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"/>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <label for="dragon-message">Nội dung vụ việc</label>
                            <textarea id="dragon-message" name="dragon_message" rows="4"></textarea>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <label class="dragon-consent">
                                <input type="checkbox" name="dragon_consent" value="1" required/>
                                <span>Tôi đồng ý cho Công ty Luật Dragon liên hệ và xử lý thông tin theo <a href="https://vanphongluatsu.com.vn/chinh-sach-bao-mat/" target="_blank" rel="noopener">Chính sách bảo mật</a>. <span class="req">*</span></span>
                            </label>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <button type="submit" class="dragon-btn dragon-btn--primary dragon-btn--block"><?php dragon_the_icon('mail'); ?>Gửi yêu cầu cho luật sư</button>
                        </div>
                        <div class="dragon-field dragon-field--full">
                            <p class="dragon-form__micro"><?php dragon_the_icon('shield'); ?>Thông tin của bạn được bảo mật và chỉ sử dụng để tiếp nhận yêu cầu tư vấn.</p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
