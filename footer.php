<?php
/**
 * VinaSite – site footer. Generic; child theme theo ngành có thể ghi đè.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$logo_url = vinasite_logo_url();
$logo_txt = vinasite_opt('company_name') ? vinasite_opt('company_name') : get_bloginfo('name');
$phone    = vinasite_opt('phone');
$hotline  = vinasite_opt('hotline');
$show_hl  = vinasite_opt('show_hotline') === '1' && $hotline !== '';
$areas    = vinasite_practice_areas();

$vinasite_che_do = vinasite_home_preset();
$vs_moi    = $vinasite_che_do === 'vinasite'; // site cài mới
$la_nganh = apply_filters('vinasite_topbar_compact', false); // child theo ngành ép true để topbar gọn // child theo ngành ép qua filter
?>
</main>

<footer class="vs-footer vs-scope" role="contentinfo">
    <div class="vs-footer__main">
        <div class="vs-container">
            <div class="vs-footer__grid">

                <div class="vs-footer__brand">
                    <?php if ($logo_url) : ?><img src="<?php echo esc_url($logo_url); ?>" width="150" height="60" alt="<?php echo esc_attr($logo_txt); ?>" loading="lazy"/><?php else : ?><span class="vs-logo__text"><?php echo esc_html($logo_txt); ?></span><?php endif; ?>
                    <p class="vs-footer__slogan">“<?php echo esc_html(vinasite_opt('slogan')); ?>”</p>
                    <div class="vs-footer__meta">
                        <strong><?php echo esc_html(vinasite_opt('company_name')); ?></strong><br>
                        <?php if (vinasite_opt('so_dkkd') !== '') : ?>Số ĐKKD: <?php echo esc_html(vinasite_opt('so_dkkd')); ?><br><?php endif; ?>
                        <?php if (vinasite_opt('mst') !== '') : ?>MST: <?php echo esc_html(vinasite_opt('mst')); ?><br><?php endif; ?>
                        <?php if (vinasite_opt('noi_cap') !== '') : ?>Nơi cấp: <?php echo esc_html(vinasite_opt('noi_cap')); ?><?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3>Liên hệ</h3>
                    <?php // Site cài mới: dòng nào chưa nhập thì ẩn, tránh dòng trống / link rỗng. ?>
                    <ul class="vs-footer__contact">
                        <?php $vs_map_main = apply_filters('vinasite_footer_main_map', ''); ?>
                        <?php if (!$vs_moi || vinasite_opt('address') !== '') : ?>
                            <li><?php vinasite_the_icon('map-pin'); ?><span><?php echo esc_html(vinasite_opt('address')); ?><?php if ($vs_map_main) : ?> <a class="vs-footer__map" href="<?php echo esc_url($vs_map_main); ?>" target="_blank" rel="noopener">Chỉ đường ›</a><?php endif; ?></span></li>
                        <?php endif; ?>
                        <?php
                        // Văn phòng/chi nhánh phụ — site có nhiều cơ sở bơm vào qua filter.
                        // Mỗi mục: ['label'=>'VPGD Hà Nội', 'address'=>'...', 'map'=>'https://maps...'].
                        foreach ((array) apply_filters('vinasite_footer_extra_offices', array()) as $vs_vp) :
                            if (empty($vs_vp['address'])) { continue; } ?>
                            <li><?php vinasite_the_icon('map-pin'); ?><span><?php if (!empty($vs_vp['label'])) { echo '<strong>' . esc_html($vs_vp['label']) . ':</strong> '; } echo esc_html($vs_vp['address']); ?><?php if (!empty($vs_vp['map'])) : ?> <a class="vs-footer__map" href="<?php echo esc_url($vs_vp['map']); ?>" target="_blank" rel="noopener">Chỉ đường ›</a><?php endif; ?></span></li>
                        <?php endforeach; ?>
                        <?php if (!$vs_moi || $phone !== '') : ?>
                            <li><?php vinasite_the_icon('phone'); ?><a href="tel:<?php echo esc_attr(vinasite_tel('phone')); ?>"><?php echo esc_html($phone); ?></a></li>
                        <?php endif; ?>
                        <?php if ($show_hl) : ?>
                            <li><?php vinasite_the_icon('chat'); ?><span>Tổng đài: <a href="tel:<?php echo esc_attr(vinasite_tel('hotline')); ?>"><?php echo esc_html($hotline); ?></a></span></li>
                        <?php endif; ?>
                        <?php if (!$vs_moi || vinasite_opt('email') !== '') : ?>
                            <li><?php vinasite_the_icon('mail'); ?><a href="mailto:<?php echo esc_attr(vinasite_opt('email')); ?>"><?php echo esc_html(vinasite_opt('email')); ?></a></li>
                        <?php endif; ?>
                        <?php if (!$vs_moi || vinasite_opt('work_hours') !== '') : ?>
                            <li><?php vinasite_the_icon('clock'); ?><span><?php echo esc_html(vinasite_opt('work_hours')); ?></span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php if ($vs_moi) : ?>
                    <div>
                        <h3>Dịch vụ</h3>
                        <ul class="vs-footer__links">
                            <?php foreach (vinasite_home_services() as $s) : ?>
                                <li><a href="<?php echo esc_url(home_url('/#vs-consultation')); ?>"><?php vinasite_the_icon('chevron-right'); ?><?php echo esc_html($s['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif (!empty($areas)) : ?>
                    <?php // Danh mục do child theme (theo ngành) cung cấp qua filter vinasite_practice_areas.
                          // Tiêu đề cột đặt ở option 'footer_areas_title' (child/site tự đặt). ?>
                    <div>
                        <h3><?php echo esc_html(vinasite_opt('footer_areas_title') !== '' ? vinasite_opt('footer_areas_title') : 'Danh mục'); ?></h3>
                        <ul class="vs-footer__links">
                            <?php foreach (array_slice($areas, 0, 6) as $a) : ?>
                                <li><a href="<?php echo esc_url($a['url']); ?>"><?php vinasite_the_icon('chevron-right'); ?><?php echo esc_html($a['title']); ?></a></li>
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
                        'menu_class'     => 'vs-footer__links',
                        'depth'          => 1,
                        'link_before'    => vinasite_icon('chevron-right'),
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="vs-footer__bottom">
        <div class="vs-container vs-footer__bottom-inner">
            <div>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(vinasite_opt('company_name')); ?>. Bảo lưu mọi quyền.</div>
            <div class="vs-footer__legal">
                <?php // Link chính sách: ưu tiên option site tự nhập, sau đó trang chính sách WP.
                      // Site nào chưa có thì link tự ẩn — không hardcode tên miền nào. ?>
                <?php $privacy = vinasite_opt('privacy_url') !== '' ? vinasite_opt('privacy_url') : get_privacy_policy_url(); ?>
                <?php if ($privacy) : ?><a href="<?php echo esc_url($privacy); ?>">Chính sách bảo mật</a><?php endif; ?>
                <?php if (vinasite_opt('terms_url') !== '') : ?><a href="<?php echo esc_url(vinasite_opt('terms_url')); ?>">Điều khoản sử dụng</a><?php endif; ?>
                <a href="<?php echo esc_url(home_url('/sitemap_index.xml')); ?>">Sitemap</a>
            </div>
            <?php
            // Danh sách mạng xã hội ở chân trang — mỗi mục: ['url','label','icon' (HTML SVG)].
            // Mặc định: Facebook + YouTube từ Customizer (icon đơn sắc). Site có thể bổ sung/
            // thay bằng icon màu qua filter `vinasite_footer_socials` (child theo ngành dùng).
            $vs_socials = array();
            if (vinasite_opt('facebook')) { $vs_socials[] = array('url' => vinasite_opt('facebook'), 'label' => 'Facebook', 'icon' => vinasite_icon('facebook')); }
            if (vinasite_opt('youtube'))  { $vs_socials[] = array('url' => vinasite_opt('youtube'),  'label' => 'YouTube',  'icon' => vinasite_icon('youtube')); }
            $vs_socials = apply_filters('vinasite_footer_socials', $vs_socials);
            ?>
            <?php if (!empty($vs_socials)) : ?>
                <div class="vs-footer__socials">
                    <?php foreach ($vs_socials as $vs_s) : if (empty($vs_s['url'])) { continue; } ?>
                        <a href="<?php echo esc_url($vs_s['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($vs_s['label']); ?>"><?php echo $vs_s['icon']; // phpcs:ignore -- SVG nội tuyến tin cậy ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- Floating desktop CTAs -->
<div class="vs-floats" aria-hidden="false">
    <?php if ($phone !== '') : ?>
        <a class="vs-float vs-float--phone" href="tel:<?php echo esc_attr(vinasite_tel('phone')); ?>" aria-label="Gọi điện <?php echo esc_attr($phone); ?>"><?php vinasite_the_icon('phone'); ?></a>
    <?php endif; ?>
    <?php if (vinasite_opt('zalo') !== '') : ?>
        <a class="vs-float vs-float--zalo" href="https://zalo.me/<?php echo esc_attr(vinasite_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php vinasite_the_icon('zalo'); ?></a>
    <?php endif; ?>
</div>

<!-- Mobile bottom action bar -->
<nav class="vs-mobilebar" aria-label="Liên hệ nhanh">
    <?php // Site cài mới chưa nhập thì ẩn, tránh link "tel:" / "zalo.me/" rỗng. ?>
    <?php if (!$vs_moi || $phone !== '') : ?>
        <a href="tel:<?php echo esc_attr(vinasite_tel('phone')); ?>" aria-label="Gọi điện"><?php vinasite_the_icon('phone'); ?>Gọi điện</a>
    <?php endif; ?>
    <?php if (!$vs_moi || vinasite_opt('zalo') !== '') : ?>
        <a href="https://zalo.me/<?php echo esc_attr(vinasite_tel('zalo')); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo"><?php vinasite_the_icon('zalo'); ?>Zalo</a>
    <?php endif; ?>
    <?php $nhan_cta = $vs_moi ? 'Nhận tư vấn' : 'Đặt lịch tư vấn'; ?>
    <a href="#vs-consultation" class="is-primary" aria-label="<?php echo esc_attr($nhan_cta); ?>"><?php vinasite_the_icon('calendar'); ?><?php echo $vs_moi ? 'Tư vấn' : 'Đặt lịch'; ?></a>
</nav>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
