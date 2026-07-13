<?php
/**
 * Home – Lawyer team. Reuses the EXISTING dt_team CPT (no duplicate data).
 * Credentials shown only if present in post meta; nothing is fabricated.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

$q = new WP_Query(array(
    'post_type'           => 'dt_team',
    'post_status'         => 'publish',
    'posts_per_page'      => 4,
    'orderby'             => 'menu_order date',
    'order'               => 'ASC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
));

if ($q->have_posts()) : ?>
<section class="dragon-section" id="dragon-lawyers" aria-labelledby="dragon-lawyers-title">
    <div class="dragon-container">
        <div class="dragon-section-head">
            <span class="dragon-eyebrow">Đội ngũ luật sư</span>
            <h2 id="dragon-lawyers-title">Luật sư & chuyên viên pháp lý</h2>
            <p>Đội ngũ trực tiếp tiếp nhận, tư vấn và đại diện cho khách hàng.</p>
        </div>
        <div class="dragon-lawyers__grid">
            <?php while ($q->have_posts()) : $q->the_post();
                // Pull optional meta if the theme/ACF stored it; never invent values.
                $role = get_post_meta(get_the_ID(), 'chuc_danh', true);
                if (!$role) { $role = get_post_meta(get_the_ID(), 'position', true); }
                if (!$role) { $role = 'Luật sư'; }
                $bar  = get_post_meta(get_the_ID(), 'doan_luat_su', true);
                $exp  = get_post_meta(get_the_ID(), 'kinh_nghiem', true);
                ?>
                <article class="dragon-card dragon-lawyer dragon-reveal">
                    <div class="dragon-lawyer__photo">
                        <?php if (has_post_thumbnail()) :
                            the_post_thumbnail('medium_large', array(
                                'alt'     => esc_attr('Luật sư ' . get_the_title()),
                                'loading' => 'lazy',
                                'width'   => 300,
                                'height'  => 400,
                            ));
                        else : ?>
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/user_02.jpeg'); ?>" width="300" height="400" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy"/>
                        <?php endif; ?>
                    </div>
                    <div class="dragon-lawyer__body">
                        <h3 class="dragon-lawyer__name"><?php the_title(); ?></h3>
                        <div class="dragon-lawyer__role"><?php echo esc_html($role); ?></div>
                        <?php if ($bar || $exp) : ?>
                            <div class="dragon-lawyer__meta">
                                <?php if ($bar) : ?><div><strong>Đoàn LS:</strong> <?php echo esc_html($bar); ?></div><?php endif; ?>
                                <?php if ($exp) : ?><div><strong>Kinh nghiệm:</strong> <?php echo esc_html($exp); ?></div><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="dragon-lawyer__actions">
                            <a class="dragon-btn dragon-btn--outline" href="<?php the_permalink(); ?>">Hồ sơ</a>
                            <a class="dragon-btn dragon-btn--primary" href="#dragon-consultation">Đặt lịch</a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <div class="dragon-news__foot">
            <a class="dragon-btn dragon-btn--outline" href="https://vanphongluatsu.com.vn/doi-ngu-nhan-su/">Xem toàn bộ đội ngũ <?php dragon_the_icon('arrow-right'); ?></a>
        </div>
    </div>
</section>
<?php endif;
wp_reset_postdata();
