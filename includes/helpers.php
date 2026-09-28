<?php
/**
 * Helper Functions - Veeping
 */

if (!defined('ABSPATH')) exit;

/* ---------- Nav Menu Classes ---------- */
function veeping_nav_link_class($atts, $item, $args, $depth) {
    if (!empty($args->link_class)) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'veeping_nav_link_class', 10, 4);

function veeping_nav_menu_submenu_class($classes, $args, $depth) {
    if (isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }
    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'veeping_nav_menu_submenu_class', 10, 3);

/* ---------- Excerpt ---------- */
function veeping_excerpt_length($length) { return 25; }
add_filter('excerpt_length', 'veeping_excerpt_length');

function veeping_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'veeping_excerpt_more');

/* ---------- Breadcrumb ---------- */
function veeping_breadcrumb() {
    if (is_front_page()) return;

    echo '<nav class="veeping-breadcrumb mb-6 text-sm flex items-center flex-wrap gap-1">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="hover:text-neon-gold transition flex items-center gap-1"><i class="fa-solid fa-home"></i>' . __('خانه', 'veeping') . '</a>';

    if (is_category() || is_single()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        if (is_single()) {
            $cats = get_the_category();
            if (!empty($cats)) {
                $first_cat = $cats[0];
                echo '<a href="' . esc_url(get_category_link($first_cat->term_id)) . '" class="hover:text-neon-gold transition">' . esc_html($first_cat->name) . '</a>';
                echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
            }
            echo '<span class="text-gray-500">' . esc_html(get_the_title()) . '</span>';
        } else {
            single_cat_title();
        }
    } elseif (is_page()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_search()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">' . __('نتایج جستجو', 'veeping') . '</span>';
    } elseif (is_404()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">404</span>';
    } elseif (is_shop()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">' . __('فروشگاه', 'veeping') . '</span>';
    } elseif (is_cart()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">' . __('سبد خرید', 'veeping') . '</span>';
    } elseif (is_checkout()) {
        echo '<span class="separator text-gray-600"><i class="fa-solid fa-chevron-left text-xs"></i></span>';
        echo '<span class="text-gray-500">' . __('تسویه حساب', 'veeping') . '</span>';
    }

    echo '</nav>';
}

/* ---------- کش کوئری محصولات ویژه صفحه اصلی (بهبود TTFB) ---------- */
/**
 * کوئری محصولات ویژه که در صفحه اصلی (بخش قیمت‌گذاری) استفاده می‌شود، هزینه‌بر است
 * چون شامل tax_query روی product_visibility است. با کش‌کردن نتیجه در transient به مدت ۱۲ ساعت
 * و پاک‌سازی خودکار هنگام ذخیره محصول، از اجرای این کوئری روی هر بار بارگذاری صفحه جلوگیری می‌شود.
 */
function veeping_get_featured_product_ids() {
    $cache_key = 'veeping_featured_product_ids';
    $cached = get_transient($cache_key);
    if (false !== $cached) {
        return $cached;
    }

    $query = new WP_Query(array(
        'post_type'      => 'product',
        'posts_per_page' => 12,
        'fields'         => 'ids',
        'no_found_rows'  => false,
        'tax_query'      => array(array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
        )),
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    ));

    $ids = $query->posts;
    set_transient($cache_key, $ids, 12 * HOUR_IN_SECONDS);

    return $ids;
}

/**
 * پاک‌سازی کش هنگام ذخیره/تغییر وضعیت هر محصول تا صفحه اصلی همیشه به‌روز بماند
 */
function veeping_clear_featured_products_cache($post_id) {
    if (get_post_type($post_id) !== 'product') return;
    delete_transient('veeping_featured_product_ids');
}
add_action('save_post_product', 'veeping_clear_featured_products_cache');
add_action('woocommerce_trash_product', 'veeping_clear_featured_products_cache');
add_action('untrashed_post', 'veeping_clear_featured_products_cache');

// همچنین وقتی وضعیت "محصول ویژه" از طریق Quick Edit (بدون ذخیره کامل نوشته) تغییر می‌کند، کش پاک شود
function veeping_clear_featured_cache_on_meta_change($meta_id, $post_id, $meta_key) {
    if (in_array($meta_key, array('_featured', '_stock_status'), true)) {
        delete_transient('veeping_featured_product_ids');
    }
}
add_action('updated_post_meta', 'veeping_clear_featured_cache_on_meta_change', 10, 3);
add_action('added_post_meta', 'veeping_clear_featured_cache_on_meta_change', 10, 3);

/* ---------- Security: noopener noreferrer ---------- */
function veeping_secure_target_blank_links($content) {
    if (preg_match_all('/<a\s[^>]*target\s*=\s*["\']_blank["\'][^>]*>/i', $content, $matches)) {
        $content = preg_replace_callback('/<a\s([^>]*target\s*=\s*["\']_blank["\'][^>]*)>/i', function ($m) {
            $attrs = $m[1];
            if (preg_match('/rel\s*=\s*["\']([^"\']*)["\']/i', $attrs, $rel_match)) {
                $rel = array_unique(array_filter(array_merge(explode(' ', $rel_match[1]), array('noopener', 'noreferrer'))));
                $attrs = preg_replace('/rel\s*=\s*["\'][^"\']*["\']/i', 'rel="' . esc_attr(implode(' ', $rel)) . '"', $attrs);
            } else {
                $attrs .= ' rel="noopener noreferrer"';
            }
            return '<a ' . $attrs . '>';
        }, $content);
    }
    return $content;
}
add_filter('the_content', 'veeping_secure_target_blank_links', 20);
add_filter('widget_text', 'veeping_secure_target_blank_links', 20);

/* ---------- SupportCandy compatibility ---------- */
function veeping_add_tickets_endpoint() {
    if (class_exists('PSM_Support_Candy')) return;
    add_rewrite_endpoint('tickets', EP_ROOT | EP_PAGES);
}
add_action('init', 'veeping_add_tickets_endpoint');

function veeping_tickets_endpoint_content() {
    if (class_exists('PSM_Support_Candy')) return;
    echo '<div class="woocommerce-tickets"><p>سیستم پشتیبانی و تیکت‌ها به‌زودی در این بخش فعال می‌شود.</p></div>';
}
add_action('woocommerce_account_tickets_endpoint', 'veeping_tickets_endpoint_content');
