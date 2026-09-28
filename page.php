<?php get_header(); ?>

<div class="pt-24 sm:pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php veeping_breadcrumb(); ?>
    
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content', 'page'); ?>
        
        <?php if (comments_open() || get_comments_number()) : ?>
            <div class="mt-8">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
