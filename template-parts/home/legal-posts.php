<?php
/**
 * Home – Legal knowledge & updates (analysis, guidance, in-depth advice).
 *
 * The category chips are interactive TABS: we fetch a few latest posts per topic
 * (so every tab is guaranteed content), merge + de-dupe, and render them all
 * newest-first. Each card carries its category slugs in data-cats; dragon.js
 * filters the grid client-side when a tab is clicked. A <noscript> fallback keeps
 * real category links for crawlers / no-JS users.
 *
 * Slugs below are the SITE'S REAL category slugs (verified via wp term list) —
 * do not guess them; a wrong slug makes a tab filter to empty.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

$exclude = isset($GLOBALS['dragon_shown_posts']) ? array_map('intval', $GLOBALS['dragon_shown_posts']) : array();

// [label, real LEAF category slug]. Six concrete practice areas, each with many
// posts directly assigned. NB: use leaf slugs, not parent categories like
// "luat-su-tu-van" — posts sit in the children, so a parent slug filters to empty.
$chips = array(
    array('Hình sự', 'tu-van-hinh-su'),
    array('Dân sự', 'tu-van-dan-su'),
    array('Đất đai', 'luat-su-dat-dai'),
    array('Doanh nghiệp', 'tu-van-doanh-nghiep'),
    array('Hôn nhân & gia đình', 'tu-van-hon-nhan'),
    array('Hành chính', 'hanh-chinh'),
);

// Gather up to N latest posts per topic (de-duped across topics + against posts
// already shown earlier on the page), so each tab has cards to reveal.
$per_topic = 3;
$seen      = $exclude;
$ids       = array();
foreach ($chips as $c) {
    $topic_ids = get_posts(array(
        'category_name'       => $c[1],
        'posts_per_page'      => $per_topic,
        'post__not_in'        => $seen,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
        'fields'              => 'ids',
        'no_found_rows'       => true,
    ));
    foreach ($topic_ids as $id) {
        $seen[] = $id;
        $ids[]  = $id;
    }
}

if (!empty($ids)) :
    $posts = new WP_Query(array(
        'post__in'            => $ids,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'posts_per_page'      => count($ids),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));
    ?>
<section class="dragon-section dragon-section--soft" id="dragon-legal" aria-labelledby="dragon-legal-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Kiến thức pháp lý</span>
            <h2 id="dragon-legal-title">Kiến thức và cập nhật pháp luật</h2>
            <p>Phân tích, giải đáp và hướng dẫn chuyên sâu từ đội ngũ luật sư Dragon.</p>
        </div>

        <div class="dragon-tabs" role="tablist" aria-label="Chủ đề pháp lý">
            <button class="dragon-tab" type="button" role="tab" data-filter="*" aria-selected="true">Tất cả</button>
            <?php foreach ($chips as $c) : ?>
                <button class="dragon-tab" type="button" role="tab" data-filter="<?php echo esc_attr($c[1]); ?>" aria-selected="false"><?php echo esc_html($c[0]); ?></button>
            <?php endforeach; ?>
        </div>
        <noscript>
            <div class="dragon-tabs" aria-label="Chủ đề pháp lý">
                <?php foreach ($chips as $c) :
                    $term = get_category_by_slug($c[1]);
                    $url  = $term ? get_category_link($term) : home_url('/');
                    ?>
                    <a class="dragon-tab" href="<?php echo esc_url($url); ?>"><?php echo esc_html($c[0]); ?></a>
                <?php endforeach; ?>
            </div>
        </noscript>

        <div class="dragon-postgrid" id="dragon-legal-grid">
            <?php while ($posts->have_posts()) : $posts->the_post();
                $GLOBALS['dragon_shown_posts'][] = get_the_ID();
                $pcats = get_the_category();
                $slugs = $pcats ? implode(' ', wp_list_pluck($pcats, 'slug')) : '';
                ?>
                <article class="dragon-card dragon-postcard dragon-reveal" data-cats="<?php echo esc_attr($slugs); ?>">
                    <a class="dragon-postcard__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy', 'width' => 400, 'height' => 250));
                        } ?>
                    </a>
                    <div class="dragon-postcard__body">
                        <?php if (!empty($pcats)) : ?><span class="dragon-news__cat"><?php echo esc_html($pcats[0]->name); ?></span><?php endif; ?>
                        <h3 class="dragon-postcard__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="dragon-postcard__meta">
                            <span><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
            <p class="dragon-legal__empty" id="dragon-legal-empty" hidden>Chưa có bài viết thuộc chủ đề này. Vui lòng chọn chủ đề khác.</p>
        </div>

        <div class="dragon-news__foot">
            <a class="dragon-btn dragon-btn--primary" href="https://vanphongluatsu.com.vn/dich-vu-luat-su/">Xem tất cả bài viết <?php dragon_the_icon('arrow-right'); ?></a>
        </div>
    </div>
</section>
<?php
    wp_reset_postdata();
endif;
