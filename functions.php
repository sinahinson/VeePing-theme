<?php
/**
 * Functions.php - قالب ویپینگ (Veeping)
 * نسخه: 1.6.0 - بهینه‌سازی موبایل، سرعت (TTFB) و امنیت (سئوی متا/schema به‌عهده افزونه Yoast SEO است)
 *
 * @package Veeping
 */

if (!defined('ABSPATH')) exit;

define('VEEPING_VERSION', '1.6.0');

$veeping_includes = array(
    'setup.php',
    'scripts.php',
    'performance.php',
    'helpers.php',
    'customizer.php',
    'woocommerce.php',
    'security.php',
    'comments.php',
);

foreach ($veeping_includes as $file) {
    $filepath = get_template_directory() . '/includes/' . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

