<?php
/**
 * Dragon inline SVG icon system.
 * Uniform 24x24 viewBox, stroke-based, currentColor. Decorative by default
 * (aria-hidden). Pass $title to make it meaningful for assistive tech.
 *
 * @package ntgsite-dragon
 */

if (!defined('ABSPATH')) {
    exit;
}

function dragon_icon($name, $title = '')
{
    $paths = array(
        // Practice areas.
        'gavel'    => '<path d="m14 13-7.5 7.5M14 13l3.5 3.5M14 13l-3.5-3.5M6.5 6.5 10 10m4-4 3.5 3.5M2.5 20.5h7"/><path d="m8.5 4.5 4 4m3-3-4-4"/>',
        'scale'    => '<path d="M12 3v18M7 21h10M5 7h14M5 7 3 13a3 3 0 0 0 6 0L7 7m12 0-2 6a3 3 0 0 0 6 0l-2-6M12 4a1.5 1.5 0 1 0 0-.01"/>',
        'home'     => '<path d="M3 10.5 12 3l9 7.5M5 9v11h5v-6h4v6h5V9"/>',
        'heart'    => '<path d="M12 20s-7-4.35-9.5-8.5C.9 8.4 2.4 5 5.5 5 8 5 9.5 7 12 9c2.5-2 4-4 6.5-4C21.6 5 23.1 8.4 21.5 11.5 19 15.65 12 20 12 20Z"/>',
        'building' => '<path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16M15 21V9h4a1 1 0 0 1 1 1v11M2 21h20M7 8h2M7 12h2M7 16h2"/>',
        'contract' => '<path d="M8 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6H8Z"/><path d="M14 3v6h6M8 13h6M8 17h4"/>',
        'stamp'    => '<path d="M6 21h12M4 18h16M9 4a3 3 0 0 1 6 0c0 2-1.5 3-1.5 5h-3C10.5 7 9 6 9 4Z"/><path d="M8 15h8v3H8z"/>',
        'briefcase'=> '<path d="M4 8h16a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a1 1 0 0 1 1-1Z"/><path d="M9 8V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 13h18"/>',
        // Contact / UI.
        'phone'    => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1 16 16 0 0 1-15-15 1 1 0 0 1 1-1Z"/>',
        'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'map-pin'  => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/>',
        'shield'   => '<path d="M12 3 5 6v5c0 4.5 3 8 7 10 4-2 7-5.5 7-10V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>',
        'folder'   => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/>',
        'user-tie' => '<circle cx="12" cy="7" r="3.5"/><path d="M6 21v-1a6 6 0 0 1 12 0v1M12 11l-1.5 3 1.5 5 1.5-5L12 11Z"/>',
        'process'  => '<circle cx="6" cy="6" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="M8.5 6H16a2 2 0 0 1 2 2v7.5M6 8.5V16a2 2 0 0 0 2 2h7.5"/>',
        'news'     => '<path d="M4 5h13a1 1 0 0 1 1 1v12a2 2 0 0 0 2-2V8M4 5a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h13M7 9h7M7 13h7M7 17h4"/>',
        'article'  => '<path d="M4 4h16v16H4zM8 8h8M8 12h8M8 16h5"/>',
        'check'    => '<path d="m5 12 4.5 4.5L19 7"/>',
        'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 6 6 6-6 6"/>',
        'arrow-right'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'menu'     => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
        'star'     => '<path d="m12 4 2.4 5 5.6.8-4 4 1 5.6-5-2.7-5 2.7 1-5.6-4-4 5.6-.8L12 4Z"/>',
        'award'    => '<circle cx="12" cy="9" r="5"/><path d="m9 13-2 8 5-3 5 3-2-8"/>',
        'users'    => '<circle cx="9" cy="8" r="3"/><path d="M3 20v-1a5 5 0 0 1 10 0v1M16 5.5a3 3 0 0 1 0 5.5M21 20v-1a5 5 0 0 0-4-4.9"/>',
        'zalo'     => '<rect x="3" y="3" width="18" height="18" rx="5"/><path d="M8 8v4.5M8 8h2.5M12.5 12.5V9M12.5 9h1.5a1.75 1.75 0 0 1 0 3.5H12.5M16.5 8v4.5h1.5"/>',
        // Social brand marks (Feather-style, fit the 24x24 stroke system).
        'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'youtube'  => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><path fill="currentColor" stroke="none" d="M9.75 15.02 15.5 11.75 9.75 8.48z"/>',
        'chat'     => '<path d="M4 5h16a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H9l-4 4v-4H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>',
        'help'     => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 1 1 3.5 2.3c-.8.4-1 .9-1 1.7M12 17h.01"/>',
    );

    if (!isset($paths[$name])) {
        return '';
    }

    $a11y = $title !== ''
        ? 'role="img" aria-label="' . esc_attr($title) . '"'
        : 'aria-hidden="true" focusable="false"';

    return '<svg class="dragon-ico dragon-ico--' . esc_attr($name) . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" ' . $a11y . '>' . $paths[$name] . '</svg>';
}

function dragon_the_icon($name, $title = '')
{
    echo dragon_icon($name, $title); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static internal SVG markup.
}
