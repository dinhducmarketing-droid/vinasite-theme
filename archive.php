<?php
/**
 * Archive (category, tag, …) — blog-style layout: hero banner + post count,
 * category filter chips, search bar, 4-column card grid. header.php opens <main>.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

global $wp_query;
$vs_term  = is_category() || is_tax() ? get_queried_object() : null;
$vs_title = wp_strip_all_tags(single_term_title('', false));
if (!$vs_title) { $vs_title = wp_strip_all_tags(get_the_archive_title()); }
$vs_count = (int) $wp_query->found_posts;
$vs_desc  = term_description();

// Filter chips: children of the current category, else its siblings.
$vs_chips  = array();
$vs_parent_link = '';
if ($vs_term && !is_wp_error($vs_term)) {
    $kids = get_terms(array('taxonomy' => 'category', 'parent' => $vs_term->term_id, 'hide_empty' => true));
    if ((is_wp_error($kids) || empty($kids)) && $vs_term->parent) {
        $kids = get_terms(array('taxonomy' => 'category', 'parent' => $vs_term->parent, 'hide_empty' => true));
        $vs_parent_link = get_category_link($vs_term->parent);
    }
    if (!is_wp_error($kids)) { $vs_chips = $kids; }
}
?>
<section class="vs-blog-hero">
    <div class="dragon-container">
        <nav class="vs-blog-crumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <span>Chuyên mục</span>
            <span aria-hidden="true">/</span>
            <strong><?php echo esc_html($vs_title); ?></strong>
        </nav>
        <div class="vs-blog-hero__grid">
            <div class="vs-blog-hero__main">
                <span class="vs-blog-badge"><?php dragon_the_icon('folder'); ?> Tin tức &amp; kiến thức</span>
                <h1 class="vs-blog-hero__title"><?php echo esc_html($vs_title); ?></h1>
                <p class="vs-blog-hero__desc">
                    <?php
                    if ($vs_desc) {
                        echo esc_html(wp_trim_words(wp_strip_all_tags($vs_desc), 34, '…'));
                    } else {
                        echo 'Cập nhật bài viết, phân tích và hướng dẫn pháp lý chuyên sâu trong chuyên mục <strong>' . esc_html($vs_title) . '</strong>.';
                    }
                    ?>
                </p>
            </div>
            <div class="vs-blog-count">
                <div class="vs-blog-count__n"><?php echo esc_html(number_format_i18n($vs_count)); ?></div>
                <div class="vs-blog-count__l">Bài viết</div>
            </div>
        </div>
    </div>
</section>

<section class="dragon-section vs-blog-body">
    <div class="dragon-container">

        <?php if (!empty($vs_chips)) : ?>
            <div class="vs-blog-chips" role="list" aria-label="Lọc chuyên mục">
                <?php if ($vs_parent_link) : ?>
                    <a class="vs-chip" role="listitem" href="<?php echo esc_url($vs_parent_link); ?>">Tất cả</a>
                <?php endif; ?>
                <?php foreach ($vs_chips as $c) :
                    $active = ($vs_term && $c->term_id === $vs_term->term_id) ? ' is-active' : '';
                    ?>
                    <a class="vs-chip<?php echo $active; ?>" role="listitem" href="<?php echo esc_url(get_category_link($c->term_id)); ?>"><?php echo esc_html($c->name); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="vs-blog-search" method="get" action="<?php echo esc_url(home_url('/')); ?>" role="search">
            <?php
            wp_dropdown_categories(array(
                'name'            => 'cat',
                'selected'        => $vs_term && !is_wp_error($vs_term) ? $vs_term->term_id : 0,
                'show_option_all' => 'Tất cả chuyên mục',
                'hide_empty'      => true,
                'hierarchical'    => true,
                'class'           => 'vs-blog-search__cat',
            ));
            ?>
            <label class="dragon-visually-hidden" for="vs-blog-s">Tìm kiếm</label>
            <input type="search" id="vs-blog-s" name="s" class="vs-blog-search__input" placeholder="Tìm kiếm bài viết trong chuyên mục…" value="<?php echo esc_attr(get_search_query()); ?>"/>
            <button type="submit" class="dragon-btn dragon-btn--primary vs-blog-search__btn"><?php dragon_the_icon('help'); ?>Tìm kiếm</button>
        </form>

        <?php if (have_posts()) : ?>
            <div class="dragon-postgrid vs-blog-grid">
                <?php while (have_posts()) : the_post(); get_template_part('template-parts/content', 'card'); endwhile; ?>
            </div>
            <div class="vs-pagination">
                <?php the_posts_pagination(array('mid_size' => 2, 'prev_text' => '‹', 'next_text' => '›')); ?>
            </div>
        <?php else : ?>
            <p class="vs-empty">Chưa có bài viết trong chuyên mục này.</p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
