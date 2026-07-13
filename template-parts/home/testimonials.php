<?php
/**
 * Home – Client testimonials.
 * Per brief: NO fabricated reviews. The section renders only when real, verified
 * testimonials are supplied via the `dragon_testimonials` filter (or a future
 * ACF/CPT source). With no data it stays hidden – the markup/design is ready,
 * but nothing fake is published.
 *
 * To enable, add verified entries in the child theme, e.g.:
 *   add_filter('dragon_testimonials', function () {
 *     return array(
 *       array('quote' => '...', 'name' => 'N.V.A', 'type' => 'Khách hàng cá nhân', 'area' => 'Đất đai'),
 *     );
 *   });
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

$items = apply_filters('dragon_testimonials', array());
if (empty($items) || !is_array($items)) {
    return; // Hidden until verified data exists.
}
$items = array_slice($items, 0, 6);
?>
<section class="dragon-section" id="dragon-testimonials" aria-labelledby="dragon-testi-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Khách hàng nói</span>
            <h2 id="dragon-testi-title">Đánh giá từ khách hàng</h2>
            <p>Phản hồi thực tế từ những khách hàng đã sử dụng dịch vụ pháp lý của Dragon.</p>
        </div>
        <div class="dragon-testi__grid">
            <?php foreach ($items as $t) :
                $name = isset($t['name']) ? $t['name'] : '';
                $initial = $name !== '' ? mb_substr($name, 0, 1, 'UTF-8') : '?';
                ?>
                <figure class="dragon-card dragon-testi__card dragon-reveal">
                    <div class="dragon-testi__stars" aria-hidden="true">
                        <?php for ($s = 0; $s < 5; $s++) { dragon_the_icon('star'); } ?>
                    </div>
                    <blockquote class="dragon-testi__quote">“<?php echo esc_html($t['quote']); ?>”</blockquote>
                    <figcaption class="dragon-testi__author">
                        <span class="dragon-testi__avatar" aria-hidden="true"><?php echo esc_html($initial); ?></span>
                        <span>
                            <span class="dragon-testi__name"><?php echo esc_html($name); ?></span>
                            <span class="dragon-testi__type"><?php echo esc_html(trim(($t['type'] ?? '') . (isset($t['area']) ? ' · ' . $t['area'] : ''), ' ·')); ?></span>
                        </span>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
