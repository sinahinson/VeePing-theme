<?php get_header(); ?>

<div class="pt-32 pb-20 min-h-[70vh] flex items-center justify-center">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="glass-card rounded-3xl p-12 relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-neon-gold/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-neon-blue/10 rounded-full blur-3xl"></div>
            
            <h1 class="text-9xl font-black text-gradient mb-4">404</h1>
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">صفحه مورد نظر یافت نشد!</h2>
            <p class="text-gray-400 mb-8">متأسفانه صفحه‌ای که جستجو می‌کردید وجود ندارد یا منتقل شده است.</p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-neon-gold to-orange-500 text-dark-900 px-8 py-3 rounded-xl font-black transition hover:scale-105">
                    <i class="fa-solid fa-home"></i> بازگشت به خانه
                </a>
                <button onclick="history.back()" class="inline-flex items-center justify-center gap-2 border border-white/20 bg-white/5 text-white px-8 py-3 rounded-xl font-bold transition hover:bg-white/10">
                    <i class="fa-solid fa-arrow-right"></i> بازگشت به عقب
                </button>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
