<?php
/**
 * Vinasite theme – standalone functions.
 *
 * Built entirely from the original "Dragon" design code (no Flatsome / no
 * commercial-theme dependency). Reuses the same nav-menu location slugs as the
 * previous setup so existing menu assignments keep working after switching.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('DOMAIN')) {
    define('DOMAIN', 'vinasite');
}

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
add_action('after_setup_theme', 'vinasite_setup');
function vinasite_setup()
{
    load_theme_textdomain('vinasite', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo', array('height' => 80, 'width' => 220, 'flex-width' => true, 'flex-height' => true));
    add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets'));
    add_theme_support('responsive-embeds');

    // Same location slugs as before, so menu 454 stays assigned to "Main Menu".
    register_nav_menus(array(
        'primary'        => __('Main Menu', 'vinasite'),
        'primary_mobile' => __('Main Menu - Mobile', 'vinasite'),
        'footer'         => __('Footer Menu', 'vinasite'),
        'footer-1'       => __('Footer Menu 1', 'vinasite'),
        'top_bar_nav'    => __('Top Bar Menu', 'vinasite'),
    ));

    add_image_size('vinasite-card', 640, 400, true);
}

if (!isset($content_width)) {
    $content_width = 1200;
}

/* -------------------------------------------------------------------------
 * Dragon system (config, icons, customizer, ajax, schema, enqueue)
 * ---------------------------------------------------------------------- */
require_once get_template_directory() . '/inc/dragon/bootstrap.php';

/* Legacy page-builder shortcode shim (Flatsome UX Builder + [ntg_page_title]). */
require_once get_template_directory() . '/inc/vinasite-shim.php';

/* Admin white-label branding (menu item + footer). */
if (is_admin()) {
    require_once get_template_directory() . '/inc/vinasite-admin-brand.php';
    require_once get_template_directory() . '/inc/vinasite-admin-panel.php';
}

/* Article / page / archive typography (content areas outside the homepage). */
add_action('wp_enqueue_scripts', 'vinasite_content_styles', 21);
function vinasite_content_styles()
{
    $ver = defined('DRAGON_ASSET_VER') ? DRAGON_ASSET_VER : '1.0.0';
    wp_enqueue_style('dragon-content', get_template_directory_uri() . '/assets/dragon/css/dragon-content.css', array('dragon-base'), $ver);
    wp_enqueue_style('dragon-shim', get_template_directory_uri() . '/assets/dragon/css/dragon-shim.css', array('dragon-base'), $ver);
}

/* Sidebar widget area (used by blog/archive if desired). */
add_action('widgets_init', 'vinasite_widgets');
function vinasite_widgets()
{
    register_sidebar(array(
        'name'          => __('Sidebar', 'vinasite'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section class="vs-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="vs-widget__title">',
        'after_title'   => '</h3>',
    ));
}

/* Excerpt tweaks. */
add_filter('excerpt_length', function () { return 28; });
add_filter('excerpt_more', function () { return '…'; });

/* Reading time helper (minutes). */
function vinasite_reading_time($post_id = null)
{
    $content = get_post_field('post_content', $post_id ?: get_the_ID());
    $words   = str_word_count(wp_strip_all_tags($content));
    return max(1, (int) ceil($words / 200));
}
