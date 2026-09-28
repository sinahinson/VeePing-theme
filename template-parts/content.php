<article id="post-<?php the_ID(); ?>" <?php post_class('glass-card rounded-2xl overflow-hidden hover:bg-white/5 transition duration-300 group'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden bg-dark-800">
            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition duration-500')); ?>
        </a>
    <?php endif; ?>
    
    <div class="p-6">
        <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
            <span><i class="fa-regular fa-calendar ml-1"></i><?php echo get_the_date(); ?></span>
            <?php if (has_category()) : ?>
                <span><i class="fa-solid fa-folder ml-1"></i><?php the_category('، '); ?></span>
            <?php endif; ?>
        </div>

        <h2 class="text-xl font-black text-white mb-3 group-hover:text-neon-gold transition line-clamp-2">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <p class="text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </p>

        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-neon-gold hover:text-yellow-400 font-bold text-sm transition">
            ادامه مطلب <i class="fa-solid fa-arrow-left text-xs"></i>
        </a>
    </div>
</article>
