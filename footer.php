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

$vinasite_che_do = vinasite_home_preset();
$vs_moi    = $vinasite_che_do === 'vinasite'; // site cài mới
$la_dragon = $vinasite_che_do === 'dragon';   // site công ty luật đang chạy
?>
</main>

<footer class="dragon-footer dragon-scope" role="contentinfo">
    <div class="dragon-footer__main">
        <div class="dragon-container">
            <div class="dragon-footer__grid">

                <div class="dragon-footer__brand">
                    <?php if ($logo_url) : ?><img src="<?php echo esc_url($logo_url); ?>" width="150" height="60" alt="<?php echo esc_attr($logo_txt); ?>" loading="lazy"/><?php else : ?><span class="dragon-logo__text"><?php echo esc_html($logo_txt); ?></span><?php endif; ?>
                    <p class="dragon-footer__slogan">“<?php echo esc_html(dragon_opt('slogan')); ?>”</p>
                    <div class="dragon-footer__meta">
                        <strong><?php echo esc_html(dragon_opt('company_name')); ?></strong><br>
                        <?php if (dragon_opt('so_dkkd') !== '') : ?>Số ĐKKD: <?php echo esc_html(dragon_opt('so_dkkd')); ?><br><?php endif; ?>
                        <?php if (dragon_opt('mst') !== '') : ?>MST: <?php echo esc_html(dragon_opt('mst')); ?><br><?php endif; ?>
                        <?php if (dragon_opt('noi_cap') !== '') : ?>Nơi cấp: <?php echo esc_html(dragon_opt('noi_cap')); ?><?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3>Liên hệ</h3>
                    <?php // Site cài mới: dòng nào chưa nhập thì ẩn, tránh dòng trống / link rỗng. ?>
                    <ul class="dragon-footer__contact">
                        <?php if (!$vs_moi || dragon_opt('address') !== '') : ?>
                            <li><?php dragon_the_icon('map-pin'); ?><span><?php echo esc_html(dragon_opt('address')); ?></span></li>
                        <?php endif; ?>
                        <?php if (!$vs_moi || $phone !== '') : ?>
                            <li><?php dragon_the_icon('phone'); ?><a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php echo esc_html($phone); ?></a></li>
                        <?php endif; ?>
                        <?php if ($show_hl) : ?>
                            <li><?php dragon_the_icon('chat'); ?><span>Tổng đài: <a href="tel:<?php echo esc_attr(dragon_tel('hotline')); ?>"><?php echo esc_html($hotline); ?></a></span></li>
                        <?php endif; ?>
                        <?php if (!$vs_moi || dragon_opt('email') !== '') : ?>
                            <li><?php dragon_the_icon('mail'); ?><a href="mailto:<?php echo esc_attr(dragon_opt('email')); ?>"><?php echo esc_html(dragon_opt('email')); ?></a></li>
                        <?php endif; ?>
                        <?php if (!$vs_moi || dragon_opt('work_hours') !== '') : ?>
                            <li><?php dragon_the_icon('clock'); ?><span><?php echo esc_html(dragon_opt('work_hours')); ?></span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php if ($vs_moi) : ?>
                    <div>
                        <h3>Dịch vụ</h3>
                        <ul class="dragon-footer__links">
                            <?php foreach (vinasite_home_services() as $s) : ?>
                                <li><a href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>"><?php dragon_the_icon('chevron-right'); ?><?php echo esc_html($s['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif (!empty($areas)) : ?>
                    <?php // Site di cư đặt dragon_practice_areas_off → $areas rỗng → cột tự ẩn. ?>
                    <div>
                        <h3>Lĩnh vực hành nghề</h3>
                        <ul class="dragon-footer__links">
                            <?php foreach (array_slice($areas, 0, 6) as $a) : ?>
                                <li><a href="<?php echo esc_url($a['url']); ?>"><?php dragon_the_icon('chevron-right'); ?><?php echo esc_html($a['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

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
                    <?php // Site công ty luật: giữ đúng 2 link họ đang chạy. Không chuyển sang
                          // privacy_url/get_privacy_policy_url() vì site này chưa đặt trang chính
                          // sách trong WP → cả 2 link sẽ biến mất. ?>
                    <a href="https://vanphongluatsu.com.vn/chinh-sach-bao-mat/">Chính sách bảo mật</a>
                    <a href="https://vanphongluatsu.com.vn/dieu-khoan-su-dung/">Điều khoản sử dụng</a>
                <?php else : ?>
                    <?php $privacy = dragon_opt('privacy_url') !== '' ? dragon_opt('privacy_url') : get_privacy_policy_url(); ?>
                    <?php if ($privacy) : ?><a href="<?php echo esc_url($privacy); ?>">Chính sách bảo mật</a><?php endif; ?>
                    <?php if (dragon_opt('terms_url') !== '') : ?><a href="<?php echo esc_url(dragon_opt('terms_url')); ?>">Điều khoản sử dụng</a><?php endif; ?>
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

<!-- Floating desktop CTAs -->
<div class="dragon-floats" aria-hidden="false">
    <?php if ($phone !== '') : ?>
        <a class="dragon-float dragon-float--phone" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện <?php echo esc_attr($phone); ?>"><?php dragon_the_icon('phone'); ?></a>
    <?php endif; ?>
    <?php if (dragon_opt('zalo') !== '') : ?>
        <a class="dragon-float dragon-float--zalo" href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?></a>
    <?php endif; ?>
</div>

<!-- Mobile bottom action bar -->
<nav class="dragon-mobilebar" aria-label="Liên hệ nhanh">
    <?php // Site cài mới chưa nhập thì ẩn, tránh link "tel:" / "zalo.me/" rỗng. ?>
    <?php if (!$vs_moi || $phone !== '') : ?>
        <a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>" aria-label="Gọi điện"><?php dragon_the_icon('phone'); ?>Gọi điện</a>
    <?php endif; ?>
    <?php if (!$vs_moi || dragon_opt('zalo') !== '') : ?>
        <a href="https://zalo.me/<?php echo esc_attr(dragon_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php dragon_the_icon('zalo'); ?>Zalo</a>
    <?php endif; ?>
    <?php $nhan_cta = $vs_moi ? 'Nhận tư vấn' : 'Đặt lịch tư vấn'; ?>
    <a href="#dragon-consultation" class="is-primary" aria-label="<?php echo esc_attr($nhan_cta); ?>"><?php dragon_the_icon('calendar'); ?><?php echo $vs_moi ? 'Tư vấn' : 'Đặt lịch'; ?></a>
</nav>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
