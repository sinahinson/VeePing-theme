<?php
/**
 * Footer Template - VeePing Theme
 * Supports custom code area for trust badges (Enamad, etc.)
 */

// Get custom footer code from Customizer
$footer_custom_code = get_theme_mod('veeping_footer_custom_code', '');

// Get trust badge settings
$enamad_enabled = get_theme_mod('veeping_enamad_enabled', false);
$enamad_url = get_theme_mod('veeping_enamad_url', 'https://enamad.ir');
$samandehi_enabled = get_theme_mod('veeping_samandehi_enabled', false);
$samandehi_url = get_theme_mod('veeping_samandehi_url', 'https://samandehi.ir');
$shekasteh_enabled = get_theme_mod('veeping_shekasteh_enabled', false);
$shekasteh_url = get_theme_mod('veeping_shekasteh_url', 'https://shekasteh.ir');

?>

</main><!-- #main -->

<!-- Footer -->
<footer id="colophon" class="bg-dark-900 border-t border-white/5 pt-16 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-12 mb-12">

            <!-- Brand & Description -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
                             alt="<?php bloginfo('name'); ?>"
                             class="w-11 h-11 object-contain drop-shadow-[0_0_10px_rgba(250,204,21,0.35)]"
                             width="44" height="44" loading="lazy">
                        <span class="font-black text-xl text-white"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-sm mb-8 pr-4 lg:pr-0">
                    <?php
                    $desc = get_bloginfo('description');
                    echo esc_html($desc ? $desc : 'پلتفرم پیشرفته برای مدیریت اتصالات اینترنتی. ما با ارائه زیرساخت‌های قدرتمند، تجربه‌ای سریع و امن را برای کاربران فراهم می‌کنیم.');
                    ?>
                </p>

                <!-- Social Links -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <?php
                    $socials = array(
                        'telegram'  => array('url' => get_theme_mod('veeping_telegram'),  'icon' => 'fa-telegram', 'label' => 'تلگرام'),
                        'instagram' => array('url' => get_theme_mod('veeping_instagram'), 'icon' => 'fa-instagram', 'label' => 'اینستاگرام'),
                        'twitter'   => array('url' => get_theme_mod('veeping_twitter'),   'icon' => 'fa-x-twitter', 'label' => 'توییتر (X)'),
                        'youtube'   => array('url' => get_theme_mod('veeping_youtube'),   'icon' => 'fa-youtube', 'label' => 'یوتیوب'),
                        'discord'   => array('url' => get_theme_mod('veeping_discord'),   'icon' => 'fa-discord', 'label' => 'دیسکورد'),
                    );
                    foreach ($socials as $key => $s) :
                        if ($s['url']) : ?>
                            <a href="<?php echo esc_url($s['url']); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr($s['label']); ?>"
                               class="w-11 h-11 rounded-full bg-dark-800 flex items-center justify-center text-gray-400 hover:bg-neon-gold hover:text-dark-900 transition-all duration-300 hover:scale-110 hover:shadow-[0_0_20px_rgba(250,204,21,0.4)]">
                                <i class="fa-brands <?php echo esc_attr($s['icon']); ?>"></i>
                            </a>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>

            <!-- Legal Links (Footer Legal) -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-black mb-6 text-sm tracking-wider uppercase">حقوقی و قانونی</h3>
                <?php if (has_nav_menu('footer-legal')) : ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-legal',
                        'container'      => false,
                        'menu_class'     => 'space-y-3 text-sm text-gray-500',
                        'link_class'     => 'flex items-center gap-2 hover:text-neon-gold transition-colors group',
                        'depth'          => 1,
                    )); ?>
                <?php else : ?>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-lock text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>حریم خصوصی</a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-of-service')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-file-contract text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>شرایط استفاده</a></li>
                        <li><a href="<?php echo esc_url(home_url('/refund-policy')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-rotate-left text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>قوانین بازگشت وجه</a></li>
                        <li><a href="<?php echo esc_url(home_url('/rules')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-gavel text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>قوانین و مقررات</a></li>
                        <li><a href="<?php echo esc_url(home_url('/cookie-policy')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-cookie-bite text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>سیاست کوکی‌ها</a></li>
                        <li><a href="<?php echo esc_url(home_url('/gdpr')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-shield-halved text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>GDPR و حقوق داده‌ها</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Contact Info -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-black mb-6 text-sm tracking-wider uppercase">ارتباط با ما</h3>
                <ul class="space-y-3 text-sm text-gray-500">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-neon-gold"></i>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('veeping_email', 'support@veeping.com')); ?>" class="hover:text-neon-gold transition">
                            <?php echo esc_html(get_theme_mod('veeping_email', 'support@veeping.com')); ?>
                        </a>
                    </li>
                    <?php if ($phone = get_theme_mod('veeping_phone')) : ?>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-neon-gold"></i>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="hover:text-neon-gold transition">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-headset text-neon-gold"></i>
                        <span class="text-gray-400">پشتیبانی آنلاین ۲۴/۷</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-neon-gold"></i>
                        <span class="text-gray-400">ایران، تهران</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-clock text-neon-gold"></i>
                        <span class="text-gray-400">شنبه - پنجشنبه: ۹ صبح - ۶ عصر</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-black mb-6 text-sm tracking-wider uppercase">دسترسی سریع</h3>
                <?php if (has_nav_menu('footer-quick')) : ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-quick',
                        'container'      => false,
                        'menu_class'     => 'space-y-3 text-sm text-gray-500',
                        'link_class'     => 'flex items-center gap-2 hover:text-neon-gold transition-colors group',
                        'depth'          => 1,
                    )); ?>
                <?php else : ?>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-house text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>خانه</a></li>
                        <li><a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/shop')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-shop text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>فروشگاه</a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-blog text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>وبلاگ</a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-circle-info text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>درباره ما</a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount') . 'tickets/'); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-headset text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>تماس با ما</a></li>
                        <li><a href="<?php echo esc_url(home_url('/faq')); ?>" class="flex items-center gap-2 hover:text-neon-gold transition-colors group"><i class="fa-solid fa-circle-question text-xs text-gray-500 group-hover:text-neon-gold transition-colors"></i>سوالات متداول</a></li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>

        <!-- Custom Code Area (for Enamad scripts, analytics, etc.) -->
        <?php if ($footer_custom_code) : ?>
            <div class="footer-custom-code mb-8" data-purpose="custom-footer-code">
                <?php echo wp_kses_post($footer_custom_code); ?>
            </div>
        <?php endif; ?>

        <!-- Bottom Bar -->
        <div class="border-t border-white/5 pt-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-600">
                <p class="text-center md:text-left">
                    <?php
                    $copyright = get_theme_mod('veeping_copyright_text', '&copy; ' . date_i18n('Y') . ' ' . get_bloginfo('name') . '. تمامی حقوق محفوظ است.');
                    $copyright = str_replace('{year}', date_i18n('Y'), $copyright);
                    $copyright = str_replace('{site_name}', get_bloginfo('name'), $copyright);
                    echo wp_kses_post($copyright);
                    ?>
                </p>

                <!-- Payment Badges / Powered By -->
                <div class="flex flex-wrap items-center justify-center md:justify-end gap-3 text-xs text-gray-500">
                    <?php if (class_exists('WooCommerce')) : ?>
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-white/5 border border-white/10 rounded">
                            <i class="fa-brands fa-cc-mada text-neon-gold"></i>
                            <span>پرداخت امن</span>
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-white/5 border border-white/10 rounded">
                            <i class="fa-solid fa-lock text-green-400"></i>
                            <span>SSL امن</span>
                        </span>
                    <?php endif; ?>
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-white/5 border border-white/10 rounded">
                        <i class="fa-solid fa-server text-neon-blue"></i>
                        <span>طراحی شده توسط Sina Hinson</span>
                    </span>
                </div>
            </div>
        </div>

    </div>
</footer>

<!-- قبل از wp_footer() -->
<div class="cursor-glow hidden md:block"></div>
<?php wp_footer(); ?>

</body>
</html>