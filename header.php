<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class('text-gray-100 antialiased'); ?> x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
<?php wp_body_open(); ?>

<!-- Page Loader -->
<div class="page-loader">
    <div class="loader-ring"></div>
</div>

<!-- Cursor Glow (دسکتاپ) -->
<div class="cursor-glow hidden md:block"></div>

<!-- Navbar -->
<nav class="site-navbar fixed w-full z-50 border-b border-white/5 bg-dark-900/80 backdrop-blur-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                <?php if (has_custom_logo()) : ?>
                    <div class="magnetic-btn max-h-9 sm:max-h-none [&_img]:max-h-9 sm:[&_img]:max-h-none"><?php the_custom_logo(); ?></div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 sm:gap-3 magnetic-btn group" rel="home">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
                             alt="<?php bloginfo('name'); ?>"
                             class="w-9 h-9 sm:w-12 sm:h-12 object-contain drop-shadow-[0_0_10px_rgba(250,204,21,0.35)] group-hover:scale-110 group-hover:drop-shadow-[0_0_16px_rgba(250,204,21,0.55)] transition-all duration-300"
                             width="48" height="48" loading="eager">
                        <span class="font-black text-lg sm:text-2xl text-white tracking-tight inline">
                            <?php bloginfo('name'); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Menu - کاملاً از وردپرس -->
            <div class="hidden md:block">
                <?php if (has_nav_menu('primary')) : ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'flex items-center gap-2',
                        'link_class'     => 'nav-link-magic text-gray-300 hover:text-white px-4 py-2 text-sm font-bold transition-all duration-300 relative',
                        'depth'          => 2,
                        'submenu_class'  => 'absolute top-full right-0 min-w-[220px] glass-card rounded-xl mt-2 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300',
                        'submenu_link_class' => 'block px-5 py-3 text-sm text-gray-300 hover:text-neon-gold hover:bg-white/5 transition-colors',
                    ));
                    ?>
                <?php else : ?>
                    <ul class="flex items-center gap-2">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link-magic text-white px-4 py-2 text-sm font-bold active">خانه</a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'pw-services/'); ?>" class="nav-link-magic text-gray-300 hover:text-white px-4 py-2 text-sm font-bold transition">سرویس‌ها</a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'orders/'); ?>" class="nav-link-magic text-gray-300 hover:text-white px-4 py-2 text-sm font-bold transition">سفارشات</a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'my-wallet/'); ?>" class="nav-link-magic text-gray-300 hover:text-white px-4 py-2 text-sm font-bold transition">کیف پول</a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'tickets/'); ?>" class="nav-link-magic text-gray-300 hover:text-white px-4 py-2 text-sm font-bold transition">پشتیبانی</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="hidden md:flex items-center gap-3">

                <!-- دکمه قیمت سرویس‌ها -->
                <a href="<?php echo esc_url(home_url('/shop')); ?>"
                   class="magnetic-btn btn-outline-glow px-4 py-2 rounded-lg text-xs text-white inline-flex items-center gap-1.5 hidden sm:flex">
                    <i class="fa-solid fa-tags"></i>
                    <span>محصولات</span>
                </a>

<!-- دکمه سرویس‌های من -->
<?php if (is_user_logged_in()) : ?>
    <a href="<?php echo esc_url(wc_get_endpoint_url('pw-services', '', wc_get_page_permalink('myaccount'))); ?>" class="magnetic-btn btn-premium btn-ripple px-4 py-2 rounded-lg text-xs inline-flex items-center gap-1.5">
        <i class="fa-solid fa-cube"></i>
        <span>سرویس‌های من</span>
        <i class="fa-solid fa-arrow-left text-xs"></i>
    </a>
<?php else : ?>
    <a href="<?php echo esc_url(wc_get_endpoint_url('pw-services', '', wc_get_page_permalink('myaccount'))); ?>" class="magnetic-btn btn-outline-glow px-4 py-2 rounded-lg text-xs text-white inline-flex items-center gap-1.5">
        <i class="fa-solid fa-cube"></i>
        <span>پنل کاربری</span>
    </a>
<?php endif; ?>

                <!-- دکمه‌های کاربری -->
                <?php if (is_user_logged_in()) : ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" aria-haspopup="true" :aria-expanded="open.toString()" aria-label="منوی کاربری" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition">
                            <?php echo get_avatar(get_current_user_id(), 28, '', '', array('class' => 'w-7 h-7 rounded-full border-2 border-neon-gold')); ?>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-0 mt-2 w-56 glass-card rounded-xl overflow-hidden">
                            <div class="px-4 py-3 border-b border-white/10">
                                <p class="text-white font-bold text-sm"><?php echo esc_html(wp_get_current_user()->display_name); ?></p>
                                <p class="text-gray-500 text-xs truncate"><?php echo esc_html(wp_get_current_user()->user_email); ?></p>
                            </div>
                            <?php if (class_exists('WooCommerce')) : ?>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-regular fa-user w-4"></i> داشبورد
                                </a>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'pw-services/'); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-solid fa-cube w-4"></i> سرویس‌های من
                                </a>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'orders/'); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-solid fa-box w-4"></i> سفارش‌ها
                                </a>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'tickets/'); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-solid fa-headset w-4"></i> پشتیبانی
                                </a>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'edit-account/'); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-solid fa-user-cog w-4"></i> تنظیمات حساب
                                </a>
                                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-neon-gold transition">
                                    <i class="fa-solid fa-credit-card w-4"></i> تسویه حساب
                                </a>
                            <?php endif; ?>
                            <div class="border-t border-white/10">
                                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> خروج
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                       class="magnetic-btn btn-premium btn-ripple px-6 py-2.5 rounded-xl text-sm inline-flex items-center gap-2">
                        <span>عضویت و تست رایگان</span>
                        <i class="fa-solid fa-rocket text-xs"></i>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center gap-2">
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-premium px-2.5 py-1.5 rounded-md text-xs font-black">
                        <i class="fa-solid fa-tags"></i>
                    </a>
                <?php endif; ?>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" aria-haspopup="true" :aria-expanded="mobileMenuOpen.toString()" :aria-label="mobileMenuOpen ? 'بستن منو' : 'باز کردن منو'" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none">
                    <i class="fa-solid text-2xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-dark-900/95 backdrop-blur-xl border-b border-white/10 max-h-[80vh] overflow-y-auto">
        <div class="px-4 py-4 space-y-1">
            <?php if (has_nav_menu('primary')) : ?>
                <?php
                $mobile_menu = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
                if ($mobile_menu) {
                    foreach ($mobile_menu as $item) {
                        $classes = 'block px-4 py-3 rounded-xl text-base font-bold transition-all';
                        $is_current = in_array('current-menu-item', $item->classes, true) || in_array('current-menu-ancestor', $item->classes, true);
                        echo '<a href="' . esc_url($item->url) . '" class="' . $classes . ' ' . ($is_current ? 'bg-neon-gold/10 text-neon-gold border-r-4 border-neon-gold' : 'text-gray-300 hover:bg-white/5 hover:text-white') . '">';
                        echo esc_html($item->title);
                        echo '</a>';
                    }
                }
                ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="block px-4 py-3 rounded-xl text-base font-bold bg-neon-gold/10 text-neon-gold border-r-4 border-neon-gold">خانه</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'pw-services/'); ?>" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-300 hover:bg-white/5">سرویس‌ها</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'orders/'); ?>" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-300 hover:bg-white/5">سفارشات</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'my-wallet/'); ?>" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-300 hover:bg-white/5">کیف پول</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'tickets/'); ?>" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-300 hover:bg-white/5">پشتیبانی</a>
            <?php endif; ?>

            <div class="mt-4 pt-4 border-t border-white/10 flex flex-col gap-2">
                <?php if (!is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : wp_registration_url()); ?>" class="text-center btn-premium py-3 rounded-xl font-black">
                        عضویت و تست رایگان <i class="fa-solid fa-rocket mr-1"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main id="main" class="site-main">