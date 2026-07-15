<?php
/**
 * Dragon Law Firm – site footer (child theme override).
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$logo_url = dragon_logo_url();
$logo_txt = dragon_opt('company_name') ? dragon_opt('company_name') : get_bloginfo('name');
$phone    = dragon_opt('phone');
$hotline  = dragon_opt('hotline');
$show_hl  = dragon_opt('show_hotline') === '1' && $hotline !== '';
$areas    = dragon_practice_areas();
$la_dragon = vinasite_home_preset() === 'dragon';
?>
</main>

<footer class="dragon-footer dragon-scope" role="contentinfo">
    <div class="dragon-footer__main">
        <div class="dragon-container">
            <div class="dragon-footer__grid">

                <div class="dragon-footer__brand">
                    <?php if ($logo_url) : ?><img src="<?php echo esc_url($logo_url); ?>" width="150" height="60" alt="<?php echo esc_attr($logo_txt); ?>" loading="lazy"/><?php else : ?><span class="dragon-logo__text"><?php echo esc_html($logo_txt); ?></span><?php endif; ?>
                    <?php if (dragon_opt('slogan') !== '') : ?>
                        <p class="dragon-footer__slogan">“<?php echo esc_html(dragon_opt('slogan')); ?>”</p>
                    <?php endif; ?>
                    <div class="dragon-footer__meta">
                        <strong><?php echo esc_html(dragon_opt('company_name')); ?></strong>
                        <?php // Mã số doanh nghiệp chỉ hiện khi site đã nhập. ?>
                        <?php if (dragon_opt('so_dkkd') !== '') : ?><br>Số ĐKKD: <?php echo esc_html(dragon_opt('so_dkkd')); ?><?php endif; ?>
                        <?php if (dragon_opt('mst') !== '') : ?><br>MST: <?php echo esc_html(dragon_opt('mst')); ?><?php endif; ?>
                        <?php if (dragon_opt('noi_cap') !== '') : ?><br>Nơi cấp: <?php echo esc_html(dragon_opt('noi_cap')); ?><?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3>Liên hệ</h3>
                    <?php // Mỗi dòng chỉ hiện khi site đã nhập — tránh dòng trống / link rỗng. ?>
                    <ul class="dragon-footer__contact">
                        <?php if (dragon_opt('address') !== '') : ?>
                            <li><?php dragon_the_icon('map-pin'); ?><span><?php echo esc_html(dragon_opt('address')); ?></span></li>
                        <?php endif; ?>
                        <?php if ($phone !== '') : ?>
                            <li><?php dragon_the_icon('phone'); ?><a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php echo esc_html($phone); ?></a></li>
                        <?php endif; ?>
                        <?php if ($show_hl) : ?>
                            <li><?php dragon_the_icon('chat'); ?><span>Tổng đài: <a href="tel:<?php echo esc_attr(dragon_tel('hotline')); ?>"><?php echo esc_html($hotline); ?></a></span></li>
                        <?php endif; ?>
                        <?php if (dragon_opt('email') !== '') : ?>
                            <li><?php dragon_the_icon('mail'); ?><a href="mailto:<?php echo esc_attr(dragon_opt('email')); ?>"><?php echo esc_html(dragon_opt('email')); ?></a></li>
                        <?php endif; ?>
                        <?php if (dragon_opt('work_hours') !== '') : ?>
                            <li><?php dragon_the_icon('clock'); ?><span><?php echo esc_html(dragon_opt('work_hours')); ?></span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div>
                    <?php if ($la_dragon) : ?>
                        <h3>Lĩnh vực hành nghề</h3>
                        <ul class="dragon-footer__links">
                            <?php foreach (array_slice($areas, 0, 6) as $a) : ?>
                                <li><a href="<?php echo esc_url($a['url']); ?>"><?php dragon_the_icon('chevron-right'); ?><?php echo esc_html($a['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <h3>Dịch vụ</h3>
                        <ul class="dragon-footer__links">
                            <?php foreach (vinasite_home_services() as $s) : ?>
                                <li><a href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>"><?php dragon_the_icon('chevron-right'); ?><?php echo esc_html($s['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div>
                    <h3>Hỗ trợ</h3>
                    <?php
                    // Menu chân trang do admin quản lý (Giao diện → Menu → vị trí "Footer Menu").
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'dragon-footer__links',
                        'depth'          => 1,
                        'link_before'    => dragon_icon('chevron-right'),
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="dragon-footer__bottom">
        <div class="dragon-container dragon-footer__bottom-inner">
            <div>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(dragon_opt('company_name')); ?>. Bảo lưu mọi quyền.</div>
            <div class="dragon-footer__legal">
                <?php if ($la_dragon) : ?>
                    <a href="https://vanphongluatsu.com.vn/chinh-sach-bao-mat/">Chính sách bảo mật</a>
                    <a href="https://vanphongluatsu.com.vn/dieu-khoan-su-dung/">Điều khoản sử dụng</a>
                <?php else : ?>
                    <?php // Trang chính sách là của TỪNG site — quản lý ở Giao diện → Menu → "Footer Menu". ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                <?php endif; ?>
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

<?php
// Nút nổi & thanh hành động mobile — chỉ hiện nút nào site đã có dữ liệu,
// tránh link "tel:" / "zalo.me/" rỗng trên site mới cài chưa cấu hình.
$co_phone = dragon_tel('phone') !== '';
$co_zalo  = dragon_tel('zalo') !== '';
?>
<?php if ($co_phone || $co_zalo) : ?>
<!-- Floating desktop CTAs -->
<div class="dragon-floats" aria-hidden="false">
    <?php if ($co_phone) : ?>
        <a class="dragon-float dragon-float--phone" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện <?php echo esc_attr($phone); ?>"><?php dragon_the_icon('phone'); ?></a>
    <?php endif; ?>
    <?php if ($co_zalo) : ?>
        <a class="dragon-float dragon-float--zalo" href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?></a>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Mobile bottom action bar -->
<nav class="dragon-mobilebar" aria-label="Liên hệ nhanh">
    <?php if ($co_phone) : ?>
        <a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện"><?php dragon_the_icon('phone'); ?>Gọi điện</a>
    <?php endif; ?>
    <?php if ($co_zalo) : ?>
        <a href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?>Zalo</a>
    <?php endif; ?>
    <?php // aria-label phải khớp chữ hiện trên nút để trình đọc màn hình không đọc lệch. ?>
    <?php $nhan_cta = vinasite_home_preset() === 'dragon' ? 'Đặt lịch tư vấn' : 'Nhận tư vấn'; ?>
    <a href="#dragon-consultation" class="is-primary" aria-label="<?php echo esc_attr($nhan_cta); ?>"><?php dragon_the_icon('calendar'); ?><?php echo vinasite_home_preset() === 'dragon' ? 'Đặt lịch' : 'Tư vấn'; ?></a>
</nav>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
