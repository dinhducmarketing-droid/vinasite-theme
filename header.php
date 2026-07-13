<?php
/**
 * Dragon Law Firm – site header (child theme override).
 * Self-contained, semantic, accessible. Works site-wide; the redesigned
 * homepage sections live in front-page.php.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo esc_attr(function_exists('flatsome_html_classes') ? flatsome_html_classes() : ''); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <?php wp_head(); ?>
    <?php
    // Google Analytics — mã lấy từ Customizer (rỗng = không chèn). Nhiều mã cách nhau dấu phẩy.
    $vinasite_ga = array_filter(array_map('trim', explode(',', (string) dragon_opt('ga_ids'))));
    if (!empty($vinasite_ga)) : ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($vinasite_ga[0]); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        <?php foreach ($vinasite_ga as $vinasite_gid) : ?>gtag('config', '<?php echo esc_js($vinasite_gid); ?>');
        <?php endforeach; ?>
    </script>
    <?php endif; ?>
</head>

<body <?php body_class('dragon-scope'); ?>>
<?php if (function_exists('wp_body_open')) { wp_body_open(); } ?>
<?php do_action('flatsome_after_body_open'); ?>

<a class="dragon-skip-link" href="#main"><?php esc_html_e('Chuyển đến nội dung chính', 'flatsome'); ?></a>

<div id="wrapper">

<?php
$logo_id  = get_theme_mod('custom_logo');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : 'https://vanphongluatsu.com.vn/wp-content/uploads/2025/03/logo-e1741850256338.jpg';
$phone    = dragon_opt('phone');
$areas    = dragon_practice_areas();
?>
<header class="dragon-header" role="banner">

    <!-- Topbar -->
    <div class="dragon-topbar">
        <div class="dragon-container dragon-topbar__inner dragon-topbar__inner--right">
            <ul class="dragon-topbar__list dragon-topbar__list--secondary">
                <li><a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?><span><?php echo esc_html($phone); ?></span></a></li>
                <li><a href="mailto:<?php echo esc_attr(dragon_opt('email')); ?>"><?php dragon_the_icon('mail'); ?><span><?php echo esc_html(dragon_opt('email')); ?></span></a></li>
            </ul>
        </div>
    </div>

    <!-- Main bar -->
    <div class="dragon-bar" id="dragon-bar">
        <div class="dragon-container dragon-bar__inner">
            <a class="dragon-logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img src="<?php echo esc_url($logo_url); ?>" width="180" height="56" alt="<?php echo esc_attr(dragon_opt('company_name')); ?>" fetchpriority="high" decoding="async"/>
            </a>

            <nav class="dragon-nav" aria-label="Menu chính">
                <?php
                // Render the site's WordPress menu assigned to the "Main Menu" (primary)
                // location so the admin manages it as before. Falls back to a minimal
                // list only if no menu is assigned.
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'dragon-menu',
                        'menu_id'        => 'dragon-menu',
                        'depth'          => 0,
                        'fallback_cb'    => false,
                    ));
                } else {
                    echo '<ul class="dragon-menu" id="dragon-menu">'
                        . '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>'
                        . '<li><a href="https://vanphongluatsu.com.vn/dich-vu-luat-su/">Dịch vụ luật sư</a></li>'
                        . '<li><a href="https://vanphongluatsu.com.vn/doi-ngu-nhan-su/">Đội ngũ luật sư</a></li>'
                        . '<li><a href="https://vanphongluatsu.com.vn/tin-tuc-su-kien/">Tin tức</a></li>'
                        . '</ul>';
                }
                ?>
            </nav>

            <div class="dragon-header__actions">
                <a class="dragon-btn dragon-btn--primary" href="#dragon-consultation">
                    <?php dragon_the_icon('calendar'); ?><span class="dragon-header__cta-text">Đặt lịch tư vấn</span>
                </a>
                <button class="dragon-burger" type="button" aria-label="Mở menu" aria-expanded="false" aria-controls="dragon-offcanvas" id="dragon-burger">
                    <?php dragon_the_icon('menu'); ?>
                </button>
            </div>
        </div>
    </div>
    <div class="dragon-header__spacer" id="dragon-header-spacer"></div>
</header>

<!-- Off-canvas mobile -->
<div class="dragon-overlay" id="dragon-overlay" hidden></div>
<aside class="dragon-offcanvas" id="dragon-offcanvas" aria-hidden="true" aria-label="Menu di động">
    <div class="dragon-offcanvas__head">
        <img src="<?php echo esc_url($logo_url); ?>" width="140" height="44" alt="<?php echo esc_attr(dragon_opt('company_name')); ?>"/>
        <button class="dragon-offcanvas__close" type="button" aria-label="Đóng menu" id="dragon-offcanvas-close"><?php dragon_the_icon('close'); ?></button>
    </div>
    <?php
    // Same WordPress menu for the mobile off-canvas (JS adds collapse toggles).
    if (has_nav_menu('primary')) {
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'dragon-offcanvas__nav',
            'depth'          => 0,
            'fallback_cb'    => false,
        ));
    } else {
        echo '<ul class="dragon-offcanvas__nav"><li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li></ul>';
    }
    ?>
    <div class="dragon-offcanvas__actions">
        <a class="dragon-btn dragon-btn--primary dragon-btn--block" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html($phone); ?></a>
        <a class="dragon-btn dragon-btn--block" href="#dragon-consultation" data-dragon-close-menu><?php dragon_the_icon('calendar'); ?>Đặt lịch tư vấn</a>
    </div>
</aside>

<main id="main" class="dragon-scope" role="main">
