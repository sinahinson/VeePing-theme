<?php
/**
 * WooCommerce Modifications - Veeping
 */

if (!defined('ABSPATH')) exit;

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

function veeping_loop_columns() { return 3; }
add_filter('loop_shop_columns', 'veeping_loop_columns');

function veeping_products_per_page() { return 9; }
add_filter('loop_shop_per_page', 'veeping_products_per_page');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/* ---------- Checkout Field Removal ---------- */
function veeping_force_remove_checkout_fields($fields) {
    unset($fields['shipping']);
    if (isset($fields['order'])) unset($fields['order']);
    if (isset($fields['billing'])) {
        foreach (array('billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode') as $key) {
            if (isset($fields['billing'][$key])) unset($fields['billing'][$key]);
        }
        // غیراجباری کردن فیلدهای نام و ایمیل
        foreach (array('billing_first_name', 'billing_last_name', 'billing_email') as $key) {
            if (isset($fields['billing'][$key])) $fields['billing'][$key]['required'] = false;
        }
    }
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'veeping_force_remove_checkout_fields', 9999);

add_filter('woocommerce_cart_needs_shipping', '__return_false');
add_filter('woocommerce_checkout_show_shipping_section', '__return_false');
add_filter('woocommerce_ship_to_different_address_checked', '__return_false');
add_filter('woocommerce_enable_shipping_calc', '__return_false');
add_filter('woocommerce_shipping_enabled', '__return_false');

function veeping_unhook_checkout_fields() {
    if (!is_checkout()) return;
    remove_action('woocommerce_before_checkout_billing_form', 'woocommerce_checkout_billing_fields', 10);
    remove_action('woocommerce_before_checkout_shipping_form', 'woocommerce_checkout_shipping_fields', 10);
}
add_action('woocommerce_before_checkout_form', 'veeping_unhook_checkout_fields');

function veeping_custom_checkout_billing_fields() {
    $fields = WC()->checkout->get_checkout_fields('billing');

    // اگر ثبت‌نام حساب کاربری فعال باشد، WooCommerce خودش فیلد ایمیل را اضافه می‌کند
    $registration_enabled = get_option('woocommerce_enable_checkout_login_reminder');
    $is_logged_in = is_user_logged_in();

    $allowed = array('billing_first_name', 'billing_last_name', 'billing_phone');

    // فقط اگر ثبت‌نام فعال نیست یا کاربر قبلاً وارد شده، فیلد ایمیل را اضافه کن
    if (!$registration_enabled || $is_logged_in) {
        $allowed[] = 'billing_email';
    }

    echo '<div class="woocommerce-billing-fields__field-wrapper">';
    foreach ($allowed as $key) {
        if (isset($fields[$key])) {
            woocommerce_form_field($key, $fields[$key]);
        }
    }
    echo '</div>';
}
add_action('woocommerce_before_checkout_billing_form', 'veeping_custom_checkout_billing_fields');

/* ---------- Custom Account Registration Fields ---------- */
function veeping_custom_checkout_account_fields() {
    if (!get_option('woocommerce_enable_checkout_login_reminder') && !is_user_logged_in()) {
        echo '<div id="account_fields" class="woocommerce-account-fields">';

        $fields = WC()->checkout->get_checkout_fields('account');

        // غیراجباری کردن فیلدهای حساب کاربری
        if (isset($fields['account_username'])) {
            $fields['account_username']['required'] = false;
            woocommerce_form_field('account_username', $fields['account_username']);
        }

        if (isset($fields['account_password'])) {
            $fields['account_password']['required'] = false;
            woocommerce_form_field('account_password', $fields['account_password']);
        }

        if (isset($fields['account_password_confirm'])) {
            $fields['account_password_confirm']['required'] = false;
            woocommerce_form_field('account_password_confirm', $fields['account_password_confirm']);
        }

        echo '</div>';
    }
}
add_action('woocommerce_before_checkout_billing_form', 'veeping_custom_checkout_account_fields', 20);

/* ---------- Hide Quantity Fields ---------- */
function veeping_hide_quantity_fields() {
    if (function_exists('is_woocommerce') && (is_product() || is_cart())) {
        echo '<style>.quantity, .woocommerce-cart-form .quantity, .single-product .quantity, .product-quantity { display: none !important; }
        .woocommerce-cart-form button[name="update_cart"], .woocommerce-cart-form .actions { display: none !important; }</style>';
    }
}
add_action('wp_head', 'veeping_hide_quantity_fields');

/* ---------- Force Quantity = 1 ---------- */
function veeping_force_single_quantity($passed, $product_id, $quantity) {
    if (WC()->cart) {
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['product_id'] == $product_id && $quantity > 1) {
                wc_add_notice('فقط می‌توانید ۱ عدد از هر محصول خریداری کنید.', 'error');
                return false;
            }
        }
    }
    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'veeping_force_single_quantity', 10, 3);

function veeping_prevent_cart_quantity_update($passed, $cart_item_key, $values, $updated_quantity) {
    if ($updated_quantity != 1) {
        wc_add_notice('تعداد هر محصول فقط می‌تواند ۱ باشد.', 'error');
        return false;
    }
    return $passed;
}
add_action('woocommerce_update_cart_validation', 'veeping_prevent_cart_quantity_update', 10, 4);

/* ---------- Disable Coupons for Wallet Topup ---------- */
function veeping_disable_coupons_for_wallet_topup($enabled) {
    if (!did_action('woocommerce_cart_loaded_from_session')) return $enabled;
    if (!function_exists('WC') || !WC()->cart) return $enabled;
    $topup_product_id = get_option('_woo_wallet_recharge_product');
    if (!$topup_product_id) return $enabled;
    foreach (WC()->cart->get_cart() as $cart_item) {
        if ($cart_item['product_id'] == $topup_product_id) return false;
    }
    return $enabled;
}
add_filter('woocommerce_coupons_enabled', 'veeping_disable_coupons_for_wallet_topup');

/* ---------- Clear Cart Button ---------- */
function veeping_add_clear_cart_button() {
    if (!function_exists('WC') || !WC()->cart || WC()->cart->is_empty()) return;
    $shop_url = get_permalink(wc_get_page_id('shop'));
    ?>
    <div style="text-align: right; margin-bottom: 10px;">
        <button type="button" class="button" id="clear-cart-checkout-top" style="font-size: 13px; padding: 5px 12px; background: #e74c3c; border-color: #c0392b; color: #fff; border-radius: 3px;">
            <?php _e('پاکسازی سبد خرید', 'woocommerce'); ?>
        </button>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#clear-cart-checkout-top').on('click', function(e) {
            e.preventDefault();
            if (!confirm('آیا مطمئن هستید که می‌خواهید همه محصولات را از سبد خرید حذف کنید؟')) return;
            var btn = $(this);
            btn.prop('disabled', true).text('در حال حذف...');
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: { action: 'empty_cart_and_redirect', security: '<?php echo wp_create_nonce('empty_cart_nonce'); ?>' },
                success: function(response) {
                    if (response.success) window.location.href = '<?php echo esc_js($shop_url); ?>';
                    else { alert('خطایی رخ داد.'); btn.prop('disabled', false).text('<?php _e('حذف همه محصولات', 'woocommerce'); ?>'); }
                },
                error: function() { alert('خطا در ارتباط با سرور.'); btn.prop('disabled', false).text('<?php _e('حذف همه محصولات', 'woocommerce'); ?>'); }
            });
        });
    });
    </script>
    <?php
}
add_action('woocommerce_before_checkout_form', 'veeping_add_clear_cart_button', 5);

function veeping_ajax_empty_cart() {
    $security = isset($_POST['security']) ? sanitize_text_field(wp_unslash($_POST['security'])) : '';
    if (!wp_verify_nonce($security, 'empty_cart_nonce')) wp_send_json_error('درخواست نامعتبر.');
    if (function_exists('WC') && WC()->cart) { WC()->cart->empty_cart(); wp_send_json_success(); }
    else wp_send_json_error('سبد خرید در دسترس نیست.');
}
add_action('wp_ajax_empty_cart_and_redirect', 'veeping_ajax_empty_cart');
add_action('wp_ajax_nopriv_empty_cart_and_redirect', 'veeping_ajax_empty_cart');

/* ---------- Remove Address Requirements ---------- */
add_filter('woocommerce_customer_meta_fields', '__return_empty_array');
function veeping_no_address_needed() { return false; }
add_filter('woocommerce_order_needs_shipping_address', 'veeping_no_address_needed', 10, 2);

/* ---------- Quick Buy (Homepage Pricing Carousel) ---------- */
function veeping_quick_buy_add_to_cart() {
    if (!check_ajax_referer('veeping_quick_buy', 'nonce', false)) {
        wp_send_json_error(array('message' => 'نشست شما منقضی شده. لطفاً صفحه را رفرش کنید و دوباره تلاش کنید.'));
    }

    $product_id   = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;

    $variation_attributes = array();
    if (!empty($_POST['attributes']) && is_array($_POST['attributes'])) {
        foreach (wp_unslash($_POST['attributes']) as $key => $value) {
            $key = sanitize_key($key);
            if (strpos($key, 'attribute_') === 0) {
                $variation_attributes[$key] = wc_clean($value);
            }
        }
    }

    $product = $product_id ? wc_get_product($product_id) : false;
    if (!$product) {
        wp_send_json_error(array('message' => 'محصول یافت نشد.'));
    }

    if (function_exists('WC') && WC()->cart === null) {
        wc_load_cart();
    }
    if (!WC()->cart) {
        wp_send_json_error(array('message' => 'خطای سیستمی؛ لطفاً صفحه را رفرش کنید.'));
    }

    WC()->cart->empty_cart();

    if ($product->is_type('variable')) {
        if (!$variation_id) {
            wp_send_json_error(array('message' => 'لطفاً یک گزینه را انتخاب کنید.'));
        }
        $variation = wc_get_product($variation_id);
        if (!$variation || $variation->get_parent_id() !== $product_id) {
            wp_send_json_error(array('message' => 'گزینه انتخابی معتبر نیست.'));
        }
        if (!$variation->is_purchasable() || !$variation->is_in_stock()) {
            wp_send_json_error(array('message' => 'این گزینه در حال حاضر موجود نیست.'));
        }
        $passed = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, 1, $variation_id, $variation_attributes);
        if (!$passed) {
            $notices = wc_get_notices('error');
            wc_clear_notices();
            $message = !empty($notices) ? wp_strip_all_tags($notices[0]['notice']) : 'امکان افزودن این محصول وجود ندارد.';
            wp_send_json_error(array('message' => $message));
        }
        $cart_item_key = WC()->cart->add_to_cart($product_id, 1, $variation_id, $variation_attributes);
    } else {
        if (!$product->is_purchasable() || !$product->is_in_stock()) {
            wp_send_json_error(array('message' => 'این محصول در حال حاضر موجود نیست.'));
        }
        $passed = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, 1);
        if (!$passed) {
            $notices = wc_get_notices('error');
            wc_clear_notices();
            $message = !empty($notices) ? wp_strip_all_tags($notices[0]['notice']) : 'امکان افزودن این محصول وجود ندارد.';
            wp_send_json_error(array('message' => $message));
        }
        $cart_item_key = WC()->cart->add_to_cart($product_id, 1);
    }

    if (!$cart_item_key) {
        $notices = wc_get_notices('error');
        wc_clear_notices();
        $message = !empty($notices) ? wp_strip_all_tags($notices[0]['notice']) : 'خطا در افزودن به سبد خرید. لطفاً دوباره تلاش کنید.';
        wp_send_json_error(array('message' => $message));
    }

    wp_send_json_success(array(
        'redirect' => wc_get_checkout_url(),
    ));
}
add_action('wp_ajax_veeping_quick_buy', 'veeping_quick_buy_add_to_cart');
add_action('wp_ajax_nopriv_veeping_quick_buy', 'veeping_quick_buy_add_to_cart');
