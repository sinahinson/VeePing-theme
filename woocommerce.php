<?php get_header(); ?>

<?php if (is_shop() || is_product_taxonomy()) : ?>
    <div class="pt-20 sm:pt-28 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php veeping_breadcrumb(); ?>

        <div class="text-center mt-6 mb-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-neon-gold/10 border border-neon-gold/30 text-neon-gold text-xs font-black tracking-wider mb-4">
                <i class="fa-solid fa-bag-shopping"></i>
                فروشگاه
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3 leading-tight">
                <?php woocommerce_page_title(); ?>
            </h1>
            <div class="text-gray-400 max-w-xl mx-auto text-sm sm:text-base">
                <?php do_action('woocommerce_archive_description'); ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="pt-24 sm:pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<?php endif; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <?php
    // Sidebar and content wrapper
    ?>
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

        <!-- Sidebar -->
        <aside class="lg:w-64 flex-shrink-0">
            <?php veeping_shop_categories_widget(); ?>
            <?php if (is_active_sidebar('sidebar-shop')) : ?>
                <?php dynamic_sidebar('sidebar-shop'); ?>
            <?php endif; ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <?php
            woocommerce_content();
            ?>
        </main>

    </div>
</div>

<?php get_footer(); ?>
