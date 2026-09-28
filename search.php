<?php get_header(); ?>

<div class="pt-24 sm:pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php veeping_breadcrumb(); ?>
    
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl font-black text-white mb-4">
            نتایج جستجو برای: <span class="text-neon-gold"><?php echo get_search_query(); ?></span>
        </h1>
        <p class="text-gray-400"><?php printf(_n('%s نتیجه یافت شد', '%s نتیجه یافت شد', (int) $GLOBALS['wp_query']->found_posts, 'veeping'), number_format_i18n((int) $GLOBALS['wp_query']->found_posts)); ?></p>
    </div>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', get_post_type()); ?>
            <?php endwhile; ?>
        </div>
        <div class="mt-12">
            <?php the_posts_pagination(array(
                'prev_text' => '<i class="fa-solid fa-arrow-right"></i>',
                'next_text' => '<i class="fa-solid fa-arrow-left"></i>',
            )); ?>
        </div>
    <?php else : ?>
        <div class="glass-card rounded-2xl p-12 text-center">
            <i class="fa-solid fa-search text-6xl text-gray-600 mb-6"></i>
            <h2 class="text-2xl font-black text-white mb-3">نتیجه‌ای یافت نشد!</h2>
            <p class="text-gray-400 mb-6">لطفاً با کلمات کلیدی دیگری جستجو کنید.</p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
