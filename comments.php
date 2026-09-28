<?php if (post_password_required()) return; ?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
            <i class="fa-regular fa-comments text-neon-gold"></i>
            <?php comments_number('بدون دیدگاه', '۱ دیدگاه', '% دیدگاه'); ?>
        </h2>
        
        <ol class="comment-list">
            <?php wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'veeping_comment_callback',
                'avatar_size'=> 50,
            )); ?>
        </ol>

        <?php the_comments_pagination(array(
            'prev_text' => '<i class="fa-solid fa-arrow-right"></i>',
            'next_text' => '<i class="fa-solid fa-arrow-left"></i>',
        )); ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="text-gray-400 glass-card p-6 rounded-2xl">دیدگاه‌ها بسته شده‌اند.</p>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>
