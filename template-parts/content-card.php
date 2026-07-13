<?php
/**
 * Reusable post card for listings (blog, archive, search).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
$cats = get_the_category();
?>
<article <?php post_class('dragon-card dragon-postcard vs-card'); ?>>
    <a class="dragon-postcard__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php if (has_post_thumbnail()) {
            the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy'));
        } ?>
    </a>
    <div class="dragon-postcard__body">
        <?php if (!empty($cats)) : ?>
            <a class="dragon-news__cat" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php echo esc_html($cats[0]->name); ?></a>
        <?php endif; ?>
        <h3 class="dragon-postcard__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="vs-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '…')); ?></p>
        <div class="dragon-postcard__meta">
            <span><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
            <span><?php dragon_the_icon('clock'); ?> <?php echo (int) vinasite_reading_time(); ?> phút đọc</span>
        </div>
        <a class="vs-card__more" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">Xem chi tiết <?php dragon_the_icon('arrow-right'); ?></a>
    </div>
</article>
