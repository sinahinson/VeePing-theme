<article id="post-<?php the_ID(); ?>" <?php post_class('glass-card rounded-2xl overflow-hidden'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="aspect-video overflow-hidden bg-dark-800">
            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
        </div>
    <?php endif; ?>
    
    <div class="p-8">
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 flex-wrap">
            <span class="flex items-center gap-1"><i class="fa-regular fa-calendar"></i><?php echo get_the_date(); ?></span>
            <span class="flex items-center gap-1"><i class="fa-regular fa-user"></i><?php the_author(); ?></span>
            <?php if (has_category()) : ?>
                <span class="flex items-center gap-1"><i class="fa-solid fa-folder"></i><?php the_category('، '); ?></span>
            <?php endif; ?>
            <span class="flex items-center gap-1"><i class="fa-regular fa-comments"></i><?php comments_number('بدون دیدگاه', '۱ دیدگاه', '% دیدگاه'); ?></span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-black text-white mb-6 leading-tight"><?php the_title(); ?></h1>

        <?php if (post_password_required()) : ?>
            <div class="entry-content"><?php echo get_the_password_form(); ?></div>
        <?php else : ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php if (has_tag()) : ?>
                <div class="mt-8 pt-6 border-t border-white/5">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-gray-500 text-sm font-bold ml-2"><i class="fa-solid fa-tags ml-1"></i>برچسب‌ها:</span>
                        <?php the_tags('', ' ', ''); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</article>

<?php if (!post_password_required()) : ?>
<?php the_post_navigation(array(
    'prev_text' => '<span class="text-sm text-gray-500">مطلب قبلی</span><span class="text-white font-bold">%title</span>',
    'next_text' => '<span class="text-sm text-gray-500">مطلب بعدی</span><span class="text-white font-bold">%title</span>',
    'class'     => 'mt-8 flex justify-between gap-4',
)); ?>
<?php endif; ?>

<?php if (!post_password_required() && (comments_open() || get_comments_number())) : ?>
    <div class="mt-12">
        <?php comments_template(); ?>
    </div>
<?php endif; ?>
