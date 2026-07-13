<?php
/**
 * Search results. header.php opens <main>.
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
        <header class="dragon-section-head dragon-section-head--left">
            <span class="dragon-eyebrow">Tìm kiếm</span>
            <h1>Kết quả cho: “<?php echo esc_html(get_search_query()); ?>”</h1>
            <?php global $wp_query; ?>
            <p><?php echo (int) $wp_query->found_posts; ?> kết quả</p>
        </header>

        <?php if (have_posts()) : ?>
            <div class="dragon-postgrid vs-postgrid">
                <?php while (have_posts()) : the_post(); get_template_part('template-parts/content', 'card'); endwhile; ?>
            </div>
            <div class="vs-pagination">
                <?php the_posts_pagination(array('mid_size' => 2, 'prev_text' => '‹', 'next_text' => '›')); ?>
            </div>
        <?php else : ?>
            <p class="vs-empty">Không tìm thấy kết quả phù hợp. Vui lòng thử từ khoá khác hoặc liên hệ luật sư qua <a href="tel:<?php echo esc_attr(dragon_tel('phone')); ?>"><?php echo esc_html(dragon_opt('phone')); ?></a>.</p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
