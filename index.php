<?php
/**
 * Blog / fallback index. (header.php already opens <main>; footer.php closes it.)
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="dragon-section vs-list">
    <div class="dragon-container">
        <header class="dragon-section-head">
            <span class="dragon-eyebrow">Bài viết</span>
            <h1><?php echo esc_html(is_home() && get_option('page_for_posts') ? get_the_title(get_option('page_for_posts')) : 'Tin tức & kiến thức'); ?></h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="dragon-postgrid vs-postgrid">
                <?php while (have_posts()) : the_post(); get_template_part('template-parts/content', 'card'); endwhile; ?>
            </div>
            <div class="vs-pagination">
                <?php the_posts_pagination(array('mid_size' => 2, 'prev_text' => '‹', 'next_text' => '›')); ?>
            </div>
        <?php else : ?>
            <p class="vs-empty">Chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
