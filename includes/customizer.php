<?php
/**
 * Customizer Settings - Veeping
 */

if (!defined('ABSPATH')) exit;

function veeping_customize_register($wp_customize) {
    /* === Section: Contact Info === */
    $wp_customize->add_section('veeping_contact', array(
        'title' => 'اطلاعات تماس', 'priority' => 30,
    ));
    $wp_customize->add_setting('veeping_email', array('default' => 'support@veeping.com', 'sanitize_callback' => 'sanitize_email'));
    $wp_customize->add_control('veeping_email', array('label' => 'ایمیل', 'section' => 'veeping_contact', 'type' => 'email'));
    $wp_customize->add_setting('veeping_phone', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('veeping_phone', array('label' => 'تلفن', 'section' => 'veeping_contact', 'type' => 'tel'));

    /* === Section: Social Links === */
    $wp_customize->add_section('veeping_socials', array('title' => 'شبکه‌های اجتماعی', 'priority' => 35));
    $socials = array('telegram', 'instagram', 'twitter', 'youtube', 'discord');
    foreach ($socials as $s) {
        $wp_customize->add_setting("veeping_{$s}", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("veeping_{$s}", array('label' => ucfirst($s), 'section' => 'veeping_socials', 'type' => 'url'));
    }

    /* === Section: Hero === */
    $wp_customize->add_section('veeping_hero', array('title' => 'بخش Hero صفحه اصلی', 'priority' => 40));
    $wp_customize->add_setting('veeping_hero_desc', array('default' => 'دسترسی به اینترنت جهانی با کمترین پینگ ممکن. مناسب برای گیمرها، استریمرها و کاربران حرفه‌ای که به سرعت واقعی نیاز دارند.', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('veeping_hero_desc', array('label' => 'توضیحات Hero', 'section' => 'veeping_hero', 'type' => 'textarea'));

    /* === Section: Footer === */
    $wp_customize->add_section('veeping_footer', array('title' => 'تنظیمات فوتر', 'priority' => 50));
    $wp_customize->add_setting('veeping_footer_custom_code', array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('veeping_footer_custom_code', array('label' => 'کد HTML سفارشی فوتر', 'section' => 'veeping_footer', 'type' => 'textarea'));

    /* Trust badges */
    $badges = array('enamad', 'samandehi', 'shekasteh');
    foreach ($badges as $badge) {
        $wp_customize->add_setting("veeping_{$badge}_enabled", array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
        $wp_customize->add_control("veeping_{$badge}_enabled", array('label' => "فعال‌سازی نماد {$badge}", 'section' => 'veeping_footer', 'type' => 'checkbox'));
        $wp_customize->add_setting("veeping_{$badge}_url", array('default' => "https://{$badge}.ir", 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("veeping_{$badge}_url", array('label' => "لینک نماد {$badge}", 'section' => 'veeping_footer', 'type' => 'url'));
    }

    $wp_customize->add_setting('veeping_copyright_text', array(
        'default' => '&copy; ' . date_i18n('Y') . ' ' . get_bloginfo('name') . '. تمامی حقوق محفوظ است.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('veeping_copyright_text', array('label' => 'متن کپی‌رایت سفارشی', 'section' => 'veeping_footer', 'type' => 'text'));
}
add_action('customize_register', 'veeping_customize_register');
