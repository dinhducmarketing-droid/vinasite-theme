<?php
/**
 * Dragon Law Firm – site footer (child theme override).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$logo_id  = get_theme_mod('custom_logo');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : 'https://vanphongluatsu.com.vn/wp-content/uploads/2025/03/logo-e1741850256338.jpg';
$phone    = dragon_opt('phone');
$hotline  = dragon_opt('hotline');
$show_hl  = dragon_opt('show_hotline') === '1' && $hotline !== '';
$areas    = dragon_practice_areas();
?>
</main>

<footer class="dragon-footer dragon-scope" role="contentinfo">
    <div class="dragon-footer__main">
        <div class="dragon-container">
            <div class="dragon-footer__grid">

                <div class="dragon-footer__brand">
                    <img src="<?php echo esc_url($logo_url); ?>" width="150" height="60" alt="<?php echo esc_attr(dragon_opt('company_name')); ?>" loading="lazy"/>
                    <p class="dragon-footer__slogan">“<?php echo esc_html(dragon_opt('slogan')); ?>”</p>
                    <div class="dragon-footer__meta">
                        <strong><?php echo esc_html(dragon_opt('company_name')); ?></strong><br>
                        Số ĐKKD: <?php echo esc_html(dragon_opt('so_dkkd')); ?><br>
                        MST: <?php echo esc_html(dragon_opt('mst')); ?><br>
                        Nơi cấp: <?php echo esc_html(dragon_opt('noi_cap')); ?>
                    </div>
                </div>

                <div>
                    <h3>Liên hệ</h3>
                    <ul class="dragon-footer__contact">
                        <li><?php dragon_the_icon('map-pin'); ?><span><?php echo esc_html(dragon_opt('address')); ?></span></li>
                        <li><?php dragon_the_icon('phone'); ?><a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php echo esc_html($phone); ?></a></li>
                        <?php if ($show_hl) : ?>
                            <li><?php dragon_the_icon('chat'); ?><span>Tổng đài: <a href="tel:<?php echo esc_attr(dragon_tel('hotline')); ?>"><?php echo esc_html($hotline); ?></a></span></li>
                        <?php endif; ?>
                        <li><?php dragon_the_icon('mail'); ?><a href="mailto:<?php echo esc_attr(dragon_opt('email')); ?>"><?php echo esc_html(dragon_opt('email')); ?></a></li>
                        <li><?php dragon_the_icon('clock'); ?><span><?php echo esc_html(dragon_opt('work_hours')); ?></span></li>
                    </ul>
                </div>

                <div>
                    <h3>Lĩnh vực hành nghề</h3>
                    <ul class="dragon-footer__links">
                        <?php foreach (array_slice($areas, 0, 6) as $a) : ?>
                            <li><a href="<?php echo esc_url($a['url']); ?>"><?php dragon_the_icon('chevron-right'); ?><?php echo esc_html($a['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <h3>Hỗ trợ</h3>
                    <ul class="dragon-footer__links">
                        <li><a href="https://vanphongluatsu.com.vn/ve-chung-toi/"><?php dragon_the_icon('chevron-right'); ?>Giới thiệu</a></li>
                        <li><a href="https://vanphongluatsu.com.vn/doi-ngu-nhan-su/"><?php dragon_the_icon('chevron-right'); ?>Đội ngũ luật sư</a></li>
                        <li><a href="https://vanphongluatsu.com.vn/tin-tuc-su-kien/"><?php dragon_the_icon('chevron-right'); ?>Tin tức</a></li>
                        <li><a href="https://vanphongluatsu.com.vn/dich-vu-luat-su/"><?php dragon_the_icon('chevron-right'); ?>Bài viết pháp lý</a></li>
                        <li><a href="#dragon-consultation"><?php dragon_the_icon('chevron-right'); ?>Liên hệ</a></li>
                        <li><a href="https://vanphongluatsu.com.vn/chinh-sach-bao-mat/"><?php dragon_the_icon('chevron-right'); ?>Chính sách bảo mật</a></li>
                        <li><a href="https://vanphongluatsu.com.vn/dieu-khoan-su-dung/"><?php dragon_the_icon('chevron-right'); ?>Điều khoản sử dụng</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="dragon-footer__bottom">
        <div class="dragon-container dragon-footer__bottom-inner">
            <div>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(dragon_opt('company_name')); ?>. Bảo lưu mọi quyền.</div>
            <div class="dragon-footer__legal">
                <a href="https://vanphongluatsu.com.vn/chinh-sach-bao-mat/">Chính sách bảo mật</a>
                <a href="https://vanphongluatsu.com.vn/dieu-khoan-su-dung/">Điều khoản sử dụng</a>
                <a href="<?php echo esc_url(home_url('/sitemap_index.xml')); ?>">Sitemap</a>
            </div>
            <?php if (dragon_opt('facebook') || dragon_opt('youtube')) : ?>
                <div class="dragon-footer__socials">
                    <?php if (dragon_opt('facebook')) : ?><a href="<?php echo esc_url(dragon_opt('facebook')); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php dragon_the_icon('facebook'); ?></a><?php endif; ?>
                    <?php if (dragon_opt('youtube')) : ?><a href="<?php echo esc_url(dragon_opt('youtube')); ?>" target="_blank" rel="noopener" aria-label="YouTube"><?php dragon_the_icon('youtube'); ?></a><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- Floating desktop CTAs -->
<div class="dragon-floats" aria-hidden="false">
    <a class="dragon-float dragon-float--phone" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện <?php echo esc_attr($phone); ?>"><?php dragon_the_icon('phone'); ?></a>
    <a class="dragon-float dragon-float--zalo" href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?></a>
</div>

<!-- Mobile bottom action bar -->
<nav class="dragon-mobilebar" aria-label="Liên hệ nhanh">
    <a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện"><?php dragon_the_icon('phone'); ?>Gọi điện</a>
    <a href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?>Zalo</a>
    <a href="#dragon-consultation" class="is-primary" aria-label="Đặt lịch tư vấn"><?php dragon_the_icon('calendar'); ?>Đặt lịch</a>
</nav>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
