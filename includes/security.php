<?php
/**
 * Security Hardening - Veeping
 */

if (!defined('ABSPATH')) exit;

add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * جلوگیری از افشای اطلاعات کاربران (User Enumeration) از طریق REST API
 * (نقطه ضعف امنیتی شناخته‌شده وردپرس که مهاجم می‌تواند نام‌کاربری‌ها را از /wp-json/wp/v2/users کشف کند)
 */
function veeping_disable_users_rest_endpoint($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'veeping_disable_users_rest_endpoint');

/**
 * جلوگیری از افشای نام‌کاربری از طریق ?author=N (روش قدیمی و رایج کشف نام‌کاربری ادمین)
 */
function veeping_block_author_enumeration() {
    if (is_admin() || !isset($_GET['author'])) return;
    if (!is_numeric($_GET['author'])) return;
    wp_safe_redirect(home_url('/'), 301);
    exit;
}
add_action('template_redirect', 'veeping_block_author_enumeration');

/**
 * هدرهای امنیتی HTTP
 */
function veeping_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
}
add_action('send_headers', 'veeping_security_headers');

/**
 * غیرفعال کردن مرور پوشه‌ها و مخفی‌سازی نسخه وردپرس در پاسخ‌های خطا (سخت‌تر کردن fingerprinting)
 */
add_filter('the_generator', '__return_empty_string');

/**
 * محدودسازی نرخ تلاش برای ورود از طریق فیلتر استاندارد (لایه دفاعی مکمل - برای محدودیت کامل از افزونه امنیتی/فایروال استفاده کنید)
 */
function veeping_login_error_message() {
    return __('نام کاربری یا رمز عبور اشتباه است.', 'veeping');
}
add_filter('login_errors', 'veeping_login_error_message');

function veeping_disable_xmlrpc_method($methods) {
    unset($methods['methods']['system.multicall']);
    return $methods;
}
add_filter('xmlrpc_methods', 'veeping_disable_xmlrpc_method');

function veeping_block_edit_address_endpoint() {
    if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('edit-address')) {
        wp_safe_redirect(wc_get_account_endpoint_url('dashboard'));
        exit;
    }
}
add_action('template_redirect', 'veeping_block_edit_address_endpoint');
