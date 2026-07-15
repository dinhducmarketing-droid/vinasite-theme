<?php
/**
 * Single post — blog-style layout: gradient hero (breadcrumb + category badge +
 * title + meta chips) and a 2-column body (content + sidebar with search and
 * recent posts). header.php opens <main>.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
while (have_posts()) : the_post();
    $cats = get_the_category();
    ?>
    <article <?php post_class('dragon-scope vs-single'); ?>>

        <header class="vs-single__hero">
            <div class="dragon-container">
                <nav class="vs-blog-crumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                    <span aria-hidden="true">/</span>
                    <?php if (!empty($cats)) : ?>
                        <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php echo esc_html($cats[0]->name); ?></a>
                        <span aria-hidden="true">/</span>
                    <?php endif; ?>
                    <strong><?php echo esc_html(wp_trim_words(get_the_title(), 9, '…')); ?></strong>
                </nav>
                <?php if (!empty($cats)) : ?>
                    <a class="vs-blog-badge" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php dragon_the_icon('folder'); ?> <?php echo esc_html($cats[0]->name); ?></a>
                <?php endif; ?>
                <h1 class="vs-single__title"><?php the_title(); ?></h1>
                <div class="vs-single__meta">
                    <span><?php dragon_the_icon('user-tie'); ?> <?php the_author(); ?></span>
                    <span><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
                    <span><?php dragon_the_icon('clock'); ?> <?php echo (int) vinasite_reading_time(); ?> phút đọc</span>
                    <?php if (get_the_modified_date() !== get_the_date()) : ?>
                        <span><?php dragon_the_icon('check'); ?> Cập nhật <?php echo esc_html(get_the_modified_date()); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <div class="dragon-container vs-single__wrap">
            <div class="vs-single__content">
                <?php if (has_post_thumbnail()) : ?>
                    <figure class="vs-single__thumb"><?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?></figure>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(array('before' => '<div class="vs-linkpages">', 'after' => '</div>')); ?>
                </div>

                <?php if (has_tag()) : ?>
                    <div class="vs-tags"><?php the_tags('', '', ''); ?></div>
                <?php endif; ?>

                <div class="vs-single__cta dragon-card">
                    <div>
                        <strong>Cần tư vấn thêm về nội dung này?</strong>
                        <p><?php echo esc_html(dragon_opt('company_short') !== '' ? dragon_opt('company_short') : 'Chúng tôi'); ?> tiếp nhận và tư vấn nhanh chóng, bảo mật.</p>
                    </div>
                    <div class="vs-single__cta-actions">
                        <a class="dragon-btn dragon-btn--primary" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?>Gọi <?php echo esc_html(dragon_opt('phone')); ?></a>
                        <a class="dragon-btn dragon-btn--outline" href="<?php echo esc_url(home_url('/#dragon-consultation')); ?>">Đặt lịch tư vấn</a>
                    </div>
                </div>

                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>

            <aside class="vs-single__side">
                <!-- Search -->
                <div class="vs-widget">
                    <h3 class="vs-widget__title">Tìm kiếm bài viết</h3>
                    <form class="vs-side-search" method="get" action="<?php echo esc_url(home_url('/')); ?>" role="search">
                        <input type="search" name="s" class="vs-side-search__input" placeholder="Nhập từ khoá bài viết…" value="<?php echo esc_attr(get_search_query()); ?>" aria-label="Tìm kiếm"/>
                        <button type="submit" class="vs-side-search__btn" aria-label="Tìm"><?php dragon_the_icon('help'); ?></button>
                    </form>
                </div>

                <!-- Recent posts -->
                <?php
                $recent = new WP_Query(array(
                    'posts_per_page'      => 10,
                    'post__not_in'        => array(get_the_ID()),
                    'ignore_sticky_posts' => true,
                    'no_found_rows'       => true,
                ));
                if ($recent->have_posts()) : ?>
                    <div class="vs-widget">
                        <h3 class="vs-widget__title">Bài viết mới</h3>
                        <div class="vs-side-posts">
                            <?php while ($recent->have_posts()) : $recent->the_post(); ?>
                                <a class="vs-side-post" href="<?php the_permalink(); ?>">
                                    <span class="vs-side-post__thumb">
                                        <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy')); } ?>
                                    </span>
                                    <span class="vs-side-post__body">
                                        <span class="vs-side-post__title"><?php echo esc_html(wp_trim_words(get_the_title(), 14, '…')); ?></span>
                                        <span class="vs-side-post__date"><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
                                    </span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif;
                wp_reset_postdata();
                ?>

                <!-- Related (same category) -->
                <?php
                if (!empty($cats)) :
                    $related = new WP_Query(array(
                        'category__in'        => array($cats[0]->term_id),
                        'posts_per_page'      => 10,
                        'post__not_in'        => array(get_the_ID()),
                        'ignore_sticky_posts' => true,
                        'no_found_rows'       => true,
                    ));
                    if ($related->have_posts()) : ?>
                        <div class="vs-widget">
                            <h3 class="vs-widget__title">Bài liên quan</h3>
                            <div class="vs-side-posts">
                                <?php while ($related->have_posts()) : $related->the_post(); ?>
                                    <a class="vs-side-post" href="<?php the_permalink(); ?>">
                                        <span class="vs-side-post__thumb">
                                            <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail', array('alt' => esc_attr(get_the_title()), 'loading' => 'lazy')); } ?>
                                        </span>
                                        <span class="vs-side-post__body">
                                            <span class="vs-side-post__title"><?php echo esc_html(wp_trim_words(get_the_title(), 14, '…')); ?></span>
                                            <span class="vs-side-post__date"><?php dragon_the_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
                                        </span>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif;
                    wp_reset_postdata();
                endif;
                ?>

                <!-- Contact CTA card -->
                <div class="vs-widget vs-side-cta">
                    <h3 class="vs-widget__title"><?php echo esc_html(dragon_opt('side_cta_title') !== '' ? dragon_opt('side_cta_title') : 'Tư vấn miễn phí'); ?></h3>
                    <p><?php echo esc_html(dragon_opt('side_cta_text') !== '' ? dragon_opt('side_cta_text') : 'Gọi ngay để được tiếp nhận và tư vấn miễn phí.'); ?></p>
                    <a class="dragon-btn dragon-btn--primary dragon-btn--block" href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php dragon_the_icon('phone'); ?><?php echo esc_html(dragon_opt('phone')); ?></a>
                </div>
            </aside>
        </div>
    </article>
    <?php
endwhile;
get_footer();
