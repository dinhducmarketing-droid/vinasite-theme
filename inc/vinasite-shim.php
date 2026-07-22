<?php
/**
 * VinaSite – compatibility shim for legacy page-builder shortcodes.
 *
 * The site has a handful of pages authored with Flatsome's UX Builder
 * shortcodes ([section][row][col][ux_*] …) plus one custom [ntg_page_title].
 * When VinaSite is active (Flatsome/ntgsite gone) these shortcodes would print
 * as raw text. This shim renders them as clean, responsive HTML using the
 * Dragon design system so those pages keep working.
 *
 * Only shortcodes actually used by the live pages are implemented. It does NOT
 * try to reproduce Flatsome pixel-for-pixel — it produces readable, on-brand
 * layout. Registered late (prio 20) and only if the real handlers are absent,
 * so it never conflicts when Flatsome IS active.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'vinasite_register_shim', 20);
function vinasite_register_shim()
{
    $map = array(
        'section'        => 'vinasite_sc_section',
        'row'            => 'vinasite_sc_row',
        'row_inner'      => 'vinasite_sc_row',
        'col'            => 'vinasite_sc_col',
        'col_inner'      => 'vinasite_sc_col',
        'ux_image'       => 'vinasite_sc_ux_image',
        'ux_image_box'   => 'vinasite_sc_ux_image_box',
        'ux_banner'      => 'vinasite_sc_section',
        'ux_text'        => 'vinasite_sc_ux_text',
        'ux_stack'       => 'vinasite_sc_ux_stack',
        'gap'            => 'vinasite_sc_gap',
        'divider'        => 'vinasite_sc_divider',
        'button'         => 'vinasite_sc_button',
        'accordion'      => 'vinasite_sc_accordion',
        'accordion-item' => 'vinasite_sc_accordion_item',
        'title'          => 'vinasite_sc_title',
        'ntg_page_title' => 'vinasite_sc_page_title',
        // WPBakery (Visual Composer) leftovers.
        'vc_row'            => 'vinasite_sc_row',
        'vc_row_inner'      => 'vinasite_sc_row',
        'vc_column'         => 'vinasite_sc_vc_column',
        'vc_column_inner'   => 'vinasite_sc_vc_column',
        'vc_column_text'    => 'vinasite_sc_ux_text',
        'vc_custom_heading' => 'vinasite_sc_vc_heading',
        'vc_empty_space'    => 'vinasite_sc_gap',
        'vc_separator'      => 'vinasite_sc_divider',
        'vc_tta_tabs'       => 'vinasite_sc_vc_tabs',
        'vc_tta_accordion'  => 'vinasite_sc_vc_tabs',
        'vc_tta_section'    => 'vinasite_sc_vc_tta_section',
        'vc_single_image'   => 'vinasite_sc_vc_single_image',
        'vc_text_separator' => 'vinasite_sc_vc_text_separator',
        'vc_progress_bar'   => 'vinasite_sc_vc_progress_bar',
        'vc_btn'            => 'vinasite_sc_vc_btn',
        'vc_video'          => 'vinasite_sc_strip',
        // Elfsight widgets (plugin removed) → real call button / strip.
        'elfsight_click_to_call' => 'vinasite_sc_elfsight_call',
        'elfsight_pricing_table' => 'vinasite_sc_strip',
        // Other builder leftovers on legacy pages → strip so nothing shows raw.
        'ultimate_heading' => 'vinasite_sc_title', 'ult_createlink' => 'vinasite_sc_strip',
        'info_list' => 'vinasite_sc_strip', 'info_list_item' => 'vinasite_sc_strip',
        'bsf-info-box' => 'vinasite_sc_strip', 'dt_fancy_image' => 'vinasite_sc_strip',
        'dt_vc_list' => 'vinasite_sc_strip', 'dt_testimonials_carousel' => 'vinasite_sc_strip',
        'dt_team_masonry' => 'vinasite_sc_strip', 'rev_slider' => 'vinasite_sc_strip',
        'td_block_image_box' => 'vinasite_sc_strip', 'td_block_text_with_title' => 'vinasite_sc_strip',
        // Newspaper (tagDiv) leftovers.
        'td_block_7'             => 'vinasite_sc_td_block',
        'td_block_2'             => 'vinasite_sc_td_block',
        'td_block_video_youtube' => 'vinasite_sc_td_youtube',
        // Go Pricing (data lost with the uninstalled plugin) → contact fallback.
        'go_pricing'        => 'vinasite_sc_go_pricing',
    );
    foreach ($map as $tag => $cb) {
        if (!shortcode_exists($tag)) {
            add_shortcode($tag, $cb);
        }
    }
}

/** Turn a Flatsome span value + visibility into CSS classes. */
function vinasite_vis_class($atts)
{
    $c = '';
    if (!empty($atts['visibility'])) {
        if (strpos($atts['visibility'], 'hide-for-small') !== false) { $c .= ' vs-hide-small'; }
        if (strpos($atts['visibility'], 'show-for-small') !== false) { $c .= ' vs-show-small'; }
    }
    return $c;
}

function vinasite_sc_section($atts, $content = '')
{
    // Hỗ trợ thêm class/id/padding: các site di cư từ Flatsome đặt class riêng
    // lên [section] để CSS của họ bám vào. Thiếu thì layout trang chủ của họ vỡ.
    $atts = shortcode_atts(array('bg_color' => '', 'dark' => '', 'padding' => '', 'padding__sm' => '', 'visibility' => '', 'label' => '', 'class' => '', 'id' => ''), $atts);
    $style = '';
    if ($atts['bg_color']) { $style .= 'background-color:' . esc_attr($atts['bg_color']) . ';'; }
    if ($atts['padding'] !== '') {
        $pad = preg_replace('/[^0-9.]/', '', $atts['padding']);
        if ($pad !== '') { $style .= 'padding-top:' . $pad . 'px;padding-bottom:' . $pad . 'px;'; }
    }
    $cls = 'vs-ux-section' . vinasite_vis_class($atts) . ($atts['dark'] ? ' vs-ux-dark' : '');
    if ($atts['class']) { $cls .= ' ' . $atts['class']; }
    $id_attr = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';
    return '<section class="' . esc_attr($cls) . '"' . $id_attr . ($style ? ' style="' . $style . '"' : '') . '><div class="dragon-container">' . do_shortcode($content) . '</div></section>';
}

function vinasite_sc_row($atts, $content = '')
{
    $atts = shortcode_atts(array('visibility' => '', 'label' => '', 'v_align' => '', 'h_align' => ''), $atts);
    $cls = 'vs-ux-row' . vinasite_vis_class($atts);
    if ($atts['h_align'] === 'center') { $cls .= ' vs-ux-row--center'; }
    return '<div class="' . esc_attr($cls) . '">' . do_shortcode($content) . '</div>';
}

function vinasite_sc_col($atts, $content = '')
{
    $atts = shortcode_atts(array('span' => '12', 'span__sm' => '12', 'visibility' => '', 'align' => '', 'padding' => '', 'label' => ''), $atts);
    $span = max(1, min(12, (int) $atts['span']));
    $cls  = 'vs-ux-col' . vinasite_vis_class($atts);
    $style = '--vs-span:' . $span . ';';
    if ($atts['align']) { $style .= 'text-align:' . esc_attr($atts['align']) . ';'; }
    return '<div class="' . esc_attr($cls) . '" style="' . $style . '">' . do_shortcode($content) . '</div>';
}

function vinasite_sc_ux_image($atts)
{
    $atts = shortcode_atts(array('id' => '', 'image_size' => 'large', 'width' => '', 'link' => ''), $atts);
    if (!$atts['id']) { return ''; }
    $img = wp_get_attachment_image((int) $atts['id'], $atts['image_size'] ?: 'large', false, array('class' => 'vs-ux-image', 'loading' => 'lazy'));
    if ($atts['link']) {
        $img = '<a href="' . esc_url($atts['link']) . '">' . $img . '</a>';
    }
    return '<figure class="vs-ux-image-wrap">' . $img . '</figure>';
}

function vinasite_sc_ux_image_box($atts, $content = '')
{
    $atts = shortcode_atts(array('img' => '', 'image_size' => 'medium', 'link' => '', 'text_align' => 'center'), $atts);
    $img = $atts['img'] ? wp_get_attachment_image((int) $atts['img'], $atts['image_size'] ?: 'medium', false, array('class' => 'vs-ux-box__img', 'loading' => 'lazy')) : '';
    $inner = '<div class="vs-ux-box__img-wrap">' . $img . '</div><div class="vs-ux-box__text">' . do_shortcode($content) . '</div>';
    if ($atts['link']) {
        $inner = '<a class="vs-ux-box__link" href="' . esc_url($atts['link']) . '">' . $inner . '</a>';
    }
    return '<div class="vs-ux-box" style="text-align:' . esc_attr($atts['text_align']) . '">' . $inner . '</div>';
}

function vinasite_sc_ux_text($atts, $content = '')
{
    return '<div class="vs-ux-text">' . do_shortcode($content) . '</div>';
}

function vinasite_sc_ux_stack($atts, $content = '')
{
    $atts = shortcode_atts(array('direction' => 'row', 'distribute' => ''), $atts);
    $cls = 'vs-ux-stack vs-ux-stack--' . ($atts['direction'] === 'column' ? 'col' : 'row');
    return '<div class="' . esc_attr($cls) . '">' . do_shortcode($content) . '</div>';
}

function vinasite_sc_gap($atts)
{
    $atts = shortcode_atts(array('height' => '30px', 'visibility' => ''), $atts);
    $h = preg_replace('/[^0-9a-z%.]/i', '', $atts['height']);
    return '<div class="vs-ux-gap' . vinasite_vis_class($atts) . '" style="height:' . esc_attr($h ?: '30px') . '" aria-hidden="true"></div>';
}

function vinasite_sc_divider($atts)
{
    return '<hr class="vs-ux-divider"/>';
}

function vinasite_sc_button($atts, $content = '')
{
    $atts = shortcode_atts(array('text' => '', 'link' => '#', 'color' => 'primary', 'size' => '', 'expand' => '', 'target' => ''), $atts);
    $variant = 'dragon-btn--primary';
    if (in_array($atts['color'], array('white', 'secondary'), true)) { $variant = 'dragon-btn--outline'; }
    if ($atts['color'] === 'alert' || $atts['color'] === 'success') { $variant = 'dragon-btn--lotus'; }
    $block = ($atts['expand'] === 'true' || $atts['expand'] === '1') ? ' dragon-btn--block' : '';
    $label = $atts['text'] !== '' ? $atts['text'] : wp_strip_all_tags($content);
    $tgt   = $atts['target'] === '_blank' ? ' target="_blank" rel="noopener"' : '';
    return '<a class="dragon-btn ' . esc_attr($variant . $block) . '" href="' . esc_url($atts['link']) . '"' . $tgt . '>' . esc_html($label) . '</a>';
}

function vinasite_sc_title($atts, $content = '')
{
    $atts = shortcode_atts(array('text' => '', 'tag_name' => 'h2', 'style' => ''), $atts);
    $tag = in_array($atts['tag_name'], array('h1', 'h2', 'h3', 'h4'), true) ? $atts['tag_name'] : 'h2';
    $text = $atts['text'] !== '' ? $atts['text'] : $content;
    return '<' . $tag . ' class="vs-ux-title">' . wp_kses_post($text) . '</' . $tag . '>';
}

/* Accordion → native <details> (accessible, works without JS). */
function vinasite_sc_accordion($atts, $content = '')
{
    return '<div class="vs-accordion">' . do_shortcode($content) . '</div>';
}
function vinasite_sc_accordion_item($atts, $content = '')
{
    $atts = shortcode_atts(array('title' => 'Chi tiết'), $atts);
    return '<details class="vs-accordion__item"><summary class="vs-accordion__q">' . esc_html($atts['title']) . '</summary><div class="vs-accordion__a">' . do_shortcode($content) . '</div></details>';
}

/* ---- WPBakery (vc_*) ---- */
function vinasite_sc_vc_column($atts, $content = '')
{
    $atts = shortcode_atts(array('width' => '1/1'), $atts);
    $map  = array('1/6' => 2, '1/5' => 2, '1/4' => 3, '1/3' => 4, '2/5' => 5, '1/2' => 6, '3/5' => 7, '2/3' => 8, '3/4' => 9, '5/6' => 10, '1/1' => 12, '1' => 12);
    $span = isset($map[$atts['width']]) ? $map[$atts['width']] : 12;
    return '<div class="vs-ux-col" style="--vs-span:' . $span . '">' . do_shortcode($content) . '</div>';
}
function vinasite_sc_vc_heading($atts, $content = '')
{
    $atts = shortcode_atts(array('text' => '', 'font_container' => ''), $atts);
    $tag = 'h2';
    if (preg_match('/tag:(h[1-4])/', $atts['font_container'], $m)) { $tag = $m[1]; }
    $align = '';
    if (preg_match('/text_align:(left|center|right)/', $atts['font_container'], $m)) { $align = 'text-align:' . $m[1] . ';'; }
    return '<' . $tag . ' class="vs-ux-title" style="' . $align . '">' . wp_kses_post($atts['text']) . '</' . $tag . '>';
}
function vinasite_sc_vc_tabs($atts, $content = '')
{
    return '<div class="vs-accordion vs-tabs">' . do_shortcode($content) . '</div>';
}
function vinasite_sc_vc_tta_section($atts, $content = '')
{
    $atts = shortcode_atts(array('title' => 'Mục'), $atts);
    return '<details class="vs-accordion__item"><summary class="vs-accordion__q">' . esc_html($atts['title']) . '</summary><div class="vs-accordion__a">' . do_shortcode($content) . '</div></details>';
}

/* ---- Newspaper (td_*) ---- */
function vinasite_sc_td_block($atts, $content = '')
{
    $atts = shortcode_atts(array('category_id' => '', 'custom_title' => '', 'limit' => 8), $atts);
    $out = '';
    if ($atts['custom_title']) {
        $out .= '<h3 class="vs-widget__title">' . esc_html($atts['custom_title']) . '</h3>';
    }
    $cat = (int) $atts['category_id'];
    // The old category IDs were lost in migration; render only if the term still exists.
    if ($cat && get_term($cat, 'category') && !is_wp_error(get_term($cat, 'category'))) {
        $q = new WP_Query(array('cat' => $cat, 'posts_per_page' => (int) $atts['limit'], 'no_found_rows' => true, 'ignore_sticky_posts' => true));
        if ($q->have_posts()) {
            $out .= '<ul class="vs-related">';
            while ($q->have_posts()) { $q->the_post(); $out .= '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>'; }
            $out .= '</ul>';
            wp_reset_postdata();
            return $out;
        }
        wp_reset_postdata();
    }
    // No data available.
    return $out ? $out . '<p class="vs-muted">Đang cập nhật tài liệu.</p>' : '';
}
function vinasite_sc_td_youtube($atts)
{
    $atts = shortcode_atts(array('playlist_yt' => '', 'yt' => ''), $atts);
    $ids  = array_filter(array_map('trim', explode(',', $atts['playlist_yt'] ?: $atts['yt'])));
    if (empty($ids)) { return ''; }
    $first = preg_replace('/[^A-Za-z0-9_\-]/', '', $ids[0]);
    if (!$first) { return ''; }
    return '<div class="vs-video"><iframe loading="lazy" src="https://www.youtube-nocookie.com/embed/' . esc_attr($first) . '" title="Video" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
}

/* ---- Go Pricing (data lost) → contact fallback ---- */
function vinasite_sc_go_pricing($atts)
{
    $phone = function_exists('dragon_opt') ? dragon_opt('phone') : '';
    $tel   = function_exists('dragon_tel') ? dragon_tel('phone') : preg_replace('/[^0-9]/', '', $phone);
    return '<div class="vs-pricing-cta dragon-card">'
        . '<h3>Nhận báo giá dịch vụ chi tiết</h3>'
        . '<p>Mức phí được xác định theo quy mô và yêu cầu cụ thể của từng hồ sơ. Vui lòng liên hệ để nhận báo giá chính xác và tư vấn miễn phí.</p>'
        . '<div class="vs-pricing-cta__actions">'
        . '<a class="dragon-btn dragon-btn--primary" href="tel:' . esc_attr($tel) . '">Gọi ' . esc_html($phone) . '</a>'
        . '<a class="dragon-btn dragon-btn--outline" href="' . esc_url(home_url('/#dragon-consultation')) . '">Đăng ký tư vấn</a>'
        . '</div></div>';
}

/* Page title banner (ports ntgsite's [ntg_page_title]).
 *
 * Renders NOTHING on purpose: page.php (the VinaSite page template) already
 * outputs a hero with the page title + breadcrumb for every page, so any legacy
 * [ntg_page_title] left in a page's content is a duplicate banner. Returning ''
 * removes that duplicate from all such pages without editing each one's content.
 * To restore the old banner, re-add the markup below. */
function vinasite_sc_page_title($atts)
{
    return '';
}

/* ---- Extra WPBakery / Elfsight / builder leftovers (clean up raw shortcodes) ---- */

/** Generic "hide this leftover shortcode" handler. */
function vinasite_sc_strip($atts = array(), $content = '')
{
    return '';
}

/** [elfsight_click_to_call] (widget plugin removed) → a real call button. */
function vinasite_sc_elfsight_call($atts = array())
{
    $phone = function_exists('dragon_opt') ? dragon_opt('phone') : '';
    $tel   = preg_replace('/[^0-9+]/', '', $phone);
    if (!$tel) {
        return '';
    }
    return '<p class="vs-vc-call"><a class="dragon-btn dragon-btn--primary" href="tel:' . esc_attr($tel) . '">'
        . '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:6px"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1 16 16 0 0 1-15-15 1 1 0 0 1 1-1Z"/></svg>'
        . 'Gọi ngay ' . esc_html($phone) . '</a></p>';
}

/** [vc_single_image image="ID" img_size="..." alignment="..."] → the image. */
function vinasite_sc_vc_single_image($atts = array())
{
    $atts = shortcode_atts(array('image' => '', 'img_size' => 'medium', 'alignment' => 'center'), $atts);
    $id   = (int) $atts['image'];
    if (!$id) {
        return '';
    }
    $size = in_array($atts['img_size'], array('thumbnail', 'medium', 'medium_large', 'large', 'full'), true) ? $atts['img_size'] : 'medium';
    $img  = wp_get_attachment_image($id, $size, false, array('class' => 'vs-vc-img', 'loading' => 'lazy', 'decoding' => 'async'));
    if (!$img) {
        return '';
    }
    $align = $atts['alignment'] === 'center' ? 'text-align:center;' : ($atts['alignment'] === 'right' ? 'text-align:right;' : '');
    return '<figure class="vs-vc-single-image" style="margin:1.2rem 0;' . $align . '">' . $img . '</figure>';
}

/** [vc_text_separator title="..."] → a centred section heading. */
function vinasite_sc_vc_text_separator($atts = array())
{
    $atts = shortcode_atts(array('title' => ''), $atts);
    if (trim($atts['title']) === '') {
        return '<hr style="border:0;border-top:2px solid var(--dragon-border);margin:1.4rem 0;"/>';
    }
    return '<h3 class="vs-vc-separator" style="text-align:center;margin:1.6rem 0 .9rem;color:var(--dragon-primary);font-size:1.05rem;letter-spacing:.03em;">' . esc_html($atts['title']) . '</h3>';
}

/** [vc_progress_bar values="url-encoded JSON"] → simple skill bars. */
function vinasite_sc_vc_progress_bar($atts = array())
{
    $atts = shortcode_atts(array('values' => ''), $atts);
    $raw  = html_entity_decode((string) $atts['values'], ENT_QUOTES, 'UTF-8');
    $data = json_decode(urldecode($raw), true);
    if (!is_array($data)) {
        return '';
    }
    $out = '<div class="vs-vc-skills" style="margin:1rem 0;max-width:520px;">';
    foreach ($data as $item) {
        if (empty($item['label'])) {
            continue;
        }
        $label = $item['label'];
        $val   = isset($item['value']) ? max(0, min(100, (int) $item['value'])) : 0;
        $out  .= '<div style="margin-bottom:.7rem;">'
            . '<div style="display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:.25rem;color:var(--dragon-secondary);"><span>' . esc_html($label) . '</span><span>' . $val . '%</span></div>'
            . '<div style="height:8px;background:var(--dragon-bg-soft);border-radius:4px;overflow:hidden;"><div style="height:100%;width:' . $val . '%;background:var(--dragon-accent);border-radius:4px;"></div></div>'
            . '</div>';
    }
    return $out . '</div>';
}

/** [vc_btn title="..." link="url:...|..."] → a button. */
function vinasite_sc_vc_btn($atts = array())
{
    $atts = shortcode_atts(array('title' => '', 'link' => ''), $atts);
    if (trim($atts['title']) === '') {
        return '';
    }
    $url = home_url('/');
    if ($atts['link'] && preg_match('/url:([^|]+)/', $atts['link'], $m)) {
        $url = urldecode($m[1]);
    }
    return '<a class="dragon-btn dragon-btn--outline" href="' . esc_url($url) . '" style="margin:.6rem 0;">' . esc_html($atts['title']) . '</a>';
}
