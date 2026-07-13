<?php
/**
 * Generic page. header.php opens <main>.
 *
 * NOTE: pages built with the old UX Builder shortcodes ([section], [ux_...])
 * will show raw shortcodes here because those shortcodes belong to Flatsome.
 * Such pages must be rebuilt in the block/classic editor before switching the
 * active theme to Vinasite (see handover notes).
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
while (have_posts()) : the_post();
    ?>
    <article <?php post_class('dragon-scope vs-page'); ?>>
        <header class="vs-single__hero">
            <div class="dragon-container">
                <nav class="vs-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a> <span aria-hidden="true">›</span>
                    <span><?php the_title(); ?></span>
                </nav>
                <h1 class="vs-single__title"><?php the_title(); ?></h1>
            </div>
        </header>
        <div class="dragon-container vs-page__wrap">
            <?php if (has_post_thumbnail()) : ?>
                <figure class="vs-single__thumb"><?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?></figure>
            <?php endif; ?>
            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => '<div class="vs-linkpages">', 'after' => '</div>')); ?>
            </div>
        </div>
    </article>
    <?php
endwhile;
get_footer();
