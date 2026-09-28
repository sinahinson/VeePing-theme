<?php get_header(); ?>

<!-- ============ HERO SECTION ============ -->
<section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16 sm:pt-20">

    <!-- لایه‌های پس‌زمینه -->
    <div class="absolute inset-0 grid-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-dark-900/50 to-dark-900"></div>

    <!-- اُرب‌های شناور -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-neon-gold/20 rounded-full blur-[120px] animate-[orb-float_15s_ease-in-out_infinite]"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-neon-blue/20 rounded-full blur-[120px] animate-[orb-float_20s_ease-in-out_infinite_reverse]"></div>

    <!-- تصاویر شناور بازی‌ها در پس‌زمینه -->
    <?php $gimg = get_template_directory_uri() . '/assets/images/games'; ?>
    <div class="floating-game w-32 h-44 top-[15%] right-[8%] rotate-6 hidden lg:block" style="animation: float 8s ease-in-out infinite;">
        <picture>
            <source srcset="<?php echo esc_url("$gimg/cs2.webp"); ?>" type="image/webp">
            <img src="<?php echo esc_url("$gimg/cs2.jpg"); ?>" alt="CS2" width="128" height="176" loading="lazy" decoding="async">
        </picture>
    </div>
    <div class="floating-game w-28 h-36 top-[60%] left-[5%] -rotate-3 hidden lg:block" style="animation: float 10s ease-in-out infinite 2s;">
        <picture>
            <source srcset="<?php echo esc_url("$gimg/pubg.webp"); ?>" type="image/webp">
            <img src="<?php echo esc_url("$gimg/pubg.jpg"); ?>" alt="PUBG" width="112" height="144" loading="lazy" decoding="async">
        </picture>
    </div>
    <div class="floating-game w-24 h-32 top-[20%] left-[12%] rotate-12 hidden xl:block" style="animation: float 12s ease-in-out infinite 4s;">
        <picture>
            <source srcset="<?php echo esc_url("$gimg/gtav.webp"); ?>" type="image/webp">
            <img src="<?php echo esc_url("$gimg/gtav.jpg"); ?>" alt="GTA V" width="96" height="128" loading="lazy" decoding="async">
        </picture>
    </div>
    <div class="floating-game w-20 h-28 bottom-[15%] right-[15%] -rotate-6 hidden xl:block" style="animation: float 9s ease-in-out infinite 1s;">
        <picture>
            <source srcset="<?php echo esc_url("$gimg/apex.webp"); ?>" type="image/webp">
            <img src="<?php echo esc_url("$gimg/apex.jpg"); ?>" alt="Apex Legends" width="80" height="112" loading="lazy" decoding="async">
        </picture>
    </div>

    <!-- پارتیکل‌ها -->
    <div class="particles-container absolute inset-0 overflow-hidden"></div>

    <!-- محتوای اصلی -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <!-- Badge -->
        <div class="reveal inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 mb-8 backdrop-blur-md float-badge">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <span class="text-xs sm:text-sm font-bold text-gray-200">سرورهای فعال و آماده اتصال آنی</span>
            <span class="px-2 py-0.5 bg-neon-gold/20 text-neon-gold text-xs font-black rounded-full">PRO</span>
        </div>

        <!-- تیتر اصلی -->
        <h1 class="reveal delay-100 text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black text-white tracking-tight mb-6 leading-[1.1]">
            بازی کن، بدون
            <span class="relative inline-block">
                <span class="fancy-text" data-text="لگ و قطعی">لگ و قطعی</span>
                <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 200 12" fill="none">
                    <path d="M2 10C50 4 100 2 198 6" stroke="url(#grad1)" stroke-width="3" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="grad1" x1="0" y1="0" x2="200" y2="0">
                            <stop offset="0%" stop-color="#facc15"/>
                            <stop offset="100%" stop-color="#3b82f6"/>
                        </linearGradient>
                    </defs>
                </svg>
            </span>
        </h1>

        <!-- توضیحات -->
        <p class="reveal delay-200 mt-8 max-w-3xl mx-auto text-lg sm:text-xl text-gray-300 leading-relaxed">
            <?php
            $desc = get_theme_mod('veeping_hero_desc', 'دسترسی به اینترنت جهانی با کمترین پینگ ممکن. مناسب برای گیمرها، استریمرها و کاربران حرفه‌ای که به سرعت واقعی نیاز دارند.');
            echo esc_html($desc);
            ?>
        </p>

        <!-- دکمه‌ها -->
        <div class="reveal delay-300 mt-8 flex flex-col sm:flex-row justify-center gap-3">
            <a href="#pricing"
               class="magnetic-btn btn-premium btn-ripple group relative px-6 py-3 rounded-xl text-sm sm:text-base inline-flex items-center justify-center gap-2 overflow-hidden">
                <span class="relative z-10 flex items-center gap-2">
                    <i class="fa-solid fa-tags text-base"></i>
                    <span>قیمت سرویس‌ها</span>
                    <i class="fa-solid fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform duration-300"></i>
                </span>
            </a>
            <a href="#how-it-works" class="magnetic-btn btn-outline-glow px-6 py-3 rounded-xl text-sm sm:text-base text-white font-bold inline-flex items-center justify-center gap-2 backdrop-blur-sm">
                <i class="fa-solid fa-play text-neon-gold text-sm"></i>
                <span>چطور کار می‌کنه؟</span>
            </a>
        </div>

        <!-- آمار -->
        <div class="reveal delay-400 mt-20 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <?php
            $stats = array(
                array('value' => '99.9', 'suffix' => '%', 'label' => 'آپتایم سرور', 'icon' => 'fa-server', 'color' => 'neon-gold'),
                array('value' => '15',   'suffix' => 'ms', 'label' => 'میانگین پینگ', 'icon' => 'fa-gauge-high', 'color' => 'neon-blue'),
                array('value' => '5000', 'suffix' => '+', 'label' => 'کاربر فعال', 'icon' => 'fa-users', 'color' => 'neon-purple'),
                array('value' => '24',   'suffix' => '/7', 'label' => 'پشتیبانی زنده', 'icon' => 'fa-headset', 'color' => 'green-400'),
            );
            foreach ($stats as $s) : ?>
                <div class="gaming-stat glass-card p-6 rounded-2xl hover:bg-white/5 transition-all duration-300 group cursor-pointer">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <i class="fa-solid <?php echo esc_attr($s['icon']); ?> text-<?php echo esc_attr($s['color']); ?> text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-3xl sm:text-4xl font-black counter" data-target="<?php echo esc_attr($s['value']); ?>" data-suffix="<?php echo esc_attr($s['suffix']); ?>">0</span>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-bold"><?php echo esc_html($s['label']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- نشانگر اسکرول -->
        <div class="hidden md:block scroll-indicator mt-16 opacity-50"></div>
    </div>
</section>


<!-- ============ GAMING SHOWCASE SECTION ============ -->
<section id="games" class="relative py-12 sm:py-16 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-dark-900 via-dark-800/50 to-dark-900"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-8 sm:mb-10">
            <span class="reveal inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-neon-gold/10 border border-neon-gold/30 text-neon-gold text-xs font-black tracking-wider mb-4">
                <i class="fa-solid fa-gamepad"></i>
                بازی‌های محبوب
            </span>
            <h2 class="reveal delay-100 text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4 leading-tight">
                روی <span class="fancy-text">هر بازی‌ای</span> که دوست داری
            </h2>
            <p class="reveal delay-200 text-gray-400 max-w-2xl mx-auto text-base sm:text-lg">
                با پینگ فوق پایین، تجربه‌ای بی‌نظیر از بازی آنلاین داشته باش
            </p>
        </div>

        <!-- گرید تصاویر بازی‌ها -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 mb-8 sm:mb-12">
            <?php
            $g = get_template_directory_uri() . '/assets/images/games';
            $games = array(
                array('name' => 'Valorant',        'ping' => '33ms',  'img' => "$g/valorant.jpg",  'color' => 'neon-gold'),
                array('name' => 'Fortnite',         'ping' => '42ms', 'img' => "$g/fortnite.jpg",   'color' => 'neon-blue'),
                array('name' => 'CS2',              'ping' => '34ms',  'img' => "$g/cs2.jpg",        'color' => 'neon-purple'),
                array('name' => 'League of Legends', 'ping' => '46ms', 'img' => "$g/lol.jpg",       'color' => 'green-400'),
                array('name' => 'Apex Legends',     'ping' => '57ms', 'img' => "$g/apex.jpg",       'color' => 'neon-gold'),
                array('name' => 'PUBG',             'ping' => '35ms', 'img' => "$g/pubg.jpg",       'color' => 'neon-blue'),
                array('name' => 'GTA V',            'ping' => '58ms', 'img' => "$g/gtav.jpg",       'color' => 'neon-purple'),
                array('name' => 'Minecraft',        'ping' => '61ms',  'img' => "$g/minecraft.jpg",   'color' => 'green-400'),
            );
            foreach ($games as $i => $game) :
                $delay = ($i % 4 + 1) * 80; ?>
                <div class="hero-game-card reveal-scale" style="transition-delay: <?php echo $delay; ?>ms">
                    <picture>
                        <source srcset="<?php echo esc_url(preg_replace('/\.jpg$/', '.webp', $game['img'])); ?>" type="image/webp">
                        <img src="<?php echo esc_url($game['img']); ?>" alt="<?php echo esc_attr($game['name'] . ' - سرور اختصاصی کم پینگ'); ?>" width="300" height="300" loading="lazy" decoding="async">
                    </picture>
                    <div class="game-overlay">
                        <div class="flex items-center justify-between">
                            <p class="text-white font-black text-sm sm:text-base m-0"><strong><?php echo esc_html($game['name']); ?></strong></p>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-<?php echo esc_attr($game['color']); ?>/20 text-<?php echo esc_attr($game['color']); ?> text-xs font-black">
                                <i class="fa-solid fa-bolt text-[10px]"></i>
                                <?php echo esc_html($game['ping']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ PRICING SECTION ============ -->
<section id="pricing" class="relative py-14 sm:py-20 overflow-hidden bg-dark-800/30 border-y border-white/5">

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-neon-gold/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10 sm:mb-14">
            <span class="reveal inline-block px-3 py-1 rounded-full bg-neon-gold/10 border border-neon-gold/30 text-neon-gold text-xs font-black tracking-wider mb-3">تعرفه‌ها</span>
            <h2 class="reveal delay-100 text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3 sm:mb-4 leading-tight">
                پلن مناسب <span class="fancy-text">خودت</span> رو انتخاب کن
            </h2>
            <p class="reveal delay-200 text-gray-400 max-w-2xl mx-auto text-sm sm:text-base">
                قیمت‌های شفاف و بدون هزینه پنهان - محصولات ویژه ما
            </p>
        </div>

        <?php
        $featured_ids = veeping_get_featured_product_ids();
        $featured_products = !empty($featured_ids)
            ? new WP_Query(array(
                'post_type'      => 'product',
                'post__in'       => $featured_ids,
                'orderby'        => 'post__in',
                'posts_per_page' => 12,
            ))
            : new WP_Query(array('post__in' => array(0), 'post_type' => 'product'));

        if ($featured_products->have_posts()) :
            $total = $featured_products->found_posts;
            $middle_index = floor($total / 2);
            $current_index = 0;
        ?>

            <div class="relative pricing-carousel-wrap">

                <!-- راهنما + فلش‌ها (موبایل) -->
                <div class="flex items-center justify-between mb-4 md:hidden">
                    <p class="text-xs text-gray-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrows-left-right text-neon-gold"></i>
                        برای دیدن بقیه پلن‌ها بکشید
                    </p>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="veepingScrollCarousel('pricing-scroll', -1)" aria-label="پلن قبلی"
                                class="pricing-scroll-btn flex items-center justify-center w-8 h-8 rounded-full glass-card text-neon-gold hover:bg-neon-gold hover:text-dark-900 transition-all duration-300">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                        <button type="button" onclick="veepingScrollCarousel('pricing-scroll', 1)" aria-label="پلن بعدی"
                                class="pricing-scroll-btn flex items-center justify-center w-8 h-8 rounded-full glass-card text-neon-gold hover:bg-neon-gold hover:text-dark-900 transition-all duration-300">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- فلش‌های کناری، وسط‌چین عمودی (دسکتاپ و صفحات بزرگ) -->
                <button type="button" onclick="veepingScrollCarousel('pricing-scroll', -1)" aria-label="پلن قبلی"
                        class="pricing-scroll-btn hidden md:flex items-center justify-center absolute top-1/2 -translate-y-1/2 -right-4 lg:-right-5 z-20 w-10 h-10 lg:w-11 lg:h-11 rounded-full glass-card text-neon-gold hover:bg-neon-gold hover:text-dark-900 transition-all duration-300">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" onclick="veepingScrollCarousel('pricing-scroll', 1)" aria-label="پلن بعدی"
                        class="pricing-scroll-btn hidden md:flex items-center justify-center absolute top-1/2 -translate-y-1/2 -left-4 lg:-left-5 z-20 w-10 h-10 lg:w-11 lg:h-11 rounded-full glass-card text-neon-gold hover:bg-neon-gold hover:text-dark-900 transition-all duration-300">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div id="pricing-scroll" class="pricing-scroll flex items-stretch gap-4 sm:gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 -mx-4 px-4 sm:mx-0 sm:px-1">

                <?php while ($featured_products->have_posts()) : $featured_products->the_post();
                    global $product;
                    if (!$product || !$product->is_visible()) continue;

                    $is_featured_card = ($current_index === $middle_index);
                    $current_index++;

                    $categories = get_the_terms(get_the_ID(), 'product_cat');
                    $cat_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : '';

                    $short_desc = $product->get_short_description();
                    $product_features = array();
                    $attributes = $product->get_attributes();
                    foreach ($attributes as $attr) {
                        $values = wc_get_product_terms($product->get_id(), $attr['name'], array('fields' => 'names'));
                        if ($values) $product_features[] = wc_attribute_label($attr['name']) . ': ' . implode('، ', $values);
                    }
                    if (empty($product_features)) $product_features = array('دسترسی فوری پس از پرداخت', 'پشتیبانی ۲۴ ساعته', 'ضمانت بازگشت وجه', 'تحویل خودکار');

                    $is_variable = $product->is_type('variable');

                    // داده واریانت‌ها برای خرید سریع (JS)
                    $variations_payload = array();
                    if ($is_variable) {
                        foreach ($product->get_available_variations() as $v) {
                            $variations_payload[] = array(
                                'id'         => $v['variation_id'],
                                'attributes' => $v['attributes'],
                                'price_html' => wc_price($v['display_price']),
                                'in_stock'   => (bool) $v['is_in_stock'],
                            );
                        }
                    }
                ?>

                <div class="reveal-scale pricing-card group snap-start shrink-0 w-[78vw] sm:w-72 md:w-80 <?php echo $is_featured_card ? 'featured' : ''; ?>" style="transition-delay: <?php echo min($current_index, 4) * 100; ?>ms">
                    <div class="glass-card p-5 sm:p-6 rounded-2xl h-full flex flex-col relative overflow-hidden">
                        <?php if ($is_featured_card) : ?>
                            <div class="absolute inset-0 bg-gradient-to-br from-neon-gold/10 via-transparent to-neon-blue/10 pointer-events-none"></div>
                        <?php endif; ?>

                        <!-- تصویر محصول (مربعی، ریسپانسیو) -->
                        <div class="relative mb-4 aspect-square w-full rounded-xl overflow-hidden bg-white/5 ring-1 ring-white/10">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array(
                                    'class'   => 'absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                                    'loading' => 'lazy',
                                    'alt'     => esc_attr(get_the_title()),
                                )); ?>
                            <?php else : ?>
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-white/5 to-white/0">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
                                         alt="<?php echo esc_attr(get_the_title()); ?>"
                                         class="w-1/2 h-1/2 object-contain opacity-70 transition-transform duration-500 group-hover:scale-105"
                                         width="120" height="120" loading="lazy" decoding="async">
                                </div>
                            <?php endif; ?>
                            <?php if ($is_featured_card) : ?>
                                <span class="absolute top-2 right-2 inline-flex items-center gap-1 bg-gradient-to-r from-neon-gold to-orange-500 text-dark-900 text-[10px] font-black px-2.5 py-1 rounded-full shadow-lg">
                                    <i class="fa-solid fa-star"></i> محبوب
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="relative mb-4">
                            <p class="text-lg font-black text-white leading-tight m-0"><strong><?php echo esc_html(get_the_title()); ?></strong></p>
                            <?php if ($cat_name) : ?>
                                <p class="text-gray-500 text-xs mt-0.5"><?php echo esc_html($cat_name); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- ============ قیمت + انتخاب گزینه‌ها (خرید سریع) ============ -->
                        <div class="relative mb-4 quick-buy-block"
                             data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                             data-variable="<?php echo $is_variable ? '1' : '0'; ?>"
                             <?php if ($is_variable && !empty($variations_payload)) : ?>
                             data-variations="<?php echo esc_attr(wp_json_encode($variations_payload)); ?>"
                             <?php endif; ?>>

                            <?php if ($is_variable) : ?>

                                <div class="space-y-2 mb-3">
                                    <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1"><?php echo esc_html(wc_attribute_label($attribute_name)); ?></label>
                                            <?php
                                            wc_dropdown_variation_attribute_options(array(
                                                'options'   => $options,
                                                'attribute' => $attribute_name,
                                                'product'   => $product,
                                                'class'     => 'quick-buy-attribute w-full',
                                            ));
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="flex items-baseline gap-2">
                                    <span class="quick-buy-price text-xl font-black text-gray-500">یک گزینه انتخاب کنید</span>
                                </div>

                            <?php else : ?>

                                <?php if ($product->is_on_sale()) : ?>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-black fancy-text"><?php echo wc_price($product->get_sale_price()); ?></span>
                                        <span class="text-sm text-gray-500 line-through"><?php echo wc_price($product->get_regular_price()); ?></span>
                                    </div>
                                    <?php
                                    $regular = (float)$product->get_regular_price();
                                    $sale = (float)$product->get_sale_price();
                                    if ($regular > 0) $discount = round((($regular - $sale) / $regular) * 100);
                                    ?>
                                    <span class="inline-block bg-red-500/20 text-red-400 text-xs font-black px-2 py-0.5 rounded-full mt-1"><?php echo $discount; ?>٪ تخفیف</span>
                                <?php else : ?>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-black <?php echo $is_featured_card ? 'fancy-text' : 'text-white'; ?>">
                                            <?php echo $product->get_regular_price() ? wc_price($product->get_regular_price()) : __('رایگان', 'veeping'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>

                            <p class="quick-buy-error text-red-400 text-xs mt-2 hidden"></p>
                        </div>

                        <?php if ($short_desc) : ?>
                            <p class="relative text-gray-400 text-xs leading-relaxed mb-3 line-clamp-2">
                                <?php echo esc_html(wp_trim_words(strip_tags($short_desc), 16)); ?>
                            </p>
                        <?php endif; ?>

                        <ul class="check-list relative space-y-2 text-gray-300 mb-4 flex-grow">
                            <?php foreach (array_slice($product_features, 0, 3) as $feature) : ?>
                                <li class="text-xs"><?php echo esc_html($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <button type="button"
                                class="quick-buy-btn <?php echo $is_featured_card ? 'btn-premium btn-ripple' : 'btn-outline-glow'; ?> magnetic-btn relative block w-full text-center py-2.5 rounded-xl font-black text-sm"
                                data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                                data-permalink="<?php echo esc_url(get_permalink()); ?>"
                                <?php echo $is_variable ? 'disabled' : ''; ?>>
                            <span class="relative z-10 inline-flex items-center justify-center gap-2 quick-buy-btn-label">
                                <i class="fa-solid fa-cart-shopping text-xs"></i>
                                <span><?php echo $is_variable ? 'ابتدا گزینه را انتخاب کنید' : ($is_featured_card ? 'خرید پلن محبوب' : 'خرید پلن'); ?></span>
                            </span>
                            <span class="relative z-10 items-center justify-center gap-2 quick-buy-btn-loading hidden">
                                <i class="fa-solid fa-circle-notch fa-spin"></i>
                                <span>در حال ثبت...</span>
                            </span>
                        </button>
                    </div>
                </div>

                <?php endwhile; ?>

                </div>
            </div>

            <div class="reveal text-center mt-10">
                <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/')); ?>"
                   class="magnetic-btn btn-ripple inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-white/5 border border-white/20 text-white text-sm font-bold hover:bg-white/10 hover:border-neon-gold transition">
                    <span>مشاهده همه محصولات</span>
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
            </div>

        <?php wp_reset_postdata(); else : ?>

            <div class="reveal glass-card rounded-3xl p-12 text-center max-w-2xl mx-auto">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-neon-gold/10 border border-neon-gold/30">
                    <i class="fa-solid fa-gem text-3xl text-neon-gold"></i>
                </div>
                <p class="text-2xl font-black text-white mb-3"><strong>هنوز پلنی اضافه نشده!</strong></p>
                <p class="text-gray-400 mb-6">برای نمایش پلن‌ها در این بخش، محصولات خود را در ووکامرس به عنوان <strong class="text-neon-gold">محصول ویژه</strong> علامت بزنید.</p>
                <?php if (current_user_can('manage_options')) : ?>
                    <a href="<?php echo esc_url(admin_url('post-new.php?post_type=product')); ?>" class="magnetic-btn btn-premium btn-ripple inline-flex items-center gap-2 px-8 py-4 rounded-xl font-black">
                        <i class="fa-solid fa-plus"></i>
                        افزودن اولین محصول
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>
</section>
<!-- ============ FEATURES SECTION ============ -->
<section id="features" class="relative py-14 sm:py-20 overflow-hidden bg-dark-800/30 border-y border-white/5">

    <!-- عناصر تزئینی متحرک -->
    <div class="absolute top-0 right-0 w-72 h-72 bg-neon-gold/5 rounded-full blur-3xl animate-[orb-float_15s_ease-in-out_infinite]"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-neon-blue/5 rounded-full blur-3xl animate-[orb-float_20s_ease-in-out_infinite_reverse]"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-neon-purple/5 rounded-full blur-3xl animate-pulse"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-8 sm:mb-12">
            <span class="reveal inline-block px-4 py-1.5 rounded-full bg-neon-gold/10 border border-neon-gold/30 text-neon-gold text-xs font-black tracking-wider mb-4">ویژگی‌ها</span>
            <h2 class="reveal delay-100 text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                چرا <span class="fancy-text"><?php bloginfo('name'); ?></span>؟
            </h2>
            <p class="reveal delay-200 text-gray-400 max-w-2xl mx-auto text-lg">
                همه‌چیزهایی که از یک سرویس حرفه‌ای انتظار دارید، در یک‌جا
            </p>
        </div>

        <!-- ویژگی‌ها -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <?php
            $features = array(
                array('icon' => 'fa-bolt-lightning', 'color' => 'neon-gold',  'title' => 'سرعت نور',              'desc' => 'اتصال مستقیم و بدون واسطه'),
                array('icon' => 'fa-shield-halved',  'color' => 'neon-blue',  'title' => 'امنیت و حریم خصوصی',     'desc' => 'رمزگذاری AES-256 و بدون لاگ'),
                array('icon' => 'fa-rocket',         'color' => 'neon-purple','title' => 'راه‌اندازی فوری',        'desc' => 'دریافت کانفیگ در کمتر از ۱ دقیقه'),
                array('icon' => 'fa-globe',          'color' => 'green-400',  'title' => 'سرورهای جهانی',          'desc' => 'بیش از ۵۰ سرور در ۳۰ کشور'),
                array('icon' => 'fa-headset',        'color' => 'neon-gold',  'title' => 'پشتیبانی ۲۴/۷',          'desc' => 'تیم پشتیبانی همیشه در دسترس'),
                array('icon' => 'fa-gauge-high',     'color' => 'neon-blue',  'title' => 'پهنای باند نامحدود',     'desc' => 'بدون محدودیت حجمی و سرعتی'),
            );
            foreach ($features as $i => $f) :
                $delay = ($i % 3 + 1) * 100; ?>
                <div class="reveal-scale" style="transition-delay: <?php echo $delay; ?>ms">
                    <div class="glass-card group p-5 sm:p-6 rounded-2xl h-full flex sm:flex-col items-center sm:items-start gap-4 sm:gap-0 hover:bg-white/5 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex-shrink-0 inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 sm:mb-4 rounded-xl bg-<?php echo esc_attr($f['color']); ?>/10 text-<?php echo esc_attr($f['color']); ?> text-xl sm:text-2xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid <?php echo esc_attr($f['icon']); ?>"></i>
                        </div>
                        <div>
                            <p class="text-base sm:text-lg font-black text-white mb-1 sm:mb-2">
                                <strong><?php echo esc_html($f['title']); ?></strong>
                            </p>
                            <p class="text-gray-400 text-xs sm:text-sm leading-relaxed">
                                <?php echo esc_html($f['desc']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ============ HOW IT WORKS ============ -->
<section id="how-it-works" class="relative py-14 sm:py-20 overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10 sm:mb-14">
            <span class="reveal inline-block px-4 py-1.5 rounded-full bg-neon-purple/10 border border-neon-purple/30 text-neon-purple text-xs font-black tracking-wider mb-4">مراحل</span>
            <h2 class="reveal delay-100 text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                در <span class="fancy-text">۳ مرحله</span> شروع کنید
            </h2>
            <p class="reveal delay-200 text-gray-400 max-w-2xl mx-auto text-lg">
                ساده‌تر از آنچه فکر می‌کنید، فقط چند دقیقه با دنیای بدون محدودیت فاصله دارید
            </p>
        </div>

        <!-- مراحل -->
        <div class="relative">
            <div class="hidden md:block absolute top-20 left-0 right-0 h-1 bg-gradient-to-r from-neon-gold via-neon-blue to-neon-purple opacity-30"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <?php
                $steps = array(
                    array('num' => '۰۱', 'icon' => 'fa-user-plus', 'color' => 'neon-gold', 'title' => 'ثبت‌نام کنید', 'desc' => 'در کمتر از ۳۰ ثانیه حساب کاربری خود را با ایمیل یا شماره موبایل بسازید.', 'gradient' => 'from-neon-gold to-orange-500'),
                    array('num' => '۰۲', 'icon' => 'fa-wallet',    'color' => 'neon-blue', 'title' => 'شارژ کیف پول', 'desc' => 'از طریق درگاه بانکی یا کارت به کارت، کیف پول خود را شارژ کنید.', 'gradient' => 'from-neon-blue to-cyan-500'),
                    array('num' => '۰۳', 'icon' => 'fa-rocket',    'color' => 'neon-purple', 'title' => 'اتصال فوری', 'desc' => 'سرویس مورد نظر را انتخاب کرده و بلافاصله کانفیگ اختصاصی دریافت کنید.', 'gradient' => 'from-neon-purple to-pink-500'),
                );
                foreach ($steps as $i => $step) :
                    $delay = ($i + 1) * 150; ?>
                    <div class="reveal-scale" style="transition-delay: <?php echo $delay; ?>ms">
                        <div class="relative glass-card p-8 rounded-2xl text-center group hover:bg-white/5 transition-all duration-500">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-8xl font-black text-white/5 group-hover:text-neon-gold/10 transition-colors select-none">
                                <?php echo $step['num']; ?>
                            </div>
                            <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-gradient-to-br <?php echo esc_attr($step['gradient']); ?> group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <i class="fa-solid <?php echo esc_attr($step['icon']); ?> text-3xl text-white"></i>
                                <div class="absolute inset-0 rounded-full bg-white/30 opacity-0 group-hover:opacity-100 group-hover:animate-ping"></div>
                            </div>
                            <h3 class="text-xl font-black text-white mb-3"><?php echo esc_html($step['title']); ?></h3>
                            <p class="text-gray-400 text-sm leading-relaxed"><?php echo esc_html($step['desc']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>




<!-- ============ FAQ SECTION ============ -->
<section id="faq" class="relative py-14 sm:py-20 overflow-hidden bg-dark-800/30 border-y border-white/5">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-8 sm:mb-12">
            <span class="reveal inline-block px-4 py-1.5 rounded-full bg-neon-purple/10 border border-neon-purple/30 text-neon-purple text-xs font-black tracking-wider mb-4">سوالات متداول</span>
            <h2 class="reveal delay-100 text-4xl sm:text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                جواب <span class="fancy-text">سوالاتت</span> رو پیدا کن
            </h2>
        </div>

        <div class="space-y-4" x-data="{ openFaq: null }">
            <?php
            $faqs = array(
                array('q' => 'چطور می‌تونم سرویس بخرم؟', 'a' => 'بعد از ثبت‌نام و شارژ کیف پول، به صفحه «سرویس‌های من» در پنل کاربری مراجعه کرده و پلن مورد نظرتون رو انتخاب کنید.'),
                array('q' => 'آیا دوره تست رایگان دارید؟', 'a' => 'بله! با ثبت‌نام در وب‌سایت، مبلغ ۱۰,۰۰۰ تومان به‌صورت خودکار به کیف پول شما اضافه می‌شود تا بتوانید سرویس را تست کنید.'),
                array('q' => 'روی چه دستگاه‌هایی قابل استفاده است؟', 'a' => 'سرویس ما روی تمامی دستگاه‌ها شامل ویندوز، مک، لینوکس، اندروید و iOS قابل استفاده است.'),
                array('q' => 'سرعت شما واقعاً چقدر است؟', 'a' => 'میانگین پینگ ما در سرورهای نزدیک زیر ۲۰ms و در سرورهای دور حدود ۵۰-۸۰ms است که برای اکثر استفاده‌ها ایده‌آل است.'),
            );
            foreach ($faqs as $i => $faq) :
                $delay = ($i + 1) * 100; ?>
                <div class="reveal" style="transition-delay: <?php echo $delay; ?>ms">
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <button @click="openFaq = (openFaq === <?php echo $i; ?> ? null : <?php echo $i; ?>)"
                                class="w-full px-6 py-5 flex items-center justify-between text-right hover:bg-white/5 transition">
                            <span class="font-black text-white text-lg"><?php echo esc_html($faq['q']); ?></span>
                            <i class="fa-solid transition-transform duration-300 text-neon-gold"
                               :class="openFaq === <?php echo $i; ?> ? 'fa-minus rotate-180' : 'fa-plus'"></i>
                        </button>
                        <div x-show="openFaq === <?php echo $i; ?>"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="px-6 pb-5 text-gray-300 leading-relaxed">
                            <?php echo esc_html($faq['a']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<?php get_footer(); ?>
