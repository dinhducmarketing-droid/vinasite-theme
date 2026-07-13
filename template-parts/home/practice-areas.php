<?php
/**
 * Home – Practice areas (8 cards, data-driven from dragon_practice_areas()).
 * Whole card clickable via stretched-link overlay; sub-links stay independently
 * clickable (higher z-index) so accessibility is preserved.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$areas = dragon_practice_areas();
?>
<section class="dragon-section dragon-section--soft" id="dragon-practice" aria-labelledby="dragon-practice-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Lĩnh vực hành nghề</span>
            <h2 id="dragon-practice-title">Giải pháp pháp lý cho mọi nhu cầu</h2>
            <p>Đội ngũ luật sư của Dragon tư vấn và tranh tụng trên các lĩnh vực trọng tâm dưới đây.</p>
        </div>
        <div class="dragon-practice__grid">
            <?php foreach ($areas as $a) : ?>
                <article class="dragon-card dragon-practice__card dragon-reveal">
                    <span class="dragon-ico-chip"><?php dragon_the_icon($a['icon']); ?></span>
                    <h3 class="dragon-practice__title"><a href="<?php echo esc_url($a['url']); ?>"><?php echo esc_html($a['title']); ?></a></h3>
                    <p class="dragon-practice__desc"><?php echo esc_html($a['desc']); ?></p>
                    <?php if (!empty($a['subs'])) : ?>
                        <ul class="dragon-practice__subs">
                            <?php foreach ($a['subs'] as $sub) : ?>
                                <li><a href="<?php echo esc_url($sub[1]); ?>"><?php echo esc_html($sub[0]); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <span class="dragon-practice__more">Xem chi tiết <?php dragon_the_icon('arrow-right'); ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
