<?php
/**
 * VinaSite – Tự cài & kích hoạt các plugin khuyến nghị kèm theme.
 *
 * Hai nguồn plugin:
 *  - 'wporg'   : tải TỪ kho WordPress.org theo slug (luôn lấy bản mới nhất,
 *                WP tự cập nhật sau). KHÔNG nhồi zip vào theme để tránh đóng
 *                băng bản cũ và phình repo.
 *  - 'bundled' : plugin tự viết, đóng gói zip trong inc/bundled/.
 *
 * Khi KÍCH HOẠT THEME lần đầu → tự cài + bật các plugin 'auto'. Plugin không
 * 'auto' (vd WooCommerce) chỉ cài khi admin bấm nút — vì không phải site nào
 * cũng bán hàng.
 *
 * Lưu ý: after_switch_theme chỉ chạy lúc bật theme, KHÔNG chạy khi cập nhật.
 * Vì vậy site đang chạy sẽ không bị tự cài thêm plugin khi update theme — thay
 * vào đó có thông báo trong admin mời cài các plugin còn thiếu bằng 1 nút.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Danh sách plugin khuyến nghị.
 *  - source : 'wporg' | 'bundled'
 *  - file   : đường dẫn file chính (slug/xxx.php) để kiểm tra đã kích hoạt chưa
 *  - label  : tên hiển thị
 *  - auto   : true = tự cài+bật khi kích hoạt theme; false = chỉ cài khi bấm nút
 */
function vinasite_recommended_plugins()
{
    $list = array(
        'litespeed-cache' => array(
            'source' => 'wporg',
            'file'   => 'litespeed-cache/litespeed-cache.php',
            'label'  => 'LiteSpeed Cache',
            'auto'   => true,
        ),
        'vinasite-toc' => array(
            'source' => 'bundled',
            'file'   => 'vinasite-toc/vinasite-toc.php',
            'label'  => 'Vinasite Mục Lục',
            'auto'   => true,
        ),
        'contact-form-7' => array(
            'source' => 'wporg',
            'file'   => 'contact-form-7/wp-contact-form-7.php', // file chính KHÁC slug
            'label'  => 'Contact Form 7',
            'auto'   => true,
        ),
        'tinymce-advanced' => array(
            'source' => 'wporg',
            'file'   => 'tinymce-advanced/tinymce-advanced.php',
            'label'  => 'Advanced Editor Tools',
            'auto'   => true,
        ),
        'vinasite-call-button' => array(
            'source' => 'bundled',
            'file'   => 'vinasite-call-button/vinasite-call-button.php',
            'label'  => 'Call By Vinasite.com.vn',
            'auto'   => true,
        ),
        'vinasite-google-indexing' => array(
            'source' => 'bundled',
            'file'   => 'vinasite-google-indexing/vinasite-google-indexing.php',
            'label'  => 'Vinasite Google Indexing',
            'auto'   => true,
        ),
        'vinasite-light-star-rating' => array(
            'source' => 'bundled',
            'file'   => 'vinasite-light-star-rating/vinasite-light-star-rating.php',
            'label'  => 'Vinasite Light Star Ratings',
            'auto'   => true,
        ),
        // WooCommerce: nền tảng bán hàng — chỉ cài khi bấm nút (không phải site
        // nào cũng cần), nên auto = false.
        'woocommerce' => array(
            'source' => 'wporg',
            'file'   => 'woocommerce/woocommerce.php',
            'label'  => 'WooCommerce',
            'auto'   => false,
        ),
        // 'vinasite-light-star-ratings' => array(... 'source'=>'bundled' ...) — chờ nguồn.
    );
    return apply_filters('vinasite_recommended_plugins', $list);
}

/**
 * Cài 1 plugin (nếu chưa có thư mục). Trả về true nếu đã/đang có sau khi chạy.
 * Xử lý cả 2 nguồn: bundled (giải nén zip) và wporg (tải từ WordPress.org).
 */
function vinasite_install_plugin($slug, $cfg)
{
    if (is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
        return true; // đã cài
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';

    if ($cfg['source'] === 'bundled') {
        $zip = get_template_directory() . '/inc/bundled/' . $slug . '.zip';
        if (!file_exists($zip)) {
            return false;
        }
        WP_Filesystem();
        return !is_wp_error(unzip_file($zip, WP_PLUGIN_DIR));
    }

    // Nguồn WordPress.org: hỏi API lấy link tải bản mới nhất rồi cài.
    require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

    $api = plugins_api('plugin_information', array('slug' => $slug, 'fields' => array('sections' => false)));
    // plugins_api trả link ở 'download_link' (KHÔNG phải 'download_url').
    if (is_wp_error($api) || empty($api->download_link)) {
        return false;
    }
    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
    $upgrader->install($api->download_link);
    return is_dir(WP_PLUGIN_DIR . '/' . $slug);
}

/** Kích hoạt plugin nếu đã cài & chưa active. */
function vinasite_activate_plugin_file($file)
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    if (file_exists(WP_PLUGIN_DIR . '/' . $file) && !is_plugin_active($file)) {
        activate_plugin($file);
    }
}

/**
 * Cài + bật một tập plugin. $only_auto = true thì bỏ qua plugin opt-in.
 * $slugs (mảng) nếu truyền thì chỉ xử lý đúng các slug đó (dùng cho nút cài lẻ).
 */
function vinasite_install_recommended($only_auto = true, $slugs = null)
{
    if (!current_user_can('install_plugins')) {
        return;
    }
    foreach (vinasite_recommended_plugins() as $slug => $cfg) {
        if ($slugs !== null && !in_array($slug, (array) $slugs, true)) {
            continue;
        }
        if ($only_auto && empty($cfg['auto'])) {
            continue;
        }
        if (vinasite_install_plugin($slug, $cfg)) {
            vinasite_activate_plugin_file($cfg['file']);
        }
    }
}

/** Khi KÍCH HOẠT THEME → tự cài + bật các plugin 'auto'. */
add_action('after_switch_theme', 'vinasite_recommended_on_theme_activate');
function vinasite_recommended_on_theme_activate()
{
    vinasite_install_recommended(true);
}

/** Các plugin 'auto' còn thiếu / chưa bật. */
function vinasite_pending_recommended()
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $pending = array();
    foreach (vinasite_recommended_plugins() as $slug => $cfg) {
        if (empty($cfg['auto'])) {
            continue;
        }
        if (!(file_exists(WP_PLUGIN_DIR . '/' . $cfg['file']) && is_plugin_active($cfg['file']))) {
            $pending[$slug] = $cfg;
        }
    }
    return $pending;
}

/** Nhắc cài các plugin khuyến nghị còn thiếu (an toàn khi tự cài lỗi, và cho site update). */
add_action('admin_notices', 'vinasite_recommended_notice');
function vinasite_recommended_notice()
{
    if (!current_user_can('install_plugins')) {
        return;
    }
    if (get_user_meta(get_current_user_id(), 'vinasite_hide_plugin_notice', true)) {
        return; // admin đã ẩn
    }

    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $pending = vinasite_pending_recommended();
    $woo_active = is_plugin_active('woocommerce/woocommerce.php');

    if (empty($pending) && $woo_active) {
        return;
    }

    echo '<div class="notice notice-info"><p><strong>Theme VinaSite</strong> — plugin khuyến nghị:</p>';

    if (!empty($pending)) {
        $names = array();
        foreach ($pending as $cfg) {
            $names[] = esc_html($cfg['label']);
        }
        $url = wp_nonce_url(admin_url('admin-post.php?action=vinasite_install_recommended'), 'vinasite_recommended');
        echo '<p>Còn thiếu: ' . implode(', ', $names) . ' '
            . '<a href="' . esc_url($url) . '" class="button button-primary" style="margin-left:8px">Cài &amp; kích hoạt tất cả</a></p>';
    }

    if (!$woo_active) {
        $url = wp_nonce_url(admin_url('admin-post.php?action=vinasite_install_woo'), 'vinasite_woo');
        echo '<p><em>WooCommerce</em> (chỉ cần nếu website bán hàng) '
            . '<a href="' . esc_url($url) . '" class="button" style="margin-left:8px">Cài WooCommerce</a></p>';
    }

    $hide = wp_nonce_url(admin_url('admin-post.php?action=vinasite_hide_plugin_notice'), 'vinasite_hide_notice');
    echo '<p><a href="' . esc_url($hide) . '">Ẩn thông báo này</a></p>';
    echo '</div>';
}

/** Nút "Cài & kích hoạt tất cả" (các plugin auto). */
add_action('admin_post_vinasite_install_recommended', 'vinasite_handle_install_recommended');
function vinasite_handle_install_recommended()
{
    if (!current_user_can('install_plugins') || !check_admin_referer('vinasite_recommended')) {
        wp_die('Không đủ quyền.');
    }
    vinasite_install_recommended(true);
    wp_safe_redirect(admin_url('plugins.php'));
    exit;
}

/** Nút "Cài WooCommerce" (opt-in). */
add_action('admin_post_vinasite_install_woo', 'vinasite_handle_install_woo');
function vinasite_handle_install_woo()
{
    if (!current_user_can('install_plugins') || !check_admin_referer('vinasite_woo')) {
        wp_die('Không đủ quyền.');
    }
    vinasite_install_recommended(false, array('woocommerce'));
    wp_safe_redirect(admin_url('plugins.php'));
    exit;
}

/** Ẩn thông báo (theo từng người dùng). */
add_action('admin_post_vinasite_hide_plugin_notice', 'vinasite_handle_hide_notice');
function vinasite_handle_hide_notice()
{
    if (!current_user_can('install_plugins') || !check_admin_referer('vinasite_hide_notice')) {
        wp_die('Không đủ quyền.');
    }
    update_user_meta(get_current_user_id(), 'vinasite_hide_plugin_notice', 1);
    wp_safe_redirect(wp_get_referer() ?: admin_url());
    exit;
}
