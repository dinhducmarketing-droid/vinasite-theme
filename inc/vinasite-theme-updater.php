<?php
/**
 * VinaSite – Tự cập nhật theme từ GitHub.
 *
 * Nhúng thư viện Plugin Update Checker (không cần plugin ngoài như Git Updater).
 * Theme tự kiểm tra nhánh `main` của repo GitHub, so version trong style.css,
 * và hiện "Có bản cập nhật" trong WP Admin như theme premium.
 *
 * Repo Public → KHÔNG cần token. Nếu sau này chuyển Private, thêm:
 *   $uc->getVcsApi()->enableReleaseAssets();  // hoặc setAuthentication('TOKEN');
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php';

$vinasite_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/dinhducmarketing-droid/vinasite-theme/',
    get_template_directory() . '/style.css',
    'vinasite'
);

// Đọc version từ nhánh main (thay vì phải tạo Release cho mỗi bản).
$vinasite_update_checker->setBranch('main');
