<?php
/**
 * VinaSite – Trang chủ generic (kiểu trang chủ) + dữ liệu nội dung VinaSite.
 *
 * Theme cha hỗ trợ 2 kiểu trang chủ:
 *  - "vinasite" (MẶC ĐỊNH): giới thiệu theme VinaSite + dịch vụ của VinaSite.
 *  - "content": render nội dung trang chủ tự soạn trong WordPress (site di cư).
 *
 * Nội dung chuyên ngành (vd hãng luật) do CHILD THEME cung cấp bằng cách ghi đè
 * front-page.php — theme cha không chứa nội dung ngành nghề nào.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

/* -------------------------------------------------------------------------
 * Preset trang chủ
 * ---------------------------------------------------------------------- */

/** Danh sách kiểu trang chủ hợp lệ (theme generic). Nội dung chuyên ngành do
 *  child theme cung cấp (child ghi đè front-page.php), không nằm ở đây. */
function vinasite_home_presets()
{
    return array(
        'vinasite' => 'VinaSite – giới thiệu theme & dịch vụ (mặc định)',
        'content'  => 'Nội dung trang chủ soạn trong WordPress (site di cư)',
    );
}

/**
 * Kiểu trang chủ đang dùng.
 *
 * Ưu tiên theme_mod `vinasite_front_mode` = 'content' để TƯƠNG THÍCH NGƯỢC với
 * các site di cư từ Flatsome (vd vietnhatsknn.com) đã đặt sẵn mod này.
 * Còn lại đọc option `vinasite_home_preset`, mặc định 'vinasite'.
 */
function vinasite_home_preset()
{
    if (get_theme_mod('vinasite_front_mode', '') === 'content') {
        return 'content';
    }
    $preset = (string) get_option('vinasite_home_preset', 'vinasite');
    return array_key_exists($preset, vinasite_home_presets()) ? $preset : 'vinasite';
}

/** Sanitize lựa chọn preset. */
function vinasite_sanitize_home_preset($val)
{
    return array_key_exists($val, vinasite_home_presets()) ? $val : 'vinasite';
}

/** Mục Customizer để đổi kiểu trang chủ. */
add_action('customize_register', 'vinasite_home_customize');
function vinasite_home_customize($wp_customize)
{
    $wp_customize->add_section('vinasite_home', array(
        'title'       => 'VinaSite – Kiểu trang chủ',
        'priority'    => 18,
        'description' => 'Chọn nội dung hiển thị ở trang chủ.',
    ));

    $wp_customize->add_setting('vinasite_home_preset', array(
        'default'           => 'vinasite',
        'type'              => 'option',
        'sanitize_callback' => 'vinasite_sanitize_home_preset',
        'transport'         => 'refresh',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('vinasite_home_preset', array(
        'label'       => 'Kiểu trang chủ',
        'description' => 'Mặc định là trang giới thiệu VinaSite. Chọn "Nội dung tự soạn" nếu bạn tự dựng trang chủ trong WordPress.',
        'section'     => 'vinasite_home',
        'type'        => 'select',
        'choices'     => vinasite_home_presets(),
    ));
}

/* -------------------------------------------------------------------------
 * Thông tin VinaSite (dùng cho trang chủ mặc định)
 * ---------------------------------------------------------------------- */

/**
 * Thông tin liên hệ cho trang chủ mặc định: ưu tiên cấu hình của site
 * (Customizer), nếu chủ site chưa nhập thì hiện thông tin của VinaSite.
 */
function vinasite_info($key)
{
    $mac_dinh = array(
        'company_name' => 'Công ty TNHH VinaSite Việt Nam',
        'brand'        => 'VinaSite',
        'slogan'       => 'Tối ưu hoá lợi nhuận của bạn',
        'phone'        => '052 897 6666',
        'email'        => 'info@vinasite.com.vn',
        'website'      => 'https://vinasite.com.vn/',
    );

    if ($key !== 'brand' && $key !== 'website') {
        $tuy_chinh = dragon_opt($key);
        // dragon_opt('company_name') fallback về tên site nên phải loại trường hợp đó.
        if ($tuy_chinh !== '' && $tuy_chinh !== get_bloginfo('name')) {
            return $tuy_chinh;
        }
    }

    return isset($mac_dinh[$key]) ? $mac_dinh[$key] : '';
}

/** Số điện thoại chỉ còn chữ số, dùng cho link tel:. */
function vinasite_info_tel()
{
    return preg_replace('/[^0-9+]/', '', vinasite_info('phone'));
}

/* -------------------------------------------------------------------------
 * Nội dung trang chủ mặc định
 * ---------------------------------------------------------------------- */

/** Tính năng nổi bật của theme VinaSite. */
function vinasite_home_features()
{
    return array(
        array(
            'icon'  => 'shield',
            'title' => 'Tự cập nhật từ GitHub',
            'desc'  => 'Theme tự nhận bản mới và cập nhật ngay trong trang Giao diện của WordPress, không cần tải zip thủ công.',
        ),
        array(
            'icon'  => 'users',
            'title' => 'Dùng chung cho nhiều website',
            'desc'  => 'Một mã nguồn, nhiều site. Mỗi site tự nhập thông tin doanh nghiệp riêng, không hardcode vào code.',
        ),
        array(
            'icon'  => 'star',
            'title' => 'Đổi màu & phông chữ tuỳ ý',
            'desc'  => 'Chọn màu chính, màu nhấn và 1 trong 6 phông chữ. Các tông đậm nhạt được suy ra tự động.',
        ),
        array(
            'icon'  => 'briefcase',
            'title' => 'Kèm sẵn plugin cần thiết',
            'desc'  => 'Nút gọi nổi và Google Indexing được cài, kích hoạt tự động ngay khi bạn bật theme.',
        ),
        array(
            'icon'  => 'process',
            'title' => 'Nhẹ và nhanh',
            'desc'  => 'Không phụ thuộc page builder thương mại. CSS/JS riêng, icon SVG nội tuyến, ảnh tải trễ.',
        ),
        array(
            'icon'  => 'article',
            'title' => 'Chuẩn SEO sẵn',
            'desc'  => 'Schema có cấu trúc, thẻ tiêu đề/mô tả, HTML ngữ nghĩa và tương thích Rank Math.',
        ),
    );
}

/** Dịch vụ của VinaSite. */
function vinasite_home_services()
{
    return array(
        array(
            'key'   => 'thiet-ke-web',
            'icon'  => 'home',
            'title' => 'Thiết kế website',
            'desc'  => 'Website công ty, bán hàng, bất động sản, nội thất, spa, du lịch, trường học… chuẩn SEO, chuẩn di động.',
        ),
        array(
            'key'   => 'seo',
            'icon'  => 'star',
            'title' => 'Dịch vụ SEO website',
            'desc'  => 'Đưa từ khoá lên top và tối ưu chuyển đổi khách hàng, cam kết kết quả rõ ràng theo hợp đồng.',
        ),
        array(
            'key'   => 'quan-tri-web',
            'icon'  => 'process',
            'title' => 'Quản trị website',
            'desc'  => 'Viết bài, cập nhật nội dung, sao lưu, vá bảo mật và theo dõi website hoạt động ổn định mỗi ngày.',
        ),
        array(
            'key'   => 'hosting',
            'icon'  => 'building',
            'title' => 'Hosting & Cloud VPS',
            'desc'  => 'Hosting tốc độ cao, Cloud VPS NVMe, VPS N8N — ổn định, sao lưu định kỳ, hỗ trợ kỹ thuật 24/7.',
        ),
        array(
            'key'   => 'ten-mien-email',
            'icon'  => 'mail',
            'title' => 'Tên miền & email doanh nghiệp',
            'desc'  => 'Đăng ký tên miền, email theo tên miền riêng — an toàn, không quảng cáo, kèm chứng thực SSL.',
        ),
        array(
            'key'   => 'noi-dung',
            'icon'  => 'article',
            'title' => 'Nội dung & thiết kế ảnh',
            'desc'  => 'Viết bài chuẩn SEO theo yêu cầu, thiết kế banner và hình ảnh thương hiệu cho website.',
        ),
    );
}

/** Các gói dịch vụ. Giá để trống — mỗi site tự điền sau. */
function vinasite_home_pricing()
{
    return array(
        array(
            'name'     => 'Cơ bản',
            'desc'     => 'Dành cho cá nhân và cửa hàng mới bắt đầu.',
            'featured' => false,
            'items'    => array(
                'Giao diện VinaSite chuẩn di động',
                'Tên miền + hosting năm đầu',
                'Tối đa 5 trang nội dung',
                'Chứng thực SSL',
                'Hỗ trợ kỹ thuật trong giờ hành chính',
            ),
        ),
        array(
            'name'     => 'Chuyên nghiệp',
            'desc'     => 'Phổ biến nhất cho doanh nghiệp vừa và nhỏ.',
            'featured' => true,
            'items'    => array(
                'Toàn bộ gói Cơ bản',
                'Thiết kế theo nhận diện thương hiệu',
                'Chuẩn SEO onpage + Google Analytics',
                'Email doanh nghiệp theo tên miền',
                'Quản trị nội dung 3 tháng đầu',
            ),
        ),
        array(
            'name'     => 'Doanh nghiệp',
            'desc'     => 'Cho website nhiều nội dung, cần tăng trưởng.',
            'featured' => false,
            'items'    => array(
                'Toàn bộ gói Chuyên nghiệp',
                'Cloud VPS NVMe riêng',
                'Dịch vụ SEO cam kết top',
                'Viết bài chuẩn SEO hàng tháng',
                'Hỗ trợ kỹ thuật 24/7',
            ),
        ),
    );
}
