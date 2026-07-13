<?php
/**
 * Home – Featured showcase band (firm-owned brand image).
 * A single, tasteful full-width image that reinforces credibility. Uses a
 * Media-Library photo the firm owns; admin-editable via Customizer
 * (dragon_featured_img). Renders nothing if no image is set.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$img = dragon_opt('featured_img');
if (!$img) {
    return;
}
?>
<section class="dragon-section dragon-featured" aria-label="Hình ảnh hoạt động Luật Dragon">
    <div class="dragon-container">
        <figure class="dragon-featured__frame dragon-reveal">
            <img src="<?php echo esc_url($img); ?>" width="1200" height="670" alt="Luật sư Công ty Luật TNHH Dragon" loading="lazy" decoding="async"/>
        </figure>
    </div>
</section>
