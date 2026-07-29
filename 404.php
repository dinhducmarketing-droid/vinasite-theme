<?php
/**
 * 404. header.php opens <main>.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="vs-section vs-404">
    <div class="vs-container" style="text-align:center;max-width:640px;">
        <span class="vs-eyebrow">Lỗi 404</span>
        <h1>Không tìm thấy trang</h1>
        <p style="color:var(--vs-muted);">Trang bạn tìm không tồn tại hoặc đã được di chuyển. Bạn có thể quay về trang chủ hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
        <div style="display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap;margin-top:1.5rem;">
            <a class="vs-btn vs-btn--primary" href="<?php echo esc_url(home_url('/')); ?>"><?php vinasite_the_icon('home'); ?>Về trang chủ</a>
            <a class="vs-btn vs-btn--outline" href="tel:<?php echo esc_attr(vinasite_tel('phone')); ?>"><?php vinasite_the_icon('phone'); ?>Gọi <?php echo esc_html(vinasite_opt('phone')); ?></a>
        </div>
        <div style="margin-top:2rem;"><?php get_search_form(); ?></div>
    </div>
</section>
<?php
get_footer();
