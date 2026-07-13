<?php
/**
 * Dragon Law Firm – Home page template.
 *
 * WordPress uses front-page.php for the site front page automatically, so this
 * overrides the old UX Builder homepage WITHOUT touching page 7783's content.
 * Rollback = delete this file; the old homepage returns untouched.
 *
 * Section order per brief:
 *  Header → Hero → Trust bar → About → Practice areas → Problem selector →
 *  CTA → Process → Lawyers → Achievements → News → Legal knowledge →
 *  Testimonials → FAQ → Consultation form → Footer.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();

$parts = array(
    'hero',
    'trust-bar',
    'about',
    'practice-areas',
    'problem-selector',
    'cta',
    'process',
    'lawyers',
    'achievements',
    'legal-posts',
    'testimonials',
    'faq',
    'consultation-form',
    'news', // moved to the bottom (just above the footer) per request
);
foreach ($parts as $part) {
    get_template_part('template-parts/home/' . $part);
}

get_footer();
