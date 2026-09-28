<?php get_header(); ?>

<div class="pt-24 sm:pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php veeping_breadcrumb(); ?>

    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl font-black text-white mb-4">
            <?php if (is_home() && !is_front_page()) : ?>
                <?php single_post_title(); ?>
            <?php else : ?>
                آخرین مطالب
            <?php endif; ?>
        </h1>
        <p class="text-gray-400">تازه‌ترین مقالات و اخبار را در اینجا بخوانید.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', get_post_type()); ?>
                    <?php endwhile; ?>
                </div>
                <div class="mt-12">
                    <?php the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '<i class="fa-solid fa-arrow-right"></i>',
                        'next_text' => '<i class="fa-solid fa-arrow-left"></i>',
                    )); ?>
                </div>
            <?php else : ?>
                <?php get_template_part('template-parts/content', 'none'); ?>
            <?php endif; ?>
        </main>

        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <!-- Sidebar -->
            <aside class="lg:w-72 flex-shrink-0">
                <div class="lg:sticky lg:top-28">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div>
            </aside>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
