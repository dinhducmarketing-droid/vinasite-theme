<?php
/**
 * Comments template.
 *
 * @package vinasite
 */
if (!defined('ABSPATH')) {
    exit;
}
if (post_password_required()) {
    return;
}
?>
<section id="comments" class="vs-comments">
    <?php if (have_comments()) : ?>
        <h3 class="vs-widget__title">
            <?php
            $n = get_comments_number();
            printf(esc_html(_n('%s bình luận', '%s bình luận', $n, 'vinasite')), number_format_i18n($n));
            ?>
        </h3>
        <ol class="vs-comment-list">
            <?php
            wp_list_comments(array('style' => 'ol', 'avatar_size' => 44, 'short_ping' => true));
            ?>
        </ol>
        <?php the_comments_pagination(array('prev_text' => '‹', 'next_text' => '›')); ?>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'        => 'Gửi bình luận',
        'class_submit'       => 'dragon-btn dragon-btn--primary',
        'label_submit'       => 'Gửi bình luận',
        'comment_notes_after' => '',
    ));
    ?>
</section>
