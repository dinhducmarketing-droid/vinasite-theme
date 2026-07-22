<?php
/**
 * Dragon Law Firm – Central configuration & Customizer.
 *
 * Single source of truth for business info, phones, Zalo, form recipient,
 * hero slides and service data. Editable in Admin via Appearance > Customize
 * ("Dragon – Thông tin & Trang chủ"). Falls back to the existing ACF
 * "dia_chi_lien_he" option group so nothing is duplicated.
 *
 * @package ntgsite-dragon
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Read an ACF sub-field from the existing dia_chi_lien_he option repeater.
 * Cached per-request so we don't loop the repeater on every call.
 */
function dragon_acf_contact($key)
{
    static $cache = null;
    if ($cache === null) {
        $cache = array();
        if (function_exists('have_rows') && have_rows('dia_chi_lien_he', 'option')) {
            while (have_rows('dia_chi_lien_he', 'option')) {
                the_row();
                foreach (array('ten_cong_ty', 'dia_chi', 'so_dkkd', 'mst', 'noi_cap', 'hotline', 'tel', 'email', 'website', 'gio_lam_viec') as $f) {
                    $cache[$f] = function_exists('get_sub_field') ? (string) get_sub_field($f) : '';
                }
            }
        }
    }
    return isset($cache[$key]) ? $cache[$key] : '';
}

/**
 * Central option getter. Priority: Customizer (theme_mod) > ACF option > default.
 * All business content flows through here so it is never hard-coded twice.
 *
 * @param string $key
 * @return string
 */
function dragon_opt($key)
{
    // Mặc định TRUNG TÍNH cho theme tái dùng — mỗi site tự nhập ở Customizer.
    // (Site cũ đã "chốt" giá trị riêng vào theme_mods nên không bị ảnh hưởng.)
    $defaults = array(
        'company_name' => get_bloginfo('name'),
        'company_short' => '',
        'slogan'       => '',
        'phone'        => '',
        'hotline'      => '',
        'show_hotline' => '1',
        'email'        => '',
        'zalo'         => '',
        'address'      => '',
        'so_dkkd'      => '',
        'mst'          => '',
        'noi_cap'      => '',
        'work_hours'   => '',
        'map_embed'    => '',
        'form_email'   => get_option('admin_email'),
        'logo'         => '',
        'ga_ids'       => '',
        'facebook'     => '',
        'youtube'      => '',
        // Ảnh các section — mỗi site tự chọn ở Customizer (rỗng = không hiện ảnh).
        'hero_img'     => '',
        'about_img'    => '',
        'featured_img' => '',
        'cta_img'      => '',
    );

    // 1) Customizer override.
    $mod = get_theme_mod('dragon_' . $key, '');
    if ($mod !== '' && $mod !== false) {
        return $mod;
    }

    // 2) Reuse existing ACF contact data where it maps cleanly.
    $acf_map = array(
        'company_name' => 'ten_cong_ty',
        'email'        => 'email',
        'so_dkkd'      => 'so_dkkd',
        'mst'          => 'mst',
        'noi_cap'      => 'noi_cap',
    );
    if (isset($acf_map[$key])) {
        $v = dragon_acf_contact($acf_map[$key]);
        if ($v !== '') {
            return $v;
        }
    }

    // 3) Default.
    return isset($defaults[$key]) ? $defaults[$key] : '';
}

/** Digits-only phone for tel: / zalo links. */
function dragon_tel($key = 'phone')
{
    return preg_replace('/[^0-9+]/', '', dragon_opt($key));
}

/**
 * Tên thương hiệu hiển thị TRONG NỘI DUNG (thân thiện): company_short → company_name → tên site.
 * Dùng trong tiêu đề/đoạn văn các trang giới thiệu để tái dùng cho mọi site.
 */
function dragon_brand()
{
    $s = dragon_opt('company_short');
    if ($s !== '') { return $s; }
    $c = dragon_opt('company_name');
    return $c !== '' ? $c : get_bloginfo('name');
}

/**
 * URL logo của site: ưu tiên Logo site (custom_logo) → tùy chọn 'logo' (URL) → rỗng.
 * Rỗng thì header/footer hiển thị tên site bằng chữ.
 */
function dragon_logo_url()
{
    $id = get_theme_mod('custom_logo');
    if ($id) {
        $url = wp_get_attachment_image_url($id, 'full');
        if ($url) { return $url; }
    }
    return dragon_opt('logo');
}

/**
 * Resolve a real archive URL from a category slug (falls back to a page-style
 * permalink, then home). Categories on this site use NESTED hierarchical URLs,
 * so we must never hard-code "/chuyen-muc/<slug>/" (those redirect to home).
 */
function dragon_cat_url($slug)
{
    static $cache = array();
    if (isset($cache[$slug])) {
        return $cache[$slug];
    }
    $url = home_url('/' . ltrim($slug, '/') . '/');
    $term = get_category_by_slug($slug);
    if ($term) {
        $link = get_category_link($term->term_id);
        if ($link && !is_wp_error($link)) {
            $url = $link;
        }
    }
    return $cache[$slug] = $url;
}

/**
 * Lĩnh vực / nhóm dịch vụ — dùng ở mega menu, lưới, footer, bộ chọn vấn đề.
 * Theme cha để TRỐNG (generic). Child theme theo ngành bơm dữ liệu qua filter
 * 'dragon_practice_areas'. Site không có child → mảng rỗng, các khối tự ẩn.
 */
function dragon_practice_areas()
{
    if (get_theme_mod('dragon_practice_areas_off')) { return array(); }
    return apply_filters('dragon_practice_areas', array());
}

/**
 * Hero slides trang chủ — theme cha để TRỐNG. Child theme theo ngành bơm qua
 * filter 'dragon_hero_slides'.
 */
function dragon_hero_slides()
{
    return apply_filters('dragon_hero_slides', array());
}
