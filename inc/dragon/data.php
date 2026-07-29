<?php
/**
 * FAQ – nguồn chung cho accordion và schema FAQPage.
 *
 * Theme cha để TRỐNG (generic). Child theme theo ngành bơm dữ liệu qua filter
 * 'vinasite_faq_items'. Site không có child → mảng rỗng, khối FAQ tự ẩn.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

function vinasite_faq_items()
{
    $data = apply_filters('vinasite_faq_items', array());
    return apply_filters('dragon_faq_items', $data); // compat: child theme cũ hook tên dragon_
}
