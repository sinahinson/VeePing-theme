<?php get_header(); ?>

<div class="pt-24 sm:pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php veeping_breadcrumb(); ?>
    
    <div class="text-center mb-12">
        <h1 class="text-3xl sm:text-4xl font-black text-white mb-4">
            <?php echo get_the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="text-gray-400 max-w-2xl mx-auto"><?php echo get_the_archive_description(); ?></div>
        <?php else : ?>
            <p class="text-gray-400"><?php printf(__('تعداد %s مطلب در این دسته', 'veeping'), $GLOBALS['wp_query']->found_posts); ?></p>
        <?php endif; ?>
    </div>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', get_post_type()); ?>
            <?php endwhile; ?>
        </div>
        <div class="mt-12">
            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '<i class="fa-solid fa-arrow-right"></i>',
                'next_text' => '<i class="fa-solid fa-arrow-left"></i>',
            )); ?>
        </div>
    <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
