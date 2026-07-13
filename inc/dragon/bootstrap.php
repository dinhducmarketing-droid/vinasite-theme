<?php
/**
 * Dragon – bootstrap: load modules and enqueue assets.
 * Included from the child theme functions.php.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

$dragon_dir = get_stylesheet_directory() . '/inc/dragon/';
require_once $dragon_dir . 'config.php';
require_once $dragon_dir . 'data.php';
require_once $dragon_dir . 'icons.php';
require_once $dragon_dir . 'customizer.php';
require_once $dragon_dir . 'ajax.php';
require_once $dragon_dir . 'schema.php';
require_once $dragon_dir . 'design-tokens.php';
require_once get_stylesheet_directory() . '/inc/vinasite-license.php';
require_once get_stylesheet_directory() . '/inc/vinasite-bundled-plugin.php';
require_once get_stylesheet_directory() . '/inc/vinasite-theme-updater.php';

define('DRAGON_ASSET_VER', '1.4.8');

add_action('wp_enqueue_scripts', 'dragon_enqueue_assets', 20);
function dragon_enqueue_assets()
{
    $base = get_stylesheet_directory_uri() . '/assets/dragon/';
    $ver  = DRAGON_ASSET_VER;

    // Site-wide (header + footer overrides are global).
    wp_enqueue_style('dragon-base', $base . 'css/dragon-base.css', array(), $ver);
    wp_enqueue_style('dragon-header', $base . 'css/dragon-header.css', array('dragon-base'), $ver);
    wp_enqueue_style('dragon-footer', $base . 'css/dragon-footer.css', array('dragon-base'), $ver);

    // Home section styles — also used by the landing pages (Về chúng tôi, Đội ngũ
    // nhân sự, Hồ sơ năng lực), which reuse .dragon-about__*, .dragon-ach__*,
    // .dragon-lawyer*, .dragon-ctastrip.
    if (is_front_page() || is_page(array('ve-chung-toi', 'doi-ngu-nhan-su', 'ho-so-nang-luc', 'thanh-tich', 'video-truyen-hinh', 'khach-hang-noi-ve-chung-toi'))) {
        wp_enqueue_style('dragon-home', $base . 'css/dragon-home.css', array('dragon-base'), $ver);
        wp_enqueue_style('dragon-responsive', $base . 'css/dragon-responsive.css', array('dragon-home'), $ver);
    }

    // Behaviour (nav/offcanvas needed site-wide; slider/form guard on presence).
    wp_enqueue_script('dragon-js', $base . 'js/dragon.js', array(), $ver, true);
    wp_localize_script('dragon-js', 'DragonAjax', array(
        'url' => admin_url('admin-ajax.php'),
    ));

    // Preconnect Google Fonts + load font đã chọn trong Customizer (mặc định Be Vietnam Pro).
    $vinasite_font = function_exists('dragon_font_current') ? dragon_font_current() : array('query' => 'Be+Vietnam+Pro:wght@400;600;700');
    wp_enqueue_style('dragon-font', 'https://fonts.googleapis.com/css2?family=' . $vinasite_font['query'] . '&display=swap', array(), null);
}

/** Preconnect hints for the webfont (faster LCP). */
add_action('wp_head', 'dragon_resource_hints', 1);
function dragon_resource_hints()
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/** Defer non-critical scripts (keep jQuery + our own intact) for better INP. */
add_filter('script_loader_tag', 'dragon_defer_scripts', 10, 3);
function dragon_defer_scripts($tag, $handle, $src)
{
    $defer = array('dragon-js');
    if (in_array($handle, $defer, true) && strpos($tag, 'defer') === false) {
        $tag = str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}

/** Noindex internal search results (thin content). */
add_action('wp_head', 'dragon_noindex_search', 1);
function dragon_noindex_search()
{
    if (is_search()) {
        echo '<meta name="robots" content="noindex,follow"/>' . "\n";
    }
}
