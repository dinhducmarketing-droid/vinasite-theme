<?php
/**
 * VinaSite – shim mở rộng cho các shortcode Flatsome UX Builder còn thiếu.
 *
 * Bổ sung: ux_slider, featured_box, team_member, testimonial, logo,
 * blog_posts, ux_gallery. Dùng cho các site di cư từ Flatsome (vd
 * vietnhatsknn.com). Chỉ đăng ký khi tag chưa tồn tại nên vô hại với
 * site khác dùng chung theme.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'vinasite_register_shim_extra', 20);
function vinasite_register_shim_extra()
{
    $map = array(
        'ux_slider'    => 'vinasite_sc_ux_slider',
        'featured_box' => 'vinasite_sc_featured_box',
        'team_member'  => 'vinasite_sc_team_member',
        'testimonial'  => 'vinasite_sc_testimonial',
        'logo'         => 'vinasite_sc_logo',
        'blog_posts'   => 'vinasite_sc_blog_posts',
        'ux_gallery'   => 'vinasite_sc_ux_gallery',
        'text_box'     => 'vinasite_sc_text_box',
    );
    foreach ($map as $tag => $cb) {
        if (!shortcode_exists($tag)) {
            add_shortcode($tag, $cb);
        }
    }
}

/* CSS + JS cho các component legacy (chỉ nặng ~vài KB). */
add_action('wp_enqueue_scripts', 'vinasite_shim_extra_assets', 22);
function vinasite_shim_extra_assets()
{
    $dir = get_template_directory();
    $css = '/assets/dragon/css/vinasite-legacy.css';
    $js  = '/assets/dragon/js/vinasite-legacy.js';
    // Bust cache theo mtime — sửa file là trình duyệt tự lấy bản mới.
    wp_enqueue_style('vinasite-legacy', get_template_directory_uri() . $css, array('dragon-base'), (string) @filemtime($dir . $css));
    wp_enqueue_script('vinasite-legacy', get_template_directory_uri() . $js, array(), (string) @filemtime($dir . $js), true);
}

/**
 * Bổ sung attr `class`, `bg`, `bg_overlay`, `bg_pos` cho [section]/[ux_banner]
 * của shim gốc mà không phải sửa nó (lọc output qua do_shortcode_tag).
 */
add_filter('do_shortcode_tag', 'vinasite_shim_extra_section_atts', 10, 3);
function vinasite_shim_extra_section_atts($out, $tag, $attr)
{
    if ($tag !== 'section' && $tag !== 'ux_banner') {
        return $out;
    }
    $attr      = (array) $attr;
    $extra_cls = isset($attr['class']) ? trim((string) $attr['class']) : '';
    $style     = '';

    if (!empty($attr['bg'])) {
        $bg_url = is_numeric($attr['bg']) ? wp_get_attachment_image_url((int) $attr['bg'], 'full') : $attr['bg'];
        if ($bg_url) {
            $ov  = !empty($attr['bg_overlay']) ? $attr['bg_overlay'] : 'rgba(255,255,255,0)';
            $pos = !empty($attr['bg_pos']) ? $attr['bg_pos'] : 'center';
            $style = 'background-image:linear-gradient(' . $ov . ',' . $ov . '),url(' . $bg_url . ');background-size:cover;background-position:' . $pos . ';';
        }
    }
    if ($extra_cls === '' && $style === '') {
        return $out;
    }
    if ($extra_cls !== '') {
        $out = preg_replace('/<section class="/', '<section class="' . esc_attr($extra_cls) . ' ', $out, 1);
    }
    if ($style !== '') {
        if (preg_match('/^<section[^>]*style="/', $out)) {
            $out = preg_replace('/(<section[^>]*style=")/', '$1' . esc_attr($style), $out, 1);
        } else {
            $out = preg_replace('/^<section /', '<section style="' . esc_attr($style) . '" ', $out, 1);
        }
    }
    return $out;
}

/** [ux_slider] – carousel scroll-snap thuần CSS + JS nhỏ (autoplay, dots, arrows). */
function vinasite_sc_ux_slider($atts, $content = '')
{
    $atts = shortcode_atts(array(
        'label' => '', 'timer' => '', 'bullets' => 'true', 'hide_nav' => 'false',
        'nav_style' => '', 'nav_color' => '', 'class' => '', 'freescroll' => '',
        'parallax' => '', 'nav_pos' => '', 'bullet_style' => '', 'visibility' => '',
    ), $atts);

    $cls = 'vs-slider';
    if ($atts['class'] !== '') {
        $cls .= ' ' . $atts['class'];
    }
    if ($atts['bullets'] === 'false') {
        $cls .= ' vs-slider--nodots';
    }
    if ($atts['hide_nav'] === 'true') {
        $cls .= ' vs-slider--nonav';
    }

    return '<div class="' . esc_attr($cls) . '" data-timer="' . esc_attr((int) $atts['timer']) . '">'
        . '<div class="vs-slider__track">' . do_shortcode($content) . '</div>'
        . '<button class="vs-slider__arrow vs-slider__arrow--prev" type="button" aria-label="Slide trước">&#10094;</button>'
        . '<button class="vs-slider__arrow vs-slider__arrow--next" type="button" aria-label="Slide sau">&#10095;</button>'
        . '<div class="vs-slider__dots"></div>'
        . '</div>';
}

/** [featured_box] – hộp icon + tiêu đề + mô tả (pos=center|left). */
function vinasite_sc_featured_box($atts, $content = '')
{
    $atts = shortcode_atts(array('img' => '', 'img_width' => '', 'pos' => 'center', 'margin' => '', 'link' => ''), $atts);
    $w    = $atts['img_width'] !== '' ? (int) $atts['img_width'] : 60;
    $img  = '';
    if ($atts['img'] !== '') {
        $img = wp_get_attachment_image((int) $atts['img'], 'medium', false, array(
            'class' => 'vs-fbox__icon',
            'style' => 'width:' . $w . 'px;height:auto',
        ));
    }
    $cls   = 'vs-fbox vs-fbox--' . ($atts['pos'] === 'left' ? 'left' : 'center');
    $style = $atts['margin'] !== '' ? ' style="margin:' . esc_attr($atts['margin']) . '"' : '';

    return '<div class="' . esc_attr($cls) . '"' . $style . '>'
        . '<div class="vs-fbox__media">' . $img . '</div>'
        . '<div class="vs-fbox__body">' . do_shortcode($content) . '</div>'
        . '</div>';
}

/** [team_member] – thẻ nhân sự: ảnh tròn + tên + chức danh + nội dung. */
function vinasite_sc_team_member($atts, $content = '')
{
    $atts = shortcode_atts(array(
        'img' => '', 'name' => '', 'title' => '', 'image_width' => '',
        'image_height' => '', 'image_radius' => '', 'text_padding' => '',
    ), $atts);
    $img = '';
    if ($atts['img'] !== '') {
        $img = wp_get_attachment_image((int) $atts['img'], 'medium', false, array('class' => 'vs-team__img'));
    }
    return '<div class="vs-team">'
        . '<div class="vs-team__media">' . $img . '</div>'
        . '<div class="vs-team__body">'
        . '<h4 class="vs-team__name">' . esc_html($atts['name']) . '</h4>'
        . '<p class="vs-team__role">' . esc_html($atts['title']) . '</p>'
        . do_shortcode($content)
        . '</div></div>';
}

/**
 * [testimonial] – thẻ nhận xét. Dùng lại class .testimonial-box/.testimonial-image
 * để kế thừa nguyên bộ CSS thiết kế "card trắng trên gradient xanh".
 */
function vinasite_sc_testimonial($atts, $content = '')
{
    $atts = shortcode_atts(array('image' => '', 'image_width' => '', 'pos' => 'center', 'stars' => '', 'name' => '', 'company' => ''), $atts);
    $w    = $atts['image_width'] !== '' ? (int) $atts['image_width'] : 96;
    $img  = '';
    if ($atts['image'] !== '') {
        $img = wp_get_attachment_image((int) $atts['image'], 'thumbnail', false, array(
            'style' => 'width:' . $w . 'px;height:' . $w . 'px;object-fit:cover',
        ));
    }
    return '<div class="testimonial-box">'
        . '<div class="testimonial-image">' . $img . '</div>'
        . '<div class="testimonial-text">' . do_shortcode($content) . '</div>'
        . '</div>';
}

/** [logo] – logo đối tác trong dải logo. */
function vinasite_sc_logo($atts)
{
    $atts = shortcode_atts(array('img' => '', 'height' => '', 'link' => ''), $atts);
    $h    = $atts['height'] !== '' ? preg_replace('/[^0-9a-z.%]/i', '', $atts['height']) : '84px';
    if (is_numeric($h)) {
        $h .= 'px';
    }
    $img = '';
    if ($atts['img'] !== '') {
        $img = wp_get_attachment_image((int) $atts['img'], 'medium', false, array(
            'class' => 'vs-logo__img',
            'style' => 'height:' . $h . ';width:auto;object-fit:contain',
        ));
    }
    if ($atts['link'] !== '') {
        $img = '<a href="' . esc_url($atts['link']) . '">' . $img . '</a>';
    }
    return '<div class="vs-logo">' . $img . '</div>';
}

/** [blog_posts] – lưới bài viết mới nhất theo chuyên mục. */
function vinasite_sc_blog_posts($atts)
{
    $atts = shortcode_atts(array(
        'cat' => '', 'posts' => '4', 'columns' => '4', 'style' => '',
        'columns__md' => '', 'comments' => '', 'image_height' => '',
        'text_align' => 'left', 'text_bg' => '', 'text_padding' => '', 'excerpt' => 'true',
    ), $atts);

    $q = new WP_Query(array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => max(1, (int) $atts['posts']),
        'cat'                 => (int) $atts['cat'],
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));
    if (!$q->have_posts()) {
        return '';
    }

    $out = '<div class="vs-blog-grid vs-blog-grid--' . max(1, min(6, (int) $atts['columns'])) . '">';
    while ($q->have_posts()) {
        $q->the_post();
        $out .= '<article class="vs-blog-card">'
            . '<a class="vs-blog-card__thumb" href="' . esc_url(get_permalink()) . '">'
            . get_the_post_thumbnail(null, 'vinasite-card', array('loading' => 'lazy'))
            . '</a><div class="vs-blog-card__body">'
            . '<h3 class="vs-blog-card__title"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>'
            . '<p class="vs-blog-card__excerpt">' . esc_html(wp_trim_words(get_the_excerpt(), 18, '…')) . '</p>'
            . '</div></article>';
    }
    wp_reset_postdata();

    return $out . '</div>';
}

/** [text_box] – hộp chữ overlay trong banner (render thành khối nội dung thường). */
function vinasite_sc_text_box($atts, $content = '')
{
    return '<div class="vs-textbox">' . do_shortcode($content) . '</div>';
}

/** [ux_gallery] – dải ảnh cuộn ngang (thư viện hình ảnh). */
function vinasite_sc_ux_gallery($atts)
{
    $atts = shortcode_atts(array('ids' => '', 'type' => '', 'col_spacing' => '', 'image_height' => '', 'image_hover' => '', 'columns' => '4'), $atts);
    $ids  = array_filter(array_map('intval', explode(',', $atts['ids'])));
    if (!$ids) {
        return '';
    }
    $out = '<div class="vs-gallery-strip">';
    foreach ($ids as $id) {
        $full = wp_get_attachment_image_url($id, 'large');
        $out .= '<a class="vs-gallery-strip__item" href="' . esc_url($full) . '" target="_blank" rel="noopener">'
            . wp_get_attachment_image($id, 'vinasite-card', false, array('loading' => 'lazy'))
            . '</a>';
    }
    return $out . '</div>';
}
