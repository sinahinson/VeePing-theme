<?php
/**
 * Scripts & Styles - Veeping
 * بهینه‌سازی‌شده برای موبایل: کاهش تعداد درخواست‌های رندر-بلاک، حذف اسکریپت‌های زائد
 */

if (!defined('ABSPATH')) exit;

function veeping_scripts() {
    // فونت و آیکون به‌صورت غیر-رندر-بلاک (preload + swap) لود می‌شوند - رجوع کنید به veeping_async_css_tag()
    wp_enqueue_style('vazirmatn', 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css', array(), '33.003');
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    wp_enqueue_style('veeping-theme', get_template_directory_uri() . '/assets/css/theme.min.css', array(), VEEPING_VERSION);

    wp_enqueue_script('alpine', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.14.8', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'veeping_scripts', 20);

function veeping_custom_assets() {
    wp_enqueue_script('veeping-app', get_template_directory_uri() . '/assets/js/app.min.js', array('alpine'), VEEPING_VERSION, true);

    // فقط زمانی که واقعاً به خرید سریع نیاز است (صفحه اصلی) اطلاعات AJAX را لوکالایز کن
    if (is_front_page()) {
        wp_localize_script('veeping-app', 'veepingQuickBuy', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('veeping_quick_buy'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'veeping_custom_assets', 30);

/**
 * حذف اسکریپت‌ها و استایل‌های اضافی که در حالت موبایل غیرضروری هستند
 * (Heartbeat، Embed، jQuery Migrate، Cart-Fragments وقتی لازم نیستند، Dashicons در فرانت‌اند، Block-library وقتی از بلوک استفاده نشده)
 */
function veeping_dequeue_unnecessary_assets() {
    if (is_admin()) return;

    // اسکریپت embed.js وردپرس (برای embed کردن نوشته‌های سایر سایت‌ها) - در اغلب سایت‌ها استفاده نمی‌شود
    wp_deregister_script('wp-embed');

    // Heartbeat API فقط در پیشخوان لازم است، نه در فرانت‌اند
    wp_deregister_script('heartbeat');

    // استایل بلوک‌های گوتنبرگ فقط زمانی لود شود که محتوای صفحه واقعاً از بلوک استفاده کند
    // (صفحات ووکامرس از این حذف مستثنی هستند چون ممکن است از Cart/Checkout Blocks استفاده کنند)
    $is_wc_page = function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());
    if (!has_blocks() && !$is_wc_page) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
    }

    // Dashicons فقط برای کاربران لاگین‌شده (نوار ادمین) لازم است
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }

    // WooCommerce cart-fragments (پول‌بگ AJAX) فقط اگر مینی‌کارت واقعاً در قالب استفاده شود لازم است؛
    // این قالب سبد خرید AJAX-محور در هدر ندارد، پس آن را غیرفعال می‌کنیم تا درخواست admin-ajax حذف شود
    if (function_exists('WC') && !is_cart()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'veeping_dequeue_unnecessary_assets', 100);

function veeping_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array('href' => 'https://cdn.jsdelivr.net', 'crossorigin');
        $urls[] = array('href' => 'https://cdnjs.cloudflare.com', 'crossorigin');
    }
    return $urls;
}
add_filter('wp_resource_hints', 'veeping_resource_hints', 10, 2);

/**
 * defer برای اسکریپت‌های غیرحیاتی (Alpine و اسکریپت اختصاصی تم)
 */
function veeping_add_script_type_attribute($tag, $handle) {
    $scripts_to_modify = array('alpine', 'veeping-app');
    if (in_array($handle, $scripts_to_modify, true)) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'veeping_add_script_type_attribute', 10, 2);

/**
 * لود غیر-رندر-بلاک برای فونت و آیکون (preload + onload swap)
 * این بزرگ‌ترین اصلاح برای بهبود First Contentful Paint در موبایل است،
 * چون این دو فایل CSS از CDN خارجی می‌آیند و رندر صفحه را متوقف می‌کنند.
 */
function veeping_async_css_tag($html, $handle) {
    $async_handles = array('vazirmatn', 'fontawesome');
    if (!in_array($handle, $async_handles, true)) {
        return $html;
    }
    $noscript = '<noscript>' . $html . '</noscript>';
    // rel=preload با onload به rel=stylesheet تبدیل می‌شود؛ نسخه <noscript> اصلی برای مرورگرهای بدون جاوااسکریپت حفظ می‌شود
    $async_html = preg_replace(
        "/rel=(['\"])stylesheet\\1/i",
        "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
        $html
    );
    return $async_html . $noscript;
}
add_filter('style_loader_tag', 'veeping_async_css_tag', 10, 2);


