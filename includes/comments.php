<?php
/**
 * Comments - Veeping
 */

if (!defined('ABSPATH')) exit;

function veeping_comment_form_defaults($defaults) {
    $defaults['comment_field'] = '<p class="comment-form-comment mb-4"><label for="comment" class="block text-gray-300 font-bold mb-2 text-sm">دیدگاه شما</label><textarea id="comment" name="comment" rows="6" class="w-full bg-dark-800/60 border border-white/10 rounded-lg p-3 text-white focus:border-neon-gold focus:outline-none focus:ring-2 focus:ring-neon-gold/30" required></textarea></p>';
    $defaults['comment_notes_before'] = '';
    $defaults['title_reply'] = '';
    return $defaults;
}
add_filter('comment_form_defaults', 'veeping_comment_form_defaults');

function veeping_comment_form_class($class) {
    $class['form'] .= ' space-y-4';
    return $class;
}
add_filter('comment_form_class', 'veeping_comment_form_class');

class Veeping_Comment_Walker extends Walker_Comment {
    protected function html5_comment($comment, $depth, $args) {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('glass-card p-6 rounded-2xl mb-4'); ?>>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <?php echo get_avatar($comment, 48, '', '', array('class' => 'w-12 h-12 rounded-full border-2 border-neon-gold/30')); ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-2 flex-wrap gap-2">
                        <div>
                            <span class="font-black text-white"><?php comment_author(); ?></span>
                            <?php if ((int) $comment->user_id === (int) get_the_author_meta('ID')) : ?>
                                <span class="text-xs bg-neon-gold/20 text-neon-gold px-2 py-0.5 rounded mr-2">نویسنده</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs text-gray-500">
                            <i class="fa-regular fa-clock ml-1"></i>
                            <?php echo esc_html(human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' پیش'); ?>
                        </span>
                    </div>
                    <div class="text-gray-300 leading-relaxed"><?php comment_text(); ?></div>
                    <div class="mt-3 text-sm">
                        <?php
                        comment_reply_link(array_merge($args, array(
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                        )));
                        ?>
                    </div>
                </div>
            </div>
        </<?php echo $tag; ?>>
    <?php
    }
}
