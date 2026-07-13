<?php
/**
 * VinaSite – Tự cài & kích hoạt plugin đóng gói kèm theme.
 *
 * Plugin kèm: "Vinasite Google Indexing" (đẩy URL lên Google Indexing API).
 * File zip nằm ở inc/bundled/. Khi kích hoạt theme lần đầu → tự giải nén vào
 * wp-content/plugins/ và kích hoạt. Nếu chưa bật, admin thấy nhắc + nút bật nhanh.
 *
 * Nâng cấp sau: muốn bundle thêm plugin → thêm zip vào inc/bundled/ và mở rộng
 * mảng slug bên dưới.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/** Danh sách plugin đóng gói kèm theme (slug = tên thư mục = tên file zip). */
function vinasite_bundled_plugins()
{
    return apply_filters('vinasite_bundled_plugins', array('vinasite-google-indexing'));
}

/** File chính của 1 plugin (dạng slug/slug.php) để activate. */
function vinasite_bundled_plugin_file($slug)
{
    return $slug . '/' . $slug . '.php';
}

/** Giải nén plugin đóng gói vào thư mục plugins nếu chưa có. Trả về true nếu đã/đang có. */
function vinasite_install_bundled_plugin($slug)
{
    if (is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
        return true; // đã cài
    }
    $zip = get_template_directory() . '/inc/bundled/' . $slug . '.zip';
    if (!file_exists($zip)) {
        return false;
    }
    require_once ABSPATH . 'wp-admin/includes/file.php';
    WP_Filesystem();
    $res = unzip_file($zip, WP_PLUGIN_DIR);
    return !is_wp_error($res);
}

/** Kích hoạt plugin nếu đã cài & chưa active. */
function vinasite_activate_bundled_plugin($slug)
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $file = vinasite_bundled_plugin_file($slug);
    if (file_exists(WP_PLUGIN_DIR . '/' . $file) && !is_plugin_active($file)) {
        activate_plugin($file);
    }
}

/** Khi KÍCH HOẠT THEME → tự cài + bật các plugin đóng gói. */
add_action('after_switch_theme', 'vinasite_bundled_on_theme_activate');
function vinasite_bundled_on_theme_activate()
{
    if (!current_user_can('install_plugins')) {
        return;
    }
    foreach (vinasite_bundled_plugins() as $slug) {
        if (vinasite_install_bundled_plugin($slug)) {
            vinasite_activate_bundled_plugin($slug);
        }
    }
}

/** Nhắc + nút "Cài & Kích hoạt" nếu plugin chưa active (backup khi tự cài lỗi). */
add_action('admin_notices', 'vinasite_bundled_plugin_notice');
function vinasite_bundled_plugin_notice()
{
    if (!current_user_can('install_plugins')) {
        return;
    }
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $pending = array();
    foreach (vinasite_bundled_plugins() as $slug) {
        $file = vinasite_bundled_plugin_file($slug);
        if (!(file_exists(WP_PLUGIN_DIR . '/' . $file) && is_plugin_active($file))) {
            $pending[] = $slug;
        }
    }
    if (empty($pending)) {
        return;
    }
    $url = wp_nonce_url(admin_url('admin-post.php?action=vinasite_install_bundled'), 'vinasite_bundled');
    echo '<div class="notice notice-info"><p>'
        . '<strong>Theme VinaSite</strong> có kèm plugin <strong>Vinasite Google Indexing</strong> '
        . '(đẩy URL lên Google để index nhanh). '
        . '<a href="' . esc_url($url) . '" class="button button-primary" style="margin-left:8px">Cài &amp; Kích hoạt</a>'
        . '</p></div>';
}

/** Xử lý nút "Cài & Kích hoạt". */
add_action('admin_post_vinasite_install_bundled', 'vinasite_bundled_handle_install');
function vinasite_bundled_handle_install()
{
    if (!current_user_can('install_plugins') || !check_admin_referer('vinasite_bundled')) {
        wp_die('Không đủ quyền.');
    }
    foreach (vinasite_bundled_plugins() as $slug) {
        if (vinasite_install_bundled_plugin($slug)) {
            vinasite_activate_bundled_plugin($slug);
        }
    }
    wp_safe_redirect(admin_url('tools.php?page=vgi'));
    exit;
}
