<?php
/**
 * FAQ – nguồn chung cho accordion và schema FAQPage.
 *
 * Theme cha để TRỐNG (generic). Child theme theo ngành bơm dữ liệu qua filter
 * 'dragon_faq_items'. Site không có child → mảng rỗng, khối FAQ tự ẩn.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}

function dragon_faq_items()
{
    return apply_filters('dragon_faq_items', array());
}
