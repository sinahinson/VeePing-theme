<?php
/**
 * Theme Setup - Veeping
 */

if (!defined('ABSPATH')) exit;

function veeping_setup() {
    load_theme_textdomain('veeping', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height' => 100, 'width' => 400,
        'flex-height' => true, 'flex-width' => true,
    ));
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script', 'navigation-widgets',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 400,
        'single_image_width' => 800,
        'product_grid' => array(
            'default_rows' => 3, 'min_rows' => 1, 'max_rows' => 10,
            'default_columns' => 3, 'min_columns' => 1, 'max_columns' => 4,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'veeping'),
        'footer-quick' => __('فوتر - دسترسی سریع', 'veeping'),
        'footer-contact' => __('فوتر - ارتباط با ما', 'veeping'),
        'footer-legal' => __('فوتر - لینک‌های حقوقی', 'veeping'),
    ));
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'veeping_setup');

function veeping_widgets_init() {
    register_sidebar(array(
        'name' => __('سایدبار وبلاگ', 'veeping'),
        'id' => 'sidebar-1',
        'description' => __('ابزارک‌های این ناحیه در صفحات وبلاگ نمایش داده می‌شوند.', 'veeping'),
        'before_widget' => '<div id="%1$s" class="glass-card p-6 rounded-2xl mb-6 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-xl font-black text-white mb-4 flex items-center gap-2"><span class="w-1 h-6 bg-neon-gold rounded"></span>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('سایدبار فروشگاه', 'veeping'),
        'id' => 'sidebar-shop',
        'description' => __('ابزارک‌های این ناحیه در صفحات فروشگاه نمایش داده می‌شوند.', 'veeping'),
        'before_widget' => '<div id="%1$s" class="glass-card p-6 rounded-2xl mb-6 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-xl font-black text-white mb-4 flex items-center gap-2"><span class="w-1 h-6 bg-neon-gold rounded"></span>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'veeping_widgets_init');

/**
 * سایدبار ساده فروشگاه - فقط دسته‌بندی محصولات
 */
function veeping_shop_categories_widget() {
    $categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'exclude'    => array(get_option('default_product_cat', 0)),
        'orderby'    => 'name',
        'order'      => 'ASC',
    ));

    if (is_wp_error($categories) || empty($categories)) return;

    $current_term_id = 0;
    if (is_product_taxonomy()) {
        $queried = get_queried_object();
        if (!empty($queried->term_id)) $current_term_id = (int) $queried->term_id;
    }
    ?>
    <div class="glass-card p-6 rounded-2xl">
        <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
            <span class="w-1 h-6 bg-neon-gold rounded"></span>
            دسته‌بندی‌ها
        </h3>
        <ul class="space-y-1">
            <li>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors <?php echo (!is_product_taxonomy()) ? 'bg-neon-gold/10 text-neon-gold font-bold' : 'text-gray-300 hover:text-neon-gold hover:bg-white/5'; ?>">
                    <span><i class="fa-solid fa-layer-group ml-2 text-xs opacity-70"></i>همه محصولات</span>
                </a>
            </li>
            <?php foreach ($categories as $cat) : ?>
                <li>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                       class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors <?php echo ($current_term_id === (int) $cat->term_id) ? 'bg-neon-gold/10 text-neon-gold font-bold' : 'text-gray-300 hover:text-neon-gold hover:bg-white/5'; ?>">
                            <span><i class="fa-solid fa-folder ml-2 text-xs opacity-70"></i><?php echo esc_html($cat->name); ?></span>
                            <span class="text-xs text-gray-500"><?php echo esc_html($cat->count); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}
