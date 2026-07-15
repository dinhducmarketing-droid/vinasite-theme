<?php
/**
 * Dragon – structured data. Emits a LegalService node (Local SEO) and a
 * FAQPage node, on the FRONT PAGE ONLY (the FAQ is actually rendered there).
 * We deliberately do NOT re-emit Organization/WebSite – Rank Math already
 * outputs those, so this avoids duplicate schema.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', 'dragon_output_schema', 20);
function dragon_output_schema()
{
    // Chỉ dùng cho trang chủ kiểu "dragon" — schema LegalService là của công ty luật.
    if (!is_front_page() || vinasite_home_preset() !== 'dragon') {
        return;
    }

    $logo = dragon_logo_url();

    $legal = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => home_url('/#legalservice'),
        'name'        => wp_strip_all_tags(dragon_opt('company_name')),
        'url'         => home_url('/'),
        'telephone'   => dragon_opt('phone'),
        'email'       => dragon_opt('email'),
        'priceRange'  => 'Theo thỏa thuận',
        'address'     => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => wp_strip_all_tags(dragon_opt('address')),
            'addressLocality' => 'Hà Nội',
            'addressCountry'  => 'VN',
        ),
        'areaServed'  => array('@type' => 'Country', 'name' => 'Việt Nam'),
        'taxID'       => dragon_opt('mst'),
        'slogan'      => wp_strip_all_tags(dragon_opt('slogan')),
        'openingHours' => 'Mo-Su 08:00-20:00',
    );
    if ($logo) { $legal['logo'] = $logo; $legal['image'] = $logo; }

    $same = array();
    foreach (array('facebook', 'youtube') as $s) {
        if (dragon_opt($s)) { $same[] = dragon_opt($s); }
    }
    if ($same) { $legal['sameAs'] = $same; }

    // FAQPage – mirrors the rendered accordion exactly.
    $faq_entities = array();
    if (function_exists('dragon_faq_items')) {
        foreach (dragon_faq_items() as $f) {
            $faq_entities[] = array(
                '@type'          => 'Question',
                'name'           => $f['q'],
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => $f['a']),
            );
        }
    }
    $faq = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        '@id'        => home_url('/#faq'),
        'mainEntity' => $faq_entities,
    );

    echo "\n<script type=\"application/ld+json\">" . wp_json_encode($legal, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
    if ($faq_entities) {
        echo '<script type="application/ld+json">' . wp_json_encode($faq, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
    }
}

/**
 * Homepage SEO title & meta description.
 * Only sets them if Rank Math is NOT managing the front page, to avoid conflicts.
 */
add_filter('pre_get_document_title', 'dragon_document_title', 5);
function dragon_document_title($title)
{
    if (!is_front_page() || defined('RANK_MATH_VERSION')) {
        return $title;
    }
    if (vinasite_home_preset() === 'dragon') {
        return 'Công ty Luật TNHH Dragon | Luật sư uy tín tại Hà Nội';
    }
    // Trang chủ mặc định: để WordPress tự dựng tiêu đề từ tên + mô tả site.
    return $title;
}

add_action('wp_head', 'dragon_meta_description', 1);
function dragon_meta_description()
{
    if (!is_front_page() || defined('RANK_MATH_VERSION')) {
        return;
    }

    if (vinasite_home_preset() === 'dragon') {
        $mo_ta = 'Công ty Luật TNHH Dragon tư vấn, tranh tụng và hỗ trợ pháp lý cho cá nhân, doanh nghiệp tại Hà Nội. Liên hệ luật sư qua số ' . dragon_opt('phone') . '.';
    } else {
        // Trang chủ mặc định: ưu tiên mô tả site chủ đã nhập, nếu trống thì giới thiệu theme.
        $mo_ta = get_bloginfo('description');
        if ($mo_ta === '') {
            $mo_ta = 'Giao diện VinaSite — website WordPress nhẹ, chuẩn SEO, tự cập nhật, do Công ty TNHH VinaSite Việt Nam thiết kế và phát triển.';
        }
    }

    echo '<meta name="description" content="' . esc_attr($mo_ta) . '"/>' . "\n";
}
