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
    $defaults = array(
        'company_name' => 'CÔNG TY LUẬT TNHH DRAGON',
        'slogan'       => 'Niềm tin của khách hàng là uy tín của chúng tôi',
        'phone'        => '0983 019 109',
        'hotline'      => '1900 599 979',
        'show_hotline' => '1',
        'email'        => 'dragonlawfirm@gmail.com',
        'zalo'         => '0983019109',
        'address'      => 'Phòng 08 tầng 09 toà nhà VINACONEX DIAMOND TOWER, số 459C Bạch Mai, phường Bạch Mai, thành phố Hà Nội.',
        'so_dkkd'      => '0104313092',
        'mst'          => '0104313092',
        'noi_cap'      => 'Chi cục Thuế Cầu Giấy',
        'work_hours'   => 'Tiếp nhận tư vấn: 8h00 – 20h00 (T2 – CN)',
        'map_embed'    => 'https://www.google.com/maps?q=459C+B%E1%BA%A1ch+Mai,+H%C3%A0+N%E1%BB%99i&output=embed',
        'form_email'   => get_option('admin_email'),
        'facebook'     => '',
        'youtube'      => '',
        // Section imagery (firm-owned photos from the Media Library; admin-editable).
        'hero_img'     => 'https://vanphongluatsu.com.vn/wp-content/uploads/2026/03/97db0e89-c7ef-4519-b790-a2c9f1b02bf3.jpg',
        'about_img'    => 'https://vanphongluatsu.com.vn/wp-content/uploads/2025/07/luat-su-bao-chua-gioi-tai-ha-noi-3.jpg',
        'featured_img' => 'https://vanphongluatsu.com.vn/wp-content/uploads/2026/03/banner-2.jpg',
        'cta_img'      => 'https://vanphongluatsu.com.vn/wp-content/uploads/2026/03/97db0e89-c7ef-4519-b790-a2c9f1b02bf3.jpg',
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
 * Practice areas – reused across mega menu, practice grid, footer, problem selector.
 * URLs are resolved dynamically via dragon_cat_url() from the category slug that
 * has the most content, so links always point at the real (nested) archive URL.
 */
function dragon_practice_areas()
{
    return array(
        array(
            'key'   => 'hinh-su',
            'icon'  => 'gavel',
            'title' => 'Luật hình sự',
            'desc'  => 'Bào chữa, bảo vệ quyền lợi trong các vụ án hình sự; tư vấn thủ tục tố tụng, tạm giam, khởi tố và tranh tụng tại toà.',
            'url'   => dragon_cat_url('tu-van-hinh-su'),
            'subs'  => array(
                array('Tranh tụng hình sự', dragon_cat_url('tranh-tung-hinh-su')),
                array('Tư vấn hình sự', dragon_cat_url('tu-van-hinh-su')),
            ),
        ),
        array(
            'key'   => 'dan-su',
            'icon'  => 'scale',
            'title' => 'Dân sự & tranh chấp',
            'desc'  => 'Giải quyết tranh chấp dân sự, thừa kế, bồi thường thiệt hại; đại diện thương lượng, hoà giải và khởi kiện.',
            'url'   => dragon_cat_url('tu-van-dan-su'),
            'subs'  => array(
                array('Di chúc – thừa kế', dragon_cat_url('di-chuc-thua-ke')),
                array('Luật sư riêng', dragon_cat_url('luat-su-rieng')),
            ),
        ),
        array(
            'key'   => 'dat-dai',
            'icon'  => 'home',
            'title' => 'Đất đai & nhà ở',
            'desc'  => 'Tư vấn chuyển nhượng, cấp sổ, tranh chấp ranh giới, thu hồi và đền bù; hỗ trợ thủ tục hành chính về nhà đất.',
            'url'   => dragon_cat_url('luat-su-dat-dai'),
            'subs'  => array(
                array('Luật sư đất đai', dragon_cat_url('luat-su-dat-dai')),
            ),
        ),
        array(
            'key'   => 'hon-nhan',
            'icon'  => 'heart',
            'title' => 'Hôn nhân & gia đình',
            'desc'  => 'Tư vấn ly hôn, phân chia tài sản, quyền nuôi con, cấp dưỡng và nhận con nuôi; giải quyết nhanh, kín đáo.',
            'url'   => dragon_cat_url('tu-van-hon-nhan'),
            'subs'  => array(
                array('Tư vấn hôn nhân', dragon_cat_url('tu-van-hon-nhan')),
                array('Nhận con nuôi', dragon_cat_url('nhan-con-nuoi')),
            ),
        ),
        array(
            'key'   => 'doanh-nghiep',
            'icon'  => 'building',
            'title' => 'Doanh nghiệp & thương mại',
            'desc'  => 'Thành lập, tái cấu trúc, tư vấn thường xuyên cho doanh nghiệp; giải quyết tranh chấp cổ đông và kinh doanh thương mại.',
            'url'   => dragon_cat_url('tu-van-doanh-nghiep'),
            'subs'  => array(
                array('Kinh doanh thương mại', dragon_cat_url('kinh-doanh-thuong-mai')),
                array('Tư vấn doanh nghiệp', dragon_cat_url('tu-van-doanh-nghiep')),
            ),
        ),
        array(
            'key'   => 'hop-dong',
            'icon'  => 'contract',
            'title' => 'Hợp đồng & đầu tư',
            'desc'  => 'Rà soát, soạn thảo, đàm phán hợp đồng; tư vấn đầu tư trong và ngoài nước, điều chỉnh giấy chứng nhận đầu tư.',
            'url'   => dragon_cat_url('dich-vu-luat-su'),
            'subs'  => array(
                array('Điều chỉnh giấy chứng nhận đầu tư', home_url('/dieu-chinh-giay-chung-nhan-dau-tu/')),
            ),
        ),
        array(
            'key'   => 'hanh-chinh',
            'icon'  => 'stamp',
            'title' => 'Hành chính',
            'desc'  => 'Khiếu nại, khởi kiện quyết định hành chính; tư vấn thủ tục cấp phép, xử phạt vi phạm và làm việc với cơ quan nhà nước.',
            'url'   => dragon_cat_url('hanh-chinh'),
            'subs'  => array(
                array('Thủ tục cấp phép', dragon_cat_url('thu-tuc-cap-phep')),
            ),
        ),
        array(
            'key'   => 'trong-tai',
            'icon'  => 'briefcase',
            'title' => 'Trọng tài thương mại',
            'desc'  => 'Đại diện giải quyết tranh chấp bằng trọng tài thương mại; tư vấn lựa chọn phương thức và thi hành phán quyết.',
            'url'   => dragon_cat_url('trong-tai-thuong-mai'),
            'subs'  => array(
                array('Trọng tài thương mại', dragon_cat_url('trong-tai-thuong-mai')),
            ),
        ),
    );
}

/** Hero slides – text is real HTML, never baked into images. */
function dragon_hero_slides()
{
    $phone = dragon_opt('phone');
    // Per-slide background photos (firm-owned, hosted locally in the Media Library).
    // Only two artworks supplied, so slide 3 reuses the library shot.
    $img_library = 'https://vanphongluatsu.com.vn/wp-content/uploads/2026/07/b1.jpg';
    $img_court   = 'https://vanphongluatsu.com.vn/wp-content/uploads/2026/07/b2.jpg';
    return array(
        array(
            'eyebrow' => 'Công ty Luật TNHH Dragon',
            'title'   => 'Công ty Luật TNHH Dragon – Luật sư uy tín tại Hà Nội',
            'is_h1'   => true,
            'desc'    => 'Đồng hành cùng cá nhân và doanh nghiệp bằng giải pháp pháp lý chuyên nghiệp, bảo mật và hiệu quả.',
            'img'     => $img_library,
            'cta1'    => array('Đặt lịch tư vấn', '#dragon-consultation'),
            'cta2'    => array('Gọi ' . $phone, 'tel:' . dragon_tel('phone')),
        ),
        array(
            'eyebrow' => 'Luật sư tranh tụng',
            'title'   => 'Luật sư tranh tụng bảo vệ quyền và lợi ích hợp pháp',
            'is_h1'   => false,
            'desc'    => 'Tiếp nhận, đánh giá hồ sơ và xây dựng phương án xử lý phù hợp cho từng vụ việc.',
            'img'     => $img_court,
            'cta1'    => array('Trao đổi với luật sư', '#dragon-consultation'),
            'cta2'    => array('Gọi ' . $phone, 'tel:' . dragon_tel('phone')),
        ),
        array(
            'eyebrow' => 'Pháp chế doanh nghiệp',
            'title'   => 'Tư vấn pháp lý thường xuyên cho doanh nghiệp',
            'is_h1'   => false,
            'desc'    => 'Hỗ trợ hợp đồng, đầu tư, lao động, quản trị nội bộ và giải quyết tranh chấp kinh doanh.',
            'img'     => $img_library,
            'cta1'    => array('Đăng ký tư vấn doanh nghiệp', '#dragon-consultation'),
            'cta2'    => array('Gọi ' . $phone, 'tel:' . dragon_tel('phone')),
        ),
    );
}
