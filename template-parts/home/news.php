<?php
/**
 * Home – News & updates (company activity, announcements, events).
 * Feature + 4 mini layout. Uses "activity/announcement" categories and records
 * shown IDs in $GLOBALS['dragon_shown_posts'] so the Legal Knowledge section
 * below never repeats the same article.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

$GLOBALS['dragon_shown_posts'] = isset($GLOBALS['dragon_shown_posts']) ? $GLOBALS['dragon_shown_posts'] : array();

$news = new WP_Query(array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 6, // 1 bài nổi bật + 5 tin bên cạnh
    'ignore_sticky_posts' => false,
    'no_found_rows'       => true,
    'post__not_in'        => array_map('intval', $GLOBALS['dragon_shown_posts']),
    'category_name'       => 'hoat-dong-luat-su,thong-bao,su-kien,chinh-tri-va-xa-hoi,ban-tin-noi-bo',
));

if ($news->have_posts()) : ?>
<section class="dragon-section" id="dragon-news" aria-labelledby="dragon-news-title">
    <div class="dragon-container">
        <div class="dragon-section-head dragon-section-head--left" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;max-width:none;">
            <div>
                <span class="dragon-eyebrow">Cập nhật</span>
                <h2 id="dragon-news-title">Tin tức và thông tin mới</h2>
                <p>Hoạt động của Luật Dragon, thông báo và tin pháp luật mới nhất.</p>
            </div>
            <a class="dragon-btn dragon-btn--outline" href="https://vanphongluatsu.com.vn/tin-tuc-su-kien/">Xem tất cả tin tức <?php dragon_the_icon('arrow-right'); ?></a>
        </div>

        <div class="dragon-news__layout">
            <?php
            $news->the_post();
            $GLOBALS['dragon_shown_posts'][] = get_the_ID();
            $cats = get_the_category();
            ?>
            <article class="dragon-card dragon-news__feature dragon-reveal">
                <a class="dragon-news__feature-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy', 'width' => 640, 'height' => 360));
                    } ?>
                </a>
                <div class="dragon-news__feature-body">
                    <?php if (!empty($cats)) : ?><span class="dragon-news__cat"><?php echo esc_html($cats[0]->name); ?></span><?php endif; ?>
                    <h3 class="dragon-news__feature-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="dragon-news__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 32, '…')); ?></p>
                    <div class="dragon-news__meta">
                        <span><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
                        <span><?php dragon_the_icon('user-tie'); ?> Ban biên tập Luật Dragon</span>
                    </div>
                </div>
            </article>

            <div class="dragon-news__side">
                <?php while ($news->have_posts()) : $news->the_post();
                    $GLOBALS['dragon_shown_posts'][] = get_the_ID();
                    $mcats = get_the_category();
                    ?>
                    <article class="dragon-news__mini dragon-reveal">
                        <a class="dragon-news__mini-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('medium', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy', 'width' => 92, 'height' => 68));
                            } ?>
                        </a>
                        <div>
                            <h3 class="dragon-news__mini-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), 14, '…')); ?></a></h3>
                            <div class="dragon-news__mini-meta"><?php echo !empty($mcats) ? esc_html($mcats[0]->name) . ' · ' : ''; ?><?php echo esc_html(get_the_date()); ?></div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php endif;
wp_reset_postdata();
