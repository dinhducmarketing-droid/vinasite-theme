<?php
/**
 * Home – FAQ accordion (accessible; works without JS).
 * FAQPage schema is emitted from inc/dragon/schema.php ONLY because these Q&As
 * are actually rendered here.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$faqs = dragon_faq_items();
?>
<section class="dragon-section" id="dragon-faq" aria-labelledby="dragon-faq-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Giải đáp</span>
            <h2 id="dragon-faq-title">Câu hỏi thường gặp</h2>
            <p>Những thắc mắc phổ biến khi lựa chọn và làm việc với luật sư.</p>
        </div>
        <div class="dragon-faq">
            <?php foreach ($faqs as $i => $f) :
                $qid = 'dragon-faq-q-' . $i;
                $aid = 'dragon-faq-a-' . $i;
                ?>
                <div class="dragon-faq__item">
                    <h3 style="margin:0;">
                        <button class="dragon-faq__q" type="button" id="<?php echo esc_attr($qid); ?>"
                                aria-expanded="false" aria-controls="<?php echo esc_attr($aid); ?>">
                            <span class="dragon-faq__ico"><?php dragon_the_icon(isset($f['icon']) ? $f['icon'] : 'help'); ?></span>
                            <span class="dragon-faq__qtext"><?php echo esc_html($f['q']); ?></span>
                            <?php dragon_the_icon('chevron-down'); ?>
                        </button>
                    </h3>
                    <div class="dragon-faq__a" id="<?php echo esc_attr($aid); ?>" role="region" aria-labelledby="<?php echo esc_attr($qid); ?>" hidden>
                        <div><?php echo esc_html($f['a']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
