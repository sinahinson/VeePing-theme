<?php
/**
 * Single Product Page - Override WooCommerce Template
 * @package VeePing
 */

defined('ABSPATH') || exit;

get_header();
?>

<div class="pt-20 sm:pt-28 pb-20 min-h-screen relative overflow-hidden">
    
    <!-- پس‌زمینه تزئینی -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-neon-gold/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-neon-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php veeping_breadcrumb(); ?>
        
        <?php while (have_posts()) : the_post(); global $product; ?>
            
            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12', $product); ?>>
                
                <!-- ============ گالری محصول ============ -->
                <div class="reveal-left max-w-sm mx-auto lg:mx-0 lg:max-w-none w-full" x-data="{ activeImage: 0 }">
                    
                    <!-- تصویر اصلی -->
                    <div class="glass-card rounded-2xl p-3 mb-3 relative overflow-hidden group max-w-xs mx-auto lg:mx-0">
                        <div class="absolute inset-0 bg-gradient-to-br from-neon-gold/5 via-transparent to-neon-blue/5 pointer-events-none"></div>
                        
                        <?php if ($product->is_on_sale()) : ?>
                            <span class="absolute top-4 right-4 z-20 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-black px-3 py-1 rounded-full shadow-lg shadow-red-500/30">
                                <i class="fa-solid fa-fire ml-1"></i>تخفیف ویژه
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($product->is_featured()) : ?>
                            <span class="absolute top-4 left-4 z-20 bg-gradient-to-r from-neon-gold to-orange-500 text-dark-900 text-xs font-black px-3 py-1 rounded-full shadow-lg shadow-neon-gold/30">
                                <i class="fa-solid fa-star ml-1"></i>محصول ویژه
                            </span>
                        <?php endif; ?>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="relative aspect-square rounded-xl overflow-hidden bg-dark-800/50">
                                <?php
                                $gallery_ids = $product->get_gallery_image_ids();
                                $main_image_id = $product->get_image_id();
                                
                                if ($main_image_id) :
                                    echo wp_get_attachment_image($main_image_id, 'medium', false, array(
                                        'class' => 'w-full h-full object-contain p-4 transition-all duration-500',
                                        'x-show' => 'activeImage === 0',
                                        'x-transition:enter' => 'transition ease-out duration-300',
                                        'x-transition:enter-start' => 'opacity-0 scale-95',
                                        'x-transition:enter-end' => 'opacity-100 scale-100',
                                    ));
                                endif;
                                
                                if (!empty($gallery_ids)) :
                                    foreach ($gallery_ids as $index => $img_id) :
                                        echo wp_get_attachment_image($img_id, 'medium', false, array(
                                            'class' => 'w-full h-full object-contain p-4 absolute inset-0 transition-all duration-500',
                                            'x-show' => 'activeImage === ' . ($index + 1),
                                            'x-transition:enter' => 'transition ease-out duration-300',
                                            'x-transition:enter-start' => 'opacity-0 scale-95',
                                            'x-transition:enter-end' => 'opacity-100 scale-100',
                                            'style' => 'display: none;',
                                        ));
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        <?php else : ?>
                            <div class="aspect-square rounded-xl bg-dark-800/50 flex items-center justify-center">
                                <i class="fa-solid fa-cube text-6xl text-neon-gold/20"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- گالری کوچک -->
                    <?php
                    $gallery_ids = $product->get_gallery_image_ids();
                    $main_image_id = $product->get_image_id();
                    $all_images = array();
                    if ($main_image_id) $all_images[] = $main_image_id;
                    if (!empty($gallery_ids)) $all_images = array_merge($all_images, $gallery_ids);
                    
                    if (count($all_images) > 1) : ?>
                        <div class="grid grid-cols-5 gap-2 max-w-xs mx-auto lg:mx-0">
                            <?php foreach ($all_images as $index => $img_id) : ?>
                                <button @click="activeImage = <?php echo $index; ?>" 
                                        :class="activeImage === <?php echo $index; ?> ? 'ring-2 ring-neon-gold scale-105' : 'ring-1 ring-white/10'"
                                        aria-label="<?php echo esc_attr(sprintf('نمایش تصویر %1$d از %2$d', $index + 1, count($all_images))); ?>"
                                        class="aspect-square rounded-lg overflow-hidden bg-dark-800 transition-all duration-300 hover:scale-105">
                                    <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, array('class' => 'w-full h-full object-cover', 'alt' => '')); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                
                <!-- ============ اطلاعات محصول ============ -->
                <div class="reveal-right">
                    
                    <!-- عنوان -->
                    <h1 class="reveal delay-100 text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <!-- امتیاز و تعداد فروش -->
                    <div class="reveal delay-200 flex items-center gap-4 mb-6 flex-wrap">
                        <?php if ($product->get_review_count() > 0) : ?>
                            <div class="flex items-center gap-2">
                                <div class="flex text-neon-gold">
                                    <?php echo str_repeat('<i class="fa-solid fa-star"></i>', 5); ?>
                                </div>
                                <span class="text-gray-300 text-sm font-bold"><?php echo esc_html($product->get_average_rating()); ?></span>
                                <span class="text-gray-500 text-sm">(<?php echo esc_html($product->get_review_count()); ?> دیدگاه)</span>
                            </div>
                        <?php endif; ?>
                        
                        <?php $total_sales = (int) $product->get_total_sales(); ?>
                        <?php if ($total_sales > 0) : ?>
                            <span class="text-gray-500">|</span>
                            <span class="text-sm text-gray-400">
                                <i class="fa-solid fa-fire text-orange-400 ml-1"></i>
                                <?php echo esc_html(number_format_i18n($total_sales)); ?> فروش موفق
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($product->is_in_stock()) : ?>
                            <span class="text-gray-500">|</span>
                            <span class="text-sm text-green-400 font-bold">
                                <i class="fa-solid fa-check-circle ml-1"></i>موجود در انبار
                            </span>
                        <?php else : ?>
                            <span class="text-gray-500">|</span>
                            <span class="text-sm text-red-400 font-bold">
                                <i class="fa-solid fa-xmark ml-1"></i>ناموجود
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- قیمت -->
                    <?php if (!$product->is_type('variable')) : ?>
                    <div class="reveal delay-300 glass-card rounded-2xl p-6 mb-6 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-neon-gold/10 rounded-full blur-3xl"></div>
                        <div class="relative">
                            <p class="text-gray-500 text-sm mb-1">قیمت محصول:</p>
                            <div class="flex items-baseline gap-3 flex-wrap">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="text-4xl sm:text-5xl font-black text-neon-gold"><?php echo wc_price($product->get_sale_price()); ?></span>
                                    <span class="text-2xl text-gray-500 line-through"><?php echo wc_price($product->get_regular_price()); ?></span>
                                    <?php
                                    $regular = (float)$product->get_regular_price();
                                    $sale = (float)$product->get_sale_price();
                                    if ($regular > 0) :
                                        $discount = round((($regular - $sale) / $regular) * 100);
                                    ?>
                                        <span class="bg-red-500/20 text-red-400 text-sm font-black px-3 py-1 rounded-full">
                                            <?php echo $discount; ?>٪ تخفیف
                                        </span>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <span class="text-4xl sm:text-5xl font-black <?php echo $product->get_regular_price() ? 'fancy-text' : 'text-white'; ?>">
                                        <?php echo $product->get_regular_price() ? wc_price($product->get_regular_price()) : __('رایگان', 'veeping'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if ($product->get_regular_price()) : ?>
                                <p class="text-gray-500 text-xs mt-2">
                                    <i class="fa-solid fa-shield-halved text-neon-gold ml-1"></i>
                                    تضمین بهترین قیمت و پشتیبانی ۲۴/۷
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- توضیحات کوتاه -->
                    <?php if ($product->get_short_description()) : ?>
                        <div class="reveal delay-400 glass-card rounded-2xl p-6 mb-6">
                            <h2 class="text-sm font-black text-neon-gold mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info"></i>
                                معرفی محصول
                            </h2>
                            <div class="text-gray-300 leading-relaxed">
                                <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- افزودن به سبد خرید -->
                    <div class="reveal delay-500 mb-6">
                        <?php if ($product->is_type('variable')) : ?>
                            <p class="text-gray-500 text-xs mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-info text-neon-gold"></i>
                                برای مشاهده قیمت، ابتدا یکی از گزینه‌های زیر را انتخاب کنید
                            </p>
                        <?php endif; ?>
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>
                    
                    <!-- ویژگی‌های سریع -->
                    <div class="reveal grid grid-cols-3 gap-3 mb-6">
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-headset text-green-400 text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">پشتیبانی ۲۴ ساعته</p>
                        </div>
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-bolt-lightning text-neon-gold text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">پرسرعت</p>
                        </div>
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-gauge-high text-neon-blue text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">پینگ پایین</p>
                        </div>
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-unlock-keyhole text-neon-purple text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">تحریم‌شکن</p>
                        </div>
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-medal text-neon-gold text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">بهترین کیفیت</p>
                        </div>
                        <div class="glass-card p-3 sm:p-4 rounded-xl text-center hover:bg-white/5 hover:-translate-y-0.5 transition-all duration-300 group">
                            <i class="fa-solid fa-wand-magic-sparkles text-green-400 text-xl sm:text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[11px] sm:text-xs text-gray-300 font-bold">خرید اتوماتیک</p>
                        </div>
                    </div>
                    
                    <!-- نوار آماری اعتمادسازی -->
                    <div class="reveal glass-card rounded-2xl p-5 mb-6 grid grid-cols-3 divide-x divide-x-reverse divide-white/5 text-center">
                        <div>
                            <p class="text-xl sm:text-2xl font-black text-gradient"><?php echo esc_html(get_theme_mod('veeping_stat1', '99.9%')); ?></p>
                            <p class="text-[11px] text-gray-500 mt-1"><?php echo esc_html(get_theme_mod('veeping_stat1_label', 'آپتایم سرور')); ?></p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-black text-gradient"><?php echo esc_html(get_theme_mod('veeping_stat2', '25ms')); ?></p>
                            <p class="text-[11px] text-gray-500 mt-1"><?php echo esc_html(get_theme_mod('veeping_stat2_label', 'میانگین پینگ')); ?></p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-black text-gradient"><?php echo esc_html(get_theme_mod('veeping_stat3', '24/7')); ?></p>
                            <p class="text-[11px] text-gray-500 mt-1"><?php echo esc_html(get_theme_mod('veeping_stat3_label', 'پشتیبانی آنلاین')); ?></p>
                        </div>
                    </div>
                    
                    <!-- SKU و برچسب‌ها -->
                    <?php
                    $show_sku = wc_product_sku_enabled() && $product->get_sku();
                    $tags = get_the_terms(get_the_ID(), 'product_tag');
                    $show_tags = $tags && !is_wp_error($tags);
                    if ($show_sku || $show_tags) :
                    ?>
                    <div class="reveal glass-card rounded-2xl p-5 text-sm space-y-2">
                        <?php if ($show_sku) : $sku = $product->get_sku(); ?>
                            <p class="text-gray-400 flex items-center gap-2">
                                <i class="fa-solid fa-barcode text-neon-gold w-5"></i>
                                <span>کد محصول:</span>
                                <span class="text-white font-bold"><?php echo esc_html($sku); ?></span>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($show_tags) : ?>
                            <p class="text-gray-400 flex items-center gap-2 flex-wrap">
                                <i class="fa-solid fa-tags text-neon-gold w-5"></i>
                                <span>برچسب‌ها:</span>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="text-xs bg-white/5 px-2 py-1 rounded text-gray-300 hover:bg-neon-gold/20 hover:text-neon-gold transition">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
            
            <!-- ============ تب‌های محصول (سفارشی) ============ -->
            <div class="reveal mt-20" x-data="{ activeTab: 'description' }">
                <div class="glass-card rounded-3xl overflow-hidden">
                    
                    <!-- سربرگ تب‌ها -->
                    <div class="flex border-b border-white/5 overflow-x-auto">
                        <button @click="activeTab = 'description'" 
                                :class="activeTab === 'description' ? 'text-neon-gold border-b-2 border-neon-gold bg-white/5' : 'text-gray-400 hover:text-white'"
                                class="flex-1 min-w-[120px] px-6 py-4 text-sm font-black transition whitespace-nowrap">
                            <i class="fa-solid fa-align-right ml-2"></i>توضیحات کامل
                        </button>
                        
                        <?php if ($product->has_attributes() || $product->is_type('variable')) : ?>
                            <button @click="activeTab = 'specs'" 
                                    :class="activeTab === 'specs' ? 'text-neon-gold border-b-2 border-neon-gold bg-white/5' : 'text-gray-400 hover:text-white'"
                                    class="flex-1 min-w-[120px] px-6 py-4 text-sm font-black transition whitespace-nowrap">
                                <i class="fa-solid fa-list-check ml-2"></i>مشخصات فنی
                            </button>
                        <?php endif; ?>
                        
                        <button @click="activeTab = 'reviews'" 
                                :class="activeTab === 'reviews' ? 'text-neon-gold border-b-2 border-neon-gold bg-white/5' : 'text-gray-400 hover:text-white'"
                                class="flex-1 min-w-[120px] px-6 py-4 text-sm font-black transition whitespace-nowrap">
                            <i class="fa-solid fa-comments ml-2"></i>دیدگاه‌ها (<?php echo $product->get_review_count(); ?>)
                        </button>
                    </div>
                    
                    <!-- محتوای تب‌ها -->
                    
                    <!-- تب توضیحات -->
                    <div x-show="activeTab === 'description'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="p-8 entry-content text-gray-300 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- تب مشخصات فنی -->
                    <?php if ($product->has_attributes() || $product->is_type('variable')) : ?>
                        <div x-show="activeTab === 'specs'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="display: none;"
                             class="p-8">
                            <?php
                            // ویژگی‌های محصول
                            $attributes = $product->get_attributes();
                            if (!empty($attributes)) :
                            ?>
                                <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                                    <i class="fa-solid fa-list-check text-neon-gold"></i>
                                    مشخصات محصول
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php foreach ($attributes as $attribute) : 
                                        $values = wc_get_product_terms($product->get_id(), $attribute['name'], array('fields' => 'names'));
                                    ?>
                                        <div class="glass-card p-4 rounded-xl">
                                            <p class="text-xs text-neon-gold font-bold mb-1"><?php echo wc_attribute_label($attribute['name']); ?></p>
                                            <p class="text-white font-bold"><?php echo esc_html(implode('، ', $values)); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product->is_type('variable')) :
                                $variations = $product->get_available_variations();
                                if (!empty($variations)) : ?>
                                    <h3 class="text-2xl font-black text-white mt-8 mb-6 flex items-center gap-2">
                                        <i class="fa-solid fa-layer-group text-neon-blue"></i>
                                        تنوع محصول
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <?php foreach ($variations as $variation) :
                                            $price = $variation['display_price'];
                                            $attrs = $variation['attributes'];
                                        ?>
                                            <div class="glass-card p-4 rounded-xl border border-white/5 hover:border-neon-gold/30 transition">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div class="text-white font-bold text-sm">
                                                        <?php foreach ($attrs as $attr_name => $attr_value) : ?>
                                                            <span class="text-neon-gold"><?php echo esc_html(wc_attribute_label(str_replace('attribute_', '', $attr_name))); ?>:</span>
                                                            <?php echo esc_html($attr_value); ?><br>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <span class="text-neon-gold font-black"><?php echo wc_price($price); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- تب دیدگاه‌ها -->
                    <div x-show="activeTab === 'reviews'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="p-8">
                        
                        <?php
                        // دیدگاه‌ها
                        $reviews = get_comments(array(
                            'post_id' => get_the_ID(),
                            'status'  => 'approve',
                            'type'    => 'review',
                        ));
                        
                        if ($reviews) : ?>
                            <div class="space-y-4 mb-8">
                                <?php foreach ($reviews as $review) :
                                    $rating = get_comment_meta($review->comment_ID, 'rating', true);
                                ?>
                                    <div class="glass-card rounded-2xl p-6">
                                        <div class="flex items-start gap-4">
                                            <?php echo get_avatar($review, 50, '', '', array('class' => 'w-12 h-12 rounded-full border-2 border-neon-gold/30')); ?>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2 flex-wrap gap-2">
                                                    <p class="font-black text-white m-0"><strong><?php echo esc_html($review->comment_author); ?></strong></p>
                                                    <span class="text-xs text-gray-500"><?php echo human_time_diff(get_comment_time('U', true, $review), current_time('timestamp')) . ' پیش'; ?></span>
                                                </div>
                                                <?php if ($rating) : ?>
                                                    <div class="flex text-neon-gold text-sm mb-2">
                                                        <?php echo str_repeat('<i class="fa-solid fa-star"></i>', (int)$rating); ?>
                                                        <?php echo str_repeat('<i class="fa-regular fa-star"></i>', 5 - (int)$rating); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <p class="text-gray-300 leading-relaxed"><?php echo esc_html($review->comment_content); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-12">
                                <i class="fa-regular fa-comments text-6xl text-gray-600 mb-4"></i>
                                <p class="text-gray-400 mb-6">هنوز دیدگاهی برای این محصول ثبت نشده است.</p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- فرم ثبت دیدگاه -->
                        <?php if (comments_open()) : ?>
                            <div class="glass-card rounded-2xl p-6">
                                <h4 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square text-neon-gold"></i>
                                    ثبت دیدگاه
                                </h4>
                                <?php
                                comment_form(array(
                                    'title_reply'         => '',
                                    'title_reply_to'      => '',
                                    'title_reply_before'  => '',
                                    'title_reply_after'   => '',
                                    'comment_notes_before' => '<p class="text-gray-400 text-sm mb-4">ایمیل شما منتشر نخواهد شد. فیلدهای الزامی با * مشخص شده‌اند.</p>',
                                    'label_submit'        => 'ارسال دیدگاه',
                                    'class_form'          => 'space-y-4',
                                ), get_the_ID());
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            
            
            <!-- ============ محصولات مرتبط ============ -->
            <?php
            $related_ids = wc_get_related_products(get_the_ID(), 4);
            if (!empty($related_ids)) : ?>
                <div class="mt-20">
                    <div class="text-center mb-12">
                        <span class="reveal inline-block px-4 py-1.5 rounded-full bg-neon-blue/10 border border-neon-blue/30 text-neon-blue text-xs font-black tracking-wider mb-4">محصولات مشابه</span>
                        <h2 class="reveal delay-100 text-3xl sm:text-4xl font-black text-white mb-3">
                            محصولات <span class="fancy-text">مرتبط</span>
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($related_ids as $related_id) :
                            $related = wc_get_product($related_id);
                            if (!$related) continue;
                        ?>
                            <div class="reveal-scale delay-100 group">
                                <div class="glass-card rounded-2xl overflow-hidden hover:bg-white/5 transition-all duration-500 hover:-translate-y-2">
                                    <a href="<?php echo esc_url(get_permalink($related_id)); ?>" class="block aspect-square overflow-hidden bg-dark-800 relative">
                                        <?php if ($related->get_image_id()) : ?>
                                            <?php echo wp_get_attachment_image($related->get_image_id(), 'medium', false, array('class' => 'w-full h-full object-cover group-hover:scale-110 transition duration-500')); ?>
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fa-solid fa-cube text-6xl text-neon-gold/20"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($related->is_on_sale()) : ?>
                                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-black px-2 py-1 rounded-full">تخفیف</span>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <div class="p-4">
                                        <p class="font-black text-white mb-2 line-clamp-1 group-hover:text-neon-gold transition">
                                            <strong><?php echo esc_html($related->get_name()); ?></strong>
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-neon-gold font-black"><?php echo $related->get_price_html(); ?></span>
                                            <span class="text-xs text-gray-500 group-hover:text-neon-gold transition">
                                                مشاهده <i class="fa-solid fa-arrow-left"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>