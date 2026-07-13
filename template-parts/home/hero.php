<?php
/**
 * Home – Hero slider (3 slides). Text is real HTML (not baked into images).
 * Background uses a layered brand gradient (no external image = no CLS / no LCP
 * image / no copyright risk). Admin can add a photo per slide via Customizer
 * settings dragon_hero1_img … dragon_hero3_img if desired.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
$slides = dragon_hero_slides();
?>
<section class="dragon-hero" aria-roledescription="carousel" aria-label="Giới thiệu Công ty Luật Dragon" data-dragon-slider>
    <div class="dragon-hero__deco" aria-hidden="true">
        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" opacity="0.9">
                <path d="M100 24v132M64 156h72M100 24a5 5 0 1 0 .1 0"/>
                <path d="M100 44H44M100 44h56M44 44 26 92h36L44 44Zm112 0-18 48h36l-18-48Z"/>
                <path d="M26 92a18 18 0 0 0 36 0M138 92a18 18 0 0 0 36 0"/>
            </g>
        </svg>
    </div>
    <div class="dragon-hero__slides">
        <?php foreach ($slides as $i => $s) :
            // Admin Customizer override wins, else the per-slide photo from config.
            $img = get_theme_mod('dragon_hero' . ($i + 1) . '_img', '');
            if ($img === '' && !empty($s['img'])) {
                $img = $s['img'];
            }
            ?>
            <div class="dragon-hero__slide<?php echo $i === 0 ? ' is-active' : ''; ?>"
                 role="group" aria-roledescription="slide" aria-label="Slide <?php echo (int) ($i + 1); ?> / <?php echo count($slides); ?>"
                 <?php echo $i !== 0 ? 'aria-hidden="true"' : ''; ?>>
                <?php if ($img) : ?>
                    <div class="dragon-hero__bg" aria-hidden="true">
                        <img src="<?php echo esc_url($img); ?>" alt="" width="1800" height="1200" decoding="async"
                             <?php echo $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>/>
                    </div>
                <?php endif; ?>
                <div class="dragon-container">
                    <div class="dragon-hero__inner">
                        <span class="dragon-hero__eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                        <?php if (!empty($s['is_h1'])) : ?>
                            <h1 class="dragon-hero__title"><?php echo esc_html($s['title']); ?></h1>
                        <?php else : ?>
                            <p class="dragon-hero__title" role="heading" aria-level="2"><?php echo esc_html($s['title']); ?></p>
                        <?php endif; ?>
                        <p class="dragon-hero__desc"><?php echo esc_html($s['desc']); ?></p>
                        <div class="dragon-hero__cta">
                            <a class="dragon-btn" href="<?php echo esc_url($s['cta1'][1]); ?>"><?php dragon_the_icon('calendar'); ?><?php echo esc_html($s['cta1'][0]); ?></a>
                            <a class="dragon-btn dragon-btn--ghost" href="<?php echo esc_url($s['cta2'][1]); ?>"><?php dragon_the_icon('phone'); ?><?php echo esc_html($s['cta2'][0]); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="dragon-hero__controls">
        <div class="dragon-container dragon-hero__controls-inner">
            <button class="dragon-hero__pause" type="button" data-dragon-pause aria-label="Tạm dừng trình chiếu"><svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><rect x="6" y="5" width="4" height="14" fill="currentColor"/><rect x="14" y="5" width="4" height="14" fill="currentColor"/></svg></button>
            <div class="dragon-hero__dots" role="tablist" aria-label="Chọn slide">
                <?php foreach ($slides as $i => $s) : ?>
                    <button class="dragon-hero__dot<?php echo $i === 0 ? ' is-active' : ''; ?>" type="button" role="tab"
                            aria-label="Slide <?php echo (int) ($i + 1); ?>" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                            data-dragon-dot="<?php echo (int) $i; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
