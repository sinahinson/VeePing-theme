<article id="post-<?php the_ID(); ?>" <?php post_class('glass-card rounded-2xl p-8'); ?>>
    <h1 class="text-3xl sm:text-4xl font-black text-white mb-6"><?php the_title(); ?></h1>
    <?php if (post_password_required()) : ?>
        <div class="entry-content"><?php echo get_the_password_form(); ?></div>
    <?php else : ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>
</article>
