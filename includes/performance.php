<?php
/**
 * Performance - Veeping
 * اصلاحاتی برای کاهش بار سرور و بهبود TTFB / Core Web Vitals
 */

if (!defined('ABSPATH')) exit;

/**
 * محدود کردن تعداد ریویژن هر نوشته/محصول - جدول wp_posts با هزاران ریویژن
 * می‌تواند کوئری‌های وردپرس (و در نتیجه TTFB) را کند کند.
 */
add_filter('wp_revisions_to_keep', function () {
    return 5;
});

/**
 * افزایش فاصله autosave (پیش‌فرض هر ۶۰ ثانیه یک درخواست AJAX به سرور می‌زند)
 */
add_filter('autosave_interval', function () {
    return 120;
});

/**
 * حذف query string نسخه (?ver=) از فایل‌های استاتیک CSS/JS
 * این کار به کش مرورگر و CDN اجازه می‌دهد فایل‌ها را بهتر شناسایی و کش کنند.
 */
function veeping_remove_asset_version_query($src) {
    if (!$src || is_admin()) return $src;
    if (strpos($src, 'ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'veeping_remove_asset_version_query', 9999);
add_filter('script_loader_src', 'veeping_remove_asset_version_query', 9999);

/**
 * غیرفعال کردن self-pingback (کاهش بار پردازشی هنگام لینک‌دهی داخلی)
 */
add_action('pre_ping', function (&$links) {
    $home = home_url();
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
});

/**
 * غیرفعال کردن بارگذاری jQuery Migrate در فرانت‌اند برای مهمان‌ها (سازگاری با Alpine.js حفظ می‌شود چون به jQuery نیازی ندارد)
 */
add_action('wp_default_scripts', function ($scripts) {
    if (is_admin() || empty($scripts->registered['jquery'])) return;
    $script = $scripts->registered['jquery'];
    if ($script->deps) {
        $script->deps = array_diff($script->deps, array('jquery-migrate'));
    }
});
