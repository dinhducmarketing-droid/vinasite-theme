<?php
/**
 * Dragon – consultation form handler (AJAX + no-JS fallback).
 * Security: nonce, honeypot, rate-limit (transient), full sanitisation, safe
 * upload validation, and no sensitive data in the email subject.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_dragon_consultation', 'dragon_handle_consultation');
add_action('wp_ajax_nopriv_dragon_consultation', 'dragon_handle_consultation');
add_action('admin_post_dragon_consultation', 'dragon_handle_consultation');
add_action('admin_post_nopriv_dragon_consultation', 'dragon_handle_consultation');

function dragon_consultation_respond($ok, $message, $is_ajax)
{
    if ($is_ajax) {
        wp_send_json(array('success' => $ok, 'message' => $message), $ok ? 200 : 400);
    }
    $target = wp_get_referer() ? wp_get_referer() : home_url('/');
    $target = add_query_arg('dragon_sent', $ok ? '1' : '0', $target) . '#dragon-consultation';
    wp_safe_redirect($target);
    exit;
}

function dragon_handle_consultation()
{
    $is_ajax = wp_doing_ajax();

    // 1) Nonce.
    if (!isset($_POST['dragon_nonce']) || !wp_verify_nonce($_POST['dragon_nonce'], 'dragon_consultation')) {
        dragon_consultation_respond(false, 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.', $is_ajax);
    }

    // 2) Honeypot – silently accept to not tip off bots, but drop.
    if (!empty($_POST['dragon_website'])) {
        dragon_consultation_respond(true, 'Cảm ơn bạn, yêu cầu đã được ghi nhận.', $is_ajax);
    }

    // 3) Rate limit by IP (max 5 / 10 min).
    $ip  = isset($_SERVER['REMOTE_ADDR']) ? preg_replace('/[^0-9a-f:.]/i', '', $_SERVER['REMOTE_ADDR']) : 'unknown';
    $key = 'dragon_rl_' . md5($ip);
    $hits = (int) get_transient($key);
    if ($hits >= 5) {
        dragon_consultation_respond(false, 'Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau ít phút hoặc gọi ' . esc_html(dragon_opt('phone')) . '.', $is_ajax);
    }

    // 4) Sanitize.
    $name    = isset($_POST['dragon_name']) ? sanitize_text_field(wp_unslash($_POST['dragon_name'])) : '';
    $phone   = isset($_POST['dragon_phone']) ? sanitize_text_field(wp_unslash($_POST['dragon_phone'])) : '';
    $email   = isset($_POST['dragon_email']) ? sanitize_email(wp_unslash($_POST['dragon_email'])) : '';
    $area    = isset($_POST['dragon_area']) ? sanitize_text_field(wp_unslash($_POST['dragon_area'])) : '';
    $city    = isset($_POST['dragon_city']) ? sanitize_text_field(wp_unslash($_POST['dragon_city'])) : '';
    $message = isset($_POST['dragon_message']) ? sanitize_textarea_field(wp_unslash($_POST['dragon_message'])) : '';
    $consent = !empty($_POST['dragon_consent']);

    // 5) Validate.
    if ($name === '' || $phone === '' || !$consent) {
        dragon_consultation_respond(false, 'Vui lòng nhập họ tên, số điện thoại và đồng ý chính sách bảo mật.', $is_ajax);
    }
    if (!preg_match('/^[0-9+\s.\-]{8,15}$/', $phone)) {
        dragon_consultation_respond(false, 'Số điện thoại không hợp lệ. Vui lòng kiểm tra lại.', $is_ajax);
    }

    // 6) Optional file upload – validate strictly, store privately.
    $attachments = array();
    if (!empty($_FILES['dragon_file']['name']) && empty($_FILES['dragon_file']['error'])) {
        $allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');
        $size    = (int) $_FILES['dragon_file']['size'];
        $check   = wp_check_filetype_and_ext($_FILES['dragon_file']['tmp_name'], $_FILES['dragon_file']['name']);
        $ext     = strtolower(pathinfo($_FILES['dragon_file']['name'], PATHINFO_EXTENSION));
        if ($size > 8 * 1024 * 1024) {
            dragon_consultation_respond(false, 'Tệp vượt quá 8MB. Vui lòng gửi tệp nhỏ hơn.', $is_ajax);
        }
        if (!in_array($ext, $allowed, true) || empty($check['ext'])) {
            dragon_consultation_respond(false, 'Định dạng tệp không được hỗ trợ.', $is_ajax);
        }
        require_once ABSPATH . 'wp-admin/includes/file.php';
        // Route the upload into a PRIVATE folder (not the public Media library):
        // uploads/dragon-consult/ guarded by .htaccess Deny + Options -Indexes so
        // client case documents are never publicly downloadable. The file is only
        // delivered as an email attachment to the firm.
        add_filter('upload_dir', 'dragon_private_upload_dir');
        $moved = wp_handle_upload($_FILES['dragon_file'], array(
            'test_form'                => false,
            'unique_filename_callback' => 'dragon_obfuscate_filename',
            'mimes'     => array(
                'pdf'          => 'application/pdf',
                'doc'          => 'application/msword',
                'docx'         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'jpg|jpeg'     => 'image/jpeg',
                'png'          => 'image/png',
            ),
        ));
        remove_filter('upload_dir', 'dragon_private_upload_dir');
        if (isset($moved['file']) && !isset($moved['error'])) {
            $attachments[] = $moved['file'];
        }
    }

    // 7) Compose email. Subject carries NO case content (privacy).
    $labels = array();
    foreach (dragon_practice_areas() as $a) { $labels[$a['key']] = $a['title']; }
    $area_label = isset($labels[$area]) ? $labels[$area] : ($area === 'khac' ? 'Chưa rõ / khác' : $area);

    $to      = dragon_opt('form_email');
    if (!is_email($to)) { $to = get_option('admin_email'); }
    $subject = '[Yêu cầu tư vấn] ' . $name . ($area_label ? ' – ' . $area_label : '');
    $body    = "Yêu cầu tư vấn mới từ website:\n\n"
             . "Họ tên: {$name}\n"
             . "Điện thoại: {$phone}\n"
             . "Email: " . ($email ?: '(không cung cấp)') . "\n"
             . "Lĩnh vực: " . ($area_label ?: '(không chọn)') . "\n"
             . "Tỉnh/TP: " . ($city ?: '(không cung cấp)') . "\n"
             . "Nội dung:\n" . ($message ?: '(không có)') . "\n\n"
             . "Thời gian: " . current_time('d/m/Y H:i') . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    if ($email) { $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>'; }

    $sent = wp_mail($to, $subject, $body, $headers, $attachments);

    // 7b) PRIVACY: delete the uploaded file from the server immediately after it
    // has been attached to the email. The firm keeps the copy via email; nothing
    // sensitive persists on disk (this is the decisive guard — .htaccess "Deny"
    // is not reliably honoured for static files under LiteSpeed on this host).
    foreach ($attachments as $att) {
        if (is_string($att) && file_exists($att)) {
            @unlink($att);
        }
    }

    // 7c) Mirror the lead into the Google Sheet (all-forms sync mu-plugin).
    // Best-effort, non-blocking; keys are normaliser-friendly so they land in the
    // right columns. Runs whether or not the email delivered, so no lead is lost.
    if (function_exists('dragon_sheet_push')) {
        dragon_sheet_push('Tư vấn trang chủ', array(
            'name'    => $name,
            'phone'   => $phone,
            'email'   => $email,
            'service' => $area_label,
            'message' => $message,
            'Tỉnh/TP' => $city,
        ), wp_get_referer() ? wp_get_referer() : home_url('/'));
    }

    // 8) Bump rate limit.
    set_transient($key, $hits + 1, 10 * MINUTE_IN_SECONDS);

    if ($sent) {
        dragon_consultation_respond(true, 'Cảm ơn bạn! Yêu cầu đã được gửi. Luật sư Dragon sẽ liên hệ trong thời gian sớm nhất.', $is_ajax);
    }
    dragon_consultation_respond(false, 'Không gửi được yêu cầu. Vui lòng gọi ' . esc_html(dragon_opt('phone')) . ' để được hỗ trợ ngay.', $is_ajax);
}

/**
 * Redirect consultation uploads to a private, non-listable, non-executable dir.
 * Files here are NOT in the Media library and cannot be downloaded from the web.
 */
function dragon_private_upload_dir($dirs)
{
    $sub          = '/dragon-consult';
    $dirs['path']   = $dirs['basedir'] . $sub;
    $dirs['url']    = $dirs['baseurl'] . $sub; // not used publicly; file is emailed
    $dirs['subdir'] = $sub;

    if (!file_exists($dirs['path'])) {
        wp_mkdir_p($dirs['path']);
    }
    // Harden the folder once.
    $ht = $dirs['path'] . '/.htaccess';
    if (!file_exists($ht)) {
        // Cover both Apache 2.4 (Require) and 2.2 (Deny). Note: on LiteSpeed this
        // is best-effort only — the real guarantee is that the file is unlinked
        // right after the email is sent (see dragon_handle_consultation step 7b).
        @file_put_contents($ht, "<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nOrder allow,deny\nDeny from all\n</IfModule>\nOptions -Indexes\n");
    }
    $idx = $dirs['path'] . '/index.php';
    if (!file_exists($idx)) {
        @file_put_contents($idx, "<?php // Silence is golden.\n");
    }
    return $dirs;
}

/**
 * Randomise the stored filename so it cannot be guessed even if the folder guard
 * is ever misconfigured. Keeps the validated extension only.
 */
function dragon_obfuscate_filename($dir, $name, $ext)
{
    // WordPress calls this as ($dir, $name, $ext); $ext already includes the dot.
    $ext = (string) $ext;
    return 'hs-' . substr(md5(uniqid('', true)), 0, 20) . $ext;
}
